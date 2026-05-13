<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;

class SetCurrentBranch
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        if (! $request->session()->has('current_branch_id')) {
            $branch = Branch::query()
                ->where('company_id', $user->company_id)
                ->when($user->default_branch_id, fn ($q) => $q->where('id', $user->default_branch_id))
                ->first()
                ?? Branch::query()->where('company_id', $user->company_id)->first();

            if ($branch) {
                $request->session()->put('current_branch_id', $branch->id);
                $request->session()->put('current_branch_name', $branch->name);
            }
        }

        return $next($request);
    }
}
