@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.supplier_ledger'))

@section('content')
<div class="card">
    <div class="card-header"><h5 class="mb-0">{{ __('admin.menu.supplier_ledger') }}</h5></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>{{ __('admin.field.code') }}</th>
                        <th>{{ __('admin.field.name') }}</th>
                        <th>{{ __('admin.field.phone') }}</th>
                        <th class="text-end">Current Balance</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $s)
                        <tr>
                            <td>{{ $s->supplier_code }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->phone }}</td>
                            <td class="text-end">{{ number_format((float) $s->current_balance, 2) }}</td>
                            <td><a href="{{ route('admin.supplier_ledger.show', $s) }}" class="btn btn-sm btn-outline-primary">{{ __('admin.action.view') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No suppliers</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $suppliers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
