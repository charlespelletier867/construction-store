<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleInvoice;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Models\Warehouse;
use App\Services\NumberSequenceService;
use App\Services\StockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class POSController extends Controller
{
    public function __construct(
        protected NumberSequenceService $sequences,
        protected StockService $stock,
    ) {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $companyId = $user->company_id;
        $branchId = $request->session()->get('current_branch_id');

        $customers = Customer::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->where('is_active', true)
            ->orderBy('name')
            ->limit(500)
            ->get(['id', 'name', 'customer_code', 'phone', 'customer_type']);

        $warehouses = Warehouse::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'is_default']);

        return view('admin.pos.index', [
            'customers' => $customers,
            'warehouses' => $warehouses,
            'branchId' => $branchId,
            'companyId' => $companyId,
        ]);
    }

    public function searchProducts(Request $request): JsonResponse
    {
        $user = $request->user();
        $companyId = $user->company_id;
        $term = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->where('is_active', true)
            ->when($term !== '', function ($q) use ($term) {
                $q->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%$term%")
                        ->orWhere('product_code', 'like', "%$term%")
                        ->orWhere('sku', 'like', "%$term%")
                        ->orWhere('barcode', '=', $term);
                });
            })
            ->orderBy('name')
            ->limit(40)
            ->get(['id', 'product_code', 'name', 'retail_price', 'wholesale_price', 'project_price', 'purchase_price', 'minimum_stock', 'track_stock']);

        $branchId = $request->session()->get('current_branch_id');
        $warehouseId = (int) $request->query('warehouse_id');

        $products->each(function (Product $p) use ($branchId, $warehouseId) {
            $p->quantity_on_hand = $branchId
                ? $this->stock->quantityOnHand($p->id, $branchId, $warehouseId ?: null)
                : 0;
        });

        return response()->json($products);
    }

    public function checkout(Request $request): JsonResponse
    {
        $data = $request->validate([
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.0001'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.discount_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string'],
            'paid_amount' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string'],
        ]);

        $user = $request->user();
        $companyId = $user->company_id;
        $branchId = $request->session()->get('current_branch_id');

        if (! $branchId) {
            return response()->json(['ok' => false, 'error' => 'no_branch_selected'], 422);
        }

        $warehouse = Warehouse::query()
            ->where('id', $data['warehouse_id'])
            ->where('company_id', $companyId)
            ->firstOrFail();

        $result = DB::transaction(function () use ($data, $user, $companyId, $branchId, $warehouse) {
            $subtotal = 0;
            $totalCost = 0;

            foreach ($data['items'] as $item) {
                $lineSubtotal = (float) $item['quantity'] * (float) $item['unit_price'];
                $lineDiscount = (float) ($item['discount_amount'] ?? 0);
                $subtotal += ($lineSubtotal - $lineDiscount);
            }

            $discount = (float) ($data['discount_amount'] ?? 0);
            $tax = (float) ($data['tax_amount'] ?? 0);
            $grandTotal = max(0, $subtotal - $discount + $tax);
            $paid = (float) $data['paid_amount'];
            $due = max(0, $grandTotal - $paid);

            $saleNo = $this->sequences->next('sale_invoice', $companyId, $branchId, 'INV-', 5);
            $change = max(0, $paid - $grandTotal);

            $invoice = SaleInvoice::create([
                'company_id' => $companyId,
                'branch_id' => $branchId,
                'warehouse_id' => $warehouse->id,
                'customer_id' => $data['customer_id'] ?? null,
                'cashier_id' => $user->id,
                'sale_no' => $saleNo,
                'sale_date' => now(),
                'sale_type' => 'retail',
                'status' => 'completed',
                'payment_status' => $due > 0 ? ($paid > 0 ? 'partial_paid' : 'unpaid') : 'paid',
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'tax_amount' => $tax,
                'transport_fee' => 0,
                'grand_total' => $grandTotal,
                'paid_amount' => $paid,
                'due_amount' => $due,
                'received_amount' => $paid,
                'change_amount' => $change,
                'note' => $data['note'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $unitCost = (float) $product->purchase_price;
                $lineTotal = (float) $item['quantity'] * (float) $item['unit_price'] - (float) ($item['discount_amount'] ?? 0);
                $lineProfit = $lineTotal - ((float) $item['quantity'] * $unitCost);
                $totalCost += (float) $item['quantity'] * $unitCost;

                SaleItem::create([
                    'sale_invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'unit_id' => $product->unit_id,
                    'quantity' => $item['quantity'],
                    'returned_quantity' => 0,
                    'unit_price' => $item['unit_price'],
                    'unit_cost' => $unitCost,
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'tax_amount' => 0,
                    'line_total' => $lineTotal,
                    'profit_amount' => $lineProfit,
                ]);

                if ($product->track_stock) {
                    $this->stock->move([
                        'company_id' => $companyId,
                        'branch_id' => $branchId,
                        'warehouse_id' => $warehouse->id,
                        'product_id' => $product->id,
                        'movement_type' => 'sale',
                        'quantity' => -1 * (float) $item['quantity'],
                        'unit_cost' => $unitCost,
                        'reference_type' => SaleInvoice::class,
                        'reference_id' => $invoice->id,
                        'created_by' => $user->id,
                    ]);
                }
            }



            if ($paid > 0) {
                SalePayment::create([
                    'company_id' => $companyId,
                    'branch_id' => $branchId,
                    'customer_id' => $invoice->customer_id,
                    'sale_invoice_id' => $invoice->id,
                    'payment_no' => $this->sequences->next('sale_payment', $companyId, $branchId, 'PAY-', 5),
                    'payment_date' => now(),
                    'amount' => $paid,
                    'payment_method' => $data['payment_method'],
                    'note' => $data['note'] ?? null,
                    'created_by' => $user->id,
                ]);
            }

            return $invoice->load(['items.product', 'customer', 'branch', 'warehouse']);
        });

        return response()->json([
            'ok' => true,
            'invoice' => $result,
            'message' => __('admin.alert.created'),
        ]);
    }
}
