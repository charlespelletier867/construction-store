<?php

namespace App\Http\Controllers\Admin;

use App\Models\SupplierLedgerEntry;

class SupplierLedgerEntriesController extends SchemaResourceController
{
    protected string $modelClass = SupplierLedgerEntry::class;
    protected string $viewPrefix = 'admin.supplier_ledger_entries';
    protected string $routePrefix = 'admin.supplier_ledger_entries';
    protected array $indexColumns = ['id', 'entry_no', 'entry_date', 'supplier_id', 'entry_type', 'balance_after'];

    public function __construct()
    {
        $this->singular = 'Supplier Ledger Entry';
        $this->pluralLabel = 'Supplier Ledger Entries';
    }
}
