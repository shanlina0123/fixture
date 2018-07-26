<?php

namespace App\Http\Middleware;

use App\Http\Model\Log\Operation;
use Closure;

class OperationLog
{
    public function handle($request, Closure $next)
    {
        try{
            //操作日志
            if('GET' != $request->method()) {
                $log = new Operation(); #操作日志
                $input = $request->all();
                $log->uid = session('userInfo') ? session('userInfo')->id : 0;
                $log->companyid = session('userInfo') ? session('userInfo')->companyid : 0;
                $log->path = $request->path();
                $log->method = $request->method();
                $log->ip = $request->ip();
                $log->sql = '';
                $log->input = json_encode($input, JSON_UNESCAPED_UNICODE);
                $log->save();   # 记录日志
            }

        } catch (\ErrorException $e) {

        }finally{
            return $next($request);
        }

    }
}