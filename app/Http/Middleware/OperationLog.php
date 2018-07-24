<?php

namespace App\Http\Middleware;

use App\Http\Model\Log\Operation;
use App\Http\Model\Log\Visiting;
use Closure;

class OperationLog
{
    public function handle($request, Closure $next)
    {
        //操作日志
        if('GET' != $request->method()){
            $log = new Operation(); #操作日志
        }else{
            //访问日志
            $log = new Visiting(); #访问日志
        }
        $input = $request->all();
        $log->uid = session('userInfo')?session('userInfo')->id:0;
        $log->path = $request->path();
        $log->method = $request->method();
        $log->ip = $request->ip();
        $log->sql = '';
        $log->input = json_encode($input, JSON_UNESCAPED_UNICODE);
        $log->save();   # 记录日志
        return $next($request);
    }
}