<?php

namespace App\Exceptions;

use Exception;
use App\Mail\ExceptionOccured;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use \Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            if (config("configure.emails.mail_is_open")) {
                $this->sendEmail($exception);
            }
        } else {
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Sends an email to the developer about the exception.
     *'url' => $request->fullUrl(),
     *'request' => $request->all(),
     *'method' => $request->getMethod(),
     *'header' => $request->header(),
     * @param  \Exception $exception
     * @return void
     */
    public function sendEmail(Exception $exception)
    {
        try {
            $userInfo=session("userInfo");
            $toUsers=config("configure.emails.mail_to_address");
            $opt="未登录";
            if($userInfo!=false)
            {
                $opt=$userInfo->id."-".$userInfo->nickname;
            }
            $e = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $content = $handler->getHtml($e);
            $html = [
                'message' => $exception->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'content' => $content,
                'opt'=>$opt,
                'deal'=>implode("|",array_column($toUsers,"name",null))
            ];
           Mail::send("emails.exception",["html"=>$html],function($message) use($toUsers){
               $message->to(array_pluck($toUsers,"addr"));
               $message->subject(config("configure.emails.mail_title").$_SERVER["SERVER_NAME"]);
           });
        } catch (Exception $ex) {
            dd($ex);
        } finally {
            abort($e->getStatusCode());
        }
    }
}
