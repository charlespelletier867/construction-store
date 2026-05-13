<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerLedgerEntry extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'debit' => 'decimal:4',
        'credit' => 'decimal:4',
        'balance' => 'decimal:4',
        'entry_date' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleInvoice(): BelongsTo
    {
        return $this->belongsTo(SaleInvoice::class);
    }

    public function salePayment(): BelongsTo
    {
        return $this->belongsTo(SalePayment::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
