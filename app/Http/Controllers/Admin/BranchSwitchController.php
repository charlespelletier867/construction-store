<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BranchSwitchController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $request->validate(['branch_id' => ['required', 'integer']]);

        $branch = Branch::query()
            ->where('id', $request->integer('branch_id'))
            ->where('company_id', $request->user()->company_id)
            ->first();

        if (! $branch) {
            return back()->withErrors(['branch_id' => 'Branch not found.']);
        }

        $request->session()->put('current_branch_id', $branch->id);
        $request->session()->put('current_branch_name', $branch->name);

        flash()->success(__('admin.alert.updated') . ': ' . __('admin.menu.branch'));

        return back();
    }
}
