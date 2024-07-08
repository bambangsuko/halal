<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
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
        $locale = $request->segment(1);

        if (empty($locale) || !in_array($locale, config('app.locales'))) {
            session()->put('locale', app()->getLocale());

            return redirect(app()->getLocale());
        }

        if($locale !== session('locale')){
            session()->put('locale', $locale);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
