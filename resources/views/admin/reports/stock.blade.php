@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.report_stock'))

@section('content')
<div class="card">
    <div class="card-header"><h5 class="mb-0">{{ __('admin.menu.report_stock') }}</h5></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>{{ __('admin.field.product') }}</th>
                    <th>{{ __('admin.field.warehouse') }}</th>
                    <th class="text-end">{{ __('admin.field.quantity') }}</th>
                    <th class="text-end">Avg Cost</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $r)
                    <tr>
                        <td>{{ $r->product->name ?? '-' }}</td>
                        <td>{{ $r->warehouse->name ?? '-' }}</td>
                        <td class="text-end">{{ number_format((float) $r->quantity_on_hand, 2) }}</td>
                        <td class="text-end">{{ number_format((float) $r->average_cost, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No stock balances</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $rows->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
