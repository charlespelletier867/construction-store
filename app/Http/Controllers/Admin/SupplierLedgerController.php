<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierLedgerEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierLedgerController extends Controller
{
    public function index(Request $request): View
    {
        $companyId = $request->user()?->company_id;

        $suppliers = Supplier::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->orderBy('name')
            ->paginate(20);

        return view('admin.supplier_ledger.index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function show(Supplier $supplier): View
    {
        $entries = SupplierLedgerEntry::query()
            ->where('supplier_id', $supplier->id)
            ->orderBy('entry_date')
            ->orderBy('id')
            ->paginate(50);

        return view('admin.supplier_ledger.show', [
            'supplier' => $supplier,
            'entries' => $entries,
        ]);
    }
}
