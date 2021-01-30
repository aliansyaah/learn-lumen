<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /* Script pengecekan token bisa disimpan di file Middleware->Authenticate ini,
            atau pada file Providers->AuthServiceProvider.
            Jika logic pengecekan sudah didefinisikan di sini, pengecekan di AuthServiceProvider
            tidak terbaca lagi.
        */
        if ($this->auth->guard($guard)->guest()) {
            // Jika pengecekan dilakukan di AuthServiceProvider, uncomment script ini.
            // return response('Unauthorized.', 401);
            // $res['success'] = false;
            // $res['message'] = 'Login please!';
            // return response($res, 401);

            // print_r($request);die;

            // if ($request->header('api_token')) {         // jika api_token disimpan di header
            if ($request->has('api_token')) {               // jika api_token disimpan di query params
                $token = $request->input('api_token');
                // $token = $request->header('api_token');

                $check_token = User::where('api_token', $token)->first();
                
                if (!$check_token || $check_token == null) {
                    $res['success'] = false;
                    $res['message'] = 'Permission not allowed!';

                    return response($res);
                }
            }else{
                $res['success'] = false;
                $res['message'] = 'Login please!';

                return response($res);
            }
        }

        return $next($request);
    }
}
