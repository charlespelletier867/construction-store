@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.report_payable'))

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>{{ __('admin.field.supplier') }}</th><th>{{ __('admin.field.phone') }}</th><th class="text-end">Balance</th></tr></thead>
            <tbody>
                @forelse($rows as $s)
                    <tr><td>{{ $s->name }}</td><td>{{ $s->phone }}</td><td class="text-end">{{ number_format((float) $s->current_balance, 2) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-4">No payable balances</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $rows->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
