<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockBalance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'decimal:4',
        'reserved_quantity' => 'decimal:4',
        'available_quantity' => 'decimal:4',
        'average_cost' => 'decimal:4',
        'stock_value' => 'decimal:4',
        'last_movement_at' => 'datetime',
    ];

    public function getQuantityOnHandAttribute(): float
    {
        return (float) $this->quantity;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
