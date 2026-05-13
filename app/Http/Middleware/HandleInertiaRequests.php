<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => fn () => [
                'user' => $request->user(),
            ],
            'locale' => fn () => app()->getLocale(),
            'translations' => fn () => [
                'en' => trans('admin', [], 'en'),
                'km' => trans('admin', [], 'km'),
            ],
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'current_branch' => fn () => [
                'id' => $request->session()->get('current_branch_id'),
                'name' => $request->session()->get('current_branch_name'),
            ],
        ];
    }
}
