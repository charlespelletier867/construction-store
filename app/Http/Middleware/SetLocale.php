<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supported = ['en', 'km'];
        $locale = $request->session()->get('locale')
            ?? $request->header('X-Locale')
            ?? config('app.locale');

        if (! in_array($locale, $supported, true)) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
