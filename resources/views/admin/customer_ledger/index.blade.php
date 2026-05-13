@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.customer_ledger'))

@section('content')
<div class="card">
    <div class="card-header"><h5 class="mb-0">{{ __('admin.menu.customer_ledger') }}</h5></div>
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
                    @forelse($customers as $c)
                        <tr>
                            <td>{{ $c->customer_code }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->phone }}</td>
                            <td class="text-end">{{ number_format((float) $c->current_balance, 2) }}</td>
                            <td><a href="{{ route('admin.customer_ledger.show', $c) }}" class="btn btn-sm btn-outline-primary">{{ __('admin.action.view') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No customers</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $customers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
