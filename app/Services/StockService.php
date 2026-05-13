<?php

namespace App\Services;

use App\Models\StockBalance;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Move stock for a product (positive = increase, negative = decrease).
     * Returns the updated StockBalance.
     */
    public function move(array $args): StockBalance
    {
        $required = ['company_id', 'branch_id', 'warehouse_id', 'product_id', 'quantity', 'movement_type'];
        foreach ($required as $r) {
            if (! array_key_exists($r, $args)) {
                throw new \InvalidArgumentException("Missing field $r");
            }
        }

        return DB::transaction(function () use ($args) {
            $balance = StockBalance::query()
                ->where('company_id', $args['company_id'])
                ->where('branch_id', $args['branch_id'])
                ->where('warehouse_id', $args['warehouse_id'])
                ->where('product_id', $args['product_id'])
                ->lockForUpdate()
                ->first();

            if (! $balance) {
                $balance = StockBalance::create([
                    'company_id' => $args['company_id'],
                    'branch_id' => $args['branch_id'],
                    'warehouse_id' => $args['warehouse_id'],
                    'product_id' => $args['product_id'],
                    'quantity' => 0,
                    'reserved_quantity' => 0,
                    'available_quantity' => 0,
                    'average_cost' => 0,
                    'stock_value' => 0,
                ]);
            }

            $qty = (float) $args['quantity'];
            $unitCost = (float) ($args['unit_cost'] ?? 0);
            $newQty = (float) $balance->quantity + $qty;
            $reserved = (float) ($balance->reserved_quantity ?? 0);
            $avgCost = $qty > 0 && $unitCost > 0
                ? (((float) $balance->quantity * (float) $balance->average_cost) + ($qty * $unitCost)) / max(1e-9, $newQty)
                : (float) $balance->average_cost;
            $balance->update([
                'quantity' => $newQty,
                'available_quantity' => max(0, $newQty - $reserved),
                'average_cost' => $avgCost,
                'stock_value' => $newQty * $avgCost,
                'last_movement_at' => now(),
            ]);

            StockMovement::create([
                'company_id' => $args['company_id'],
                'branch_id' => $args['branch_id'],
                'warehouse_id' => $args['warehouse_id'],
                'product_id' => $args['product_id'],
                'movement_type' => $args['movement_type'],
                'quantity_in' => $qty > 0 ? $qty : 0,
                'quantity_out' => $qty < 0 ? abs($qty) : 0,
                'balance_after' => $newQty,
                'unit_cost' => $unitCost,
                'total_cost' => abs($qty) * $unitCost,
                'reference_type' => $args['reference_type'] ?? null,
                'reference_id' => $args['reference_id'] ?? null,
                'note' => $args['note'] ?? null,
                'created_by' => $args['created_by'] ?? null,
            ]);

            return $balance->fresh();
        });
    }

    public function quantityOnHand(int $productId, int $branchId, ?int $warehouseId = null): float
    {
        return (float) StockBalance::query()
            ->where('product_id', $productId)
            ->where('branch_id', $branchId)
            ->when($warehouseId, fn ($q) => $q->where('warehouse_id', $warehouseId))
            ->sum('quantity');
    }
}
