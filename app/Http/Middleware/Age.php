<?php

namespace App\Http\Middleware;

use Closure;

class Age
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Jika umur dibawah 17 tahun, akan diredirect ke method /fail
        if ($request->age < 17) {
            return redirect('/age-fail');
        }

        // Jika umur di atas 17 tahun, aplikasi akan melanjutkan permintaan yg dikirim oleh user
        return $next($request);
    }
}
