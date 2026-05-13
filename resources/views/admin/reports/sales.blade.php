@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.report_sales'))

@section('content')
<form method="GET" class="card mb-3">
    <div class="card-body row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">From</label>
            <input type="date" name="from" value="{{ $from->toDateString() }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">To</label>
            <input type="date" name="to" value="{{ $to->toDateString() }}" class="form-control">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary">{{ __('admin.action.filter') }}</button>
        </div>
    </div>
</form>

<div class="row g-3 mb-3">
    <div class="col-md-4"><div class="card"><div class="card-body"><p class="text-muted mb-1">Total Sales</p><h4 class="mb-0">{{ number_format((float) $totals['total_sales'], 2) }}</h4></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><p class="text-muted mb-1">Total Paid</p><h4 class="mb-0">{{ number_format((float) $totals['total_paid'], 2) }}</h4></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><p class="text-muted mb-1">Total Due</p><h4 class="mb-0">{{ number_format((float) $totals['total_due'], 2) }}</h4></div></div></div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.field.date') }}</th>
                    <th>{{ __('admin.field.branch') }}</th>
                    <th class="text-end">{{ __('admin.field.total') }}</th>
                    <th class="text-end">{{ __('admin.field.paid') }}</th>
                    <th class="text-end">{{ __('admin.field.due') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr>
                        <td>{{ $row->sale_no }}</td>
                        <td>{{ $row->sale_date }}</td>
                        <td>{{ $row->branch->name ?? '-' }}</td>
                        <td class="text-end">{{ number_format((float) $row->grand_total, 2) }}</td>
                        <td class="text-end">{{ number_format((float) $row->paid_amount, 2) }}</td>
                        <td class="text-end">{{ number_format((float) $row->due_amount, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No sales for the period</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $rows->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
