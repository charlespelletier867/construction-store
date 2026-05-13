@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.report_branch_performance'))

@section('content')
<form method="GET" class="card mb-3">
    <div class="card-body row g-2 align-items-end">
        <div class="col-md-3"><label class="form-label">From</label><input type="date" name="from" value="{{ $from->toDateString() }}" class="form-control"></div>
        <div class="col-md-3"><label class="form-label">To</label><input type="date" name="to" value="{{ $to->toDateString() }}" class="form-control"></div>
        <div class="col-md-3"><button class="btn btn-primary">{{ __('admin.action.filter') }}</button></div>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>{{ __('admin.field.branch') }}</th><th class="text-end">Invoices</th><th class="text-end">{{ __('admin.field.total') }}</th><th class="text-end">Profit</th></tr></thead>
            <tbody>
                @forelse($rows as $row)
                    <tr>
                        <td>{{ $row->branch->name ?? '-' }}</td>
                        <td class="text-end">{{ $row->invoice_count }}</td>
                        <td class="text-end">{{ number_format((float) $row->total_sales, 2) }}</td>
                        <td class="text-end">{{ number_format((float) $row->total_profit, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
