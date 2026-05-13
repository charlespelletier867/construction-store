@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.menu.dashboard'))

@section('content')
<div class="row g-3 mb-3">
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1" data-i18n="dashboard.sales_today">Sales Today</p>
                <h4 class="mb-0">{{ number_format((float) $stats['sales_today'], 2) }}</h4>
                <small class="text-muted">{{ $stats['sales_count_today'] }} invoices</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1" data-i18n="dashboard.purchases_today">Purchases Today</p>
                <h4 class="mb-0">{{ number_format((float) $stats['purchases_today'], 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1" data-i18n="dashboard.products">Products</p>
                <h4 class="mb-0">{{ $stats['product_count'] }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-1" data-i18n="dashboard.customers">Customers / Suppliers</p>
                <h4 class="mb-0">{{ $stats['customer_count'] }} / {{ $stats['supplier_count'] }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Recent Sales</h6></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.field.customer') }}</th>
                            <th>{{ __('admin.field.branch') }}</th>
                            <th class="text-end">{{ __('admin.field.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $s)
                            <tr>
                                <td>{{ $s->sale_no }}</td>
                                <td>{{ $s->customer->name ?? '-' }}</td>
                                <td>{{ $s->branch->name ?? '-' }}</td>
                                <td class="text-end">{{ number_format((float) $s->grand_total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No sales yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Recent Purchases</h6></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.field.supplier') }}</th>
                            <th>{{ __('admin.field.branch') }}</th>
                            <th class="text-end">{{ __('admin.field.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPurchases as $p)
                            <tr>
                                <td>{{ $p->purchase_no }}</td>
                                <td>{{ $p->supplier->name ?? '-' }}</td>
                                <td>{{ $p->branch->name ?? '-' }}</td>
                                <td class="text-end">{{ number_format((float) $p->grand_total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No purchases yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
