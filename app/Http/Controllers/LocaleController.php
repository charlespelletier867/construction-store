<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): JsonResponse
    {
        $supported = ['en', 'km'];
        if (! in_array($locale, $supported, true)) {
            return response()->json(['ok' => false, 'error' => 'unsupported_locale'], 422);
        }

        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        return response()->json(['ok' => true, 'locale' => $locale]);
    }
}
