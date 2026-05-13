<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerLedgerEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerLedgerController extends Controller
{
    public function index(Request $request): View
    {
        $companyId = $request->user()?->company_id;

        $customers = Customer::query()
            ->when($companyId, fn ($q) => $q->where('company_id', $companyId))
            ->orderBy('name')
            ->paginate(20);

        return view('admin.customer_ledger.index', [
            'customers' => $customers,
        ]);
    }

    public function show(Customer $customer): View
    {
        $entries = CustomerLedgerEntry::query()
            ->where('customer_id', $customer->id)
            ->orderBy('entry_date')
            ->orderBy('id')
            ->paginate(50);

        return view('admin.customer_ledger.show', [
            'customer' => $customer,
            'entries' => $entries,
        ]);
    }
}
