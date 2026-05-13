<?php

namespace App\Http\Controllers\Admin;

use App\Models\CustomerLedgerEntry;

class CustomerLedgerEntriesController extends SchemaResourceController
{
    protected string $modelClass = CustomerLedgerEntry::class;
    protected string $viewPrefix = 'admin.customer_ledger_entries';
    protected string $routePrefix = 'admin.customer_ledger_entries';
    protected array $indexColumns = ['id', 'entry_no', 'entry_date', 'customer_id', 'entry_type', 'balance_after'];

    public function __construct()
    {
        $this->singular = 'Customer Ledger Entry';
        $this->pluralLabel = 'Customer Ledger Entries';
    }
}
