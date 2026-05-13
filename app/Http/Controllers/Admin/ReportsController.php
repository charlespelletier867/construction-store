<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\SaleInvoice;
use App\Models\SaleItem;
use App\Models\StockBalance;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function sales(Request $request): View
    {
        $companyId = $request->user()?->company_id;
        $from = $request->date('from') ?? now()->startOfMonth();
        $to = $request->date('to') ?? now()->endOfMonth();

        $rows = SaleInvoice::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->whereBetween('sale_date', [$from->toDateString(), $to->toDateString()])
            ->with('branch')
            ->orderBy('sale_date')
            ->paginate(20);

        $totals = [
            'total_sales' => $rows->sum('grand_total'),
            'total_paid' => $rows->sum('paid_amount'),
            'total_due' => $rows->sum('due_amount'),
        ];

        return view('admin.reports.sales', compact('rows', 'totals', 'from', 'to'));
    }

    public function stock(Request $request): View
    {
        $companyId = $request->user()?->company_id;
        $branchId = $request->session()->get('current_branch_id');

        $rows = StockBalance::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->with(['product', 'warehouse'])
            ->paginate(30);

        return view('admin.reports.stock', compact('rows'));
    }

    public function profit(Request $request): View
    {
        $companyId = $request->user()?->company_id;
        $from = $request->date('from') ?? now()->startOfMonth();
        $to = $request->date('to') ?? now()->endOfMonth();

        $invoiceIds = SaleInvoice::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->whereBetween('sale_date', [$from->toDateString(), $to->toDateString()])
            ->pluck('id');

        $profit = SaleItem::query()
            ->whereIn('sale_invoice_id', $invoiceIds)
            ->sum('profit_amount');

        $totalSales = SaleInvoice::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->whereBetween('sale_date', [$from->toDateString(), $to->toDateString()])
            ->sum('grand_total');

        return view('admin.reports.profit', compact('profit', 'totalSales', 'from', 'to'));
    }

    public function payable(Request $request): View
    {
        $companyId = $request->user()?->company_id;

        $rows = Supplier::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->where('current_balance', '>', 0)
            ->orderByDesc('current_balance')
            ->paginate(30);

        return view('admin.reports.payable', compact('rows'));
    }

    public function receivable(Request $request): View
    {
        $companyId = $request->user()?->company_id;

        $rows = Customer::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->where('current_balance', '>', 0)
            ->orderByDesc('current_balance')
            ->paginate(30);

        return view('admin.reports.receivable', compact('rows'));
    }

    public function branchPerformance(Request $request): View
    {
        $companyId = $request->user()?->company_id;
        $from = $request->date('from') ?? now()->startOfMonth();
        $to = $request->date('to') ?? now()->endOfMonth();

        $rows = SaleInvoice::query()
            ->selectRaw('branch_id, COUNT(*) as invoice_count, SUM(grand_total) as total_sales, COALESCE(SUM((SELECT SUM(profit_amount) FROM sale_items WHERE sale_items.sale_invoice_id = sale_invoices.id)), 0) as total_profit')
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->whereBetween('sale_date', [$from->toDateString(), $to->toDateString()])
            ->groupBy('branch_id')
            ->with('branch')
            ->get();

        return view('admin.reports.branch_performance', compact('rows', 'from', 'to'));
    }
}
