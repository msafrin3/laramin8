<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;

class LogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = [];
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $data['ip_address'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            $data['ip_address'] = $request->ip();
        }
        if(Auth::check()) {
            $data['user_id'] = Auth::user()->id;
        }
        $data['user_agent'] = $request->server('HTTP_USER_AGENT');
        $data['url'] = url()->full();
        $data['method'] = $request->method();
        if($request->path() == 'login' && $request->method() == 'POST') {
            $data['params'] = json_encode($request->except(['password']), true);
        } else {
            $data['params'] = json_encode($request->all(), true);
        }
        Logs::create($data);
        return $next($request);
    }
}
