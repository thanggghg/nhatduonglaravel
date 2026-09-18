<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $default = $request->is('dat-ve*', 'booking-redirect', 'payments/*', 'api/internal/*')
            ? 'en'
            : (string) config('app.locale', 'vi');
        $requested = strtolower((string) $request->query('lang', $request->input('lang', $default)));
        $locale = in_array($requested, ['vi', 'en', 'ru'], true) ? $requested : $default;

        App::setLocale($locale);
        View::share('locale', $locale);

        return $next($request);
    }
}
