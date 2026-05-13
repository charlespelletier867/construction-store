<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\SaleInvoice;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $companyId = $request->user()?->company_id;
        $branchId = $request->session()->get('current_branch_id');

        $base = fn ($model) => $model::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId));

        $today = now()->toDateString();

        $stats = [
            'sales_today' => $base(SaleInvoice::class)
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->whereDate('sale_date', $today)
                ->sum('grand_total'),
            'sales_count_today' => $base(SaleInvoice::class)
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->whereDate('sale_date', $today)
                ->count(),
            'purchases_today' => $base(PurchaseInvoice::class)
                ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
                ->whereDate('purchase_date', $today)
                ->sum('grand_total'),
            'product_count' => $base(Product::class)->count(),
            'customer_count' => $base(Customer::class)->count(),
            'supplier_count' => $base(Supplier::class)->count(),
        ];

        $recentSales = $base(SaleInvoice::class)
            ->with(['customer', 'branch'])
            ->latest('id')
            ->limit(8)
            ->get();

        $recentPurchases = $base(PurchaseInvoice::class)
            ->with(['supplier', 'branch'])
            ->latest('id')
            ->limit(8)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentSales', 'recentPurchases'));
    }
}
