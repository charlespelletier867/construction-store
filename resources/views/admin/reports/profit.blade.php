@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.report_profit'))

@section('content')
<form method="GET" class="card mb-3">
    <div class="card-body row g-2 align-items-end">
        <div class="col-md-3"><label class="form-label">From</label><input type="date" name="from" value="{{ $from->toDateString() }}" class="form-control"></div>
        <div class="col-md-3"><label class="form-label">To</label><input type="date" name="to" value="{{ $to->toDateString() }}" class="form-control"></div>
        <div class="col-md-3"><button class="btn btn-primary">{{ __('admin.action.filter') }}</button></div>
    </div>
</form>

<div class="row g-3">
    <div class="col-md-6"><div class="card"><div class="card-body"><p class="text-muted mb-1">Total Sales</p><h3>{{ number_format((float) $totalSales, 2) }}</h3></div></div></div>
    <div class="col-md-6"><div class="card"><div class="card-body"><p class="text-muted mb-1">Total Profit</p><h3>{{ number_format((float) $profit, 2) }}</h3></div></div></div>
</div>
@endsection
