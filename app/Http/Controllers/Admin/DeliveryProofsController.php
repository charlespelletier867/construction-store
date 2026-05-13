<?php

namespace App\Http\Controllers\Admin;

use App\Models\DeliveryProof;

class DeliveryProofsController extends SchemaResourceController
{
    protected string $modelClass = DeliveryProof::class;
    protected string $viewPrefix = 'admin.delivery_proofs';
    protected string $routePrefix = 'admin.delivery_proofs';
    protected array $indexColumns = ['id', 'delivery_id', 'proof_type', 'file_path', 'captured_at', 'uploaded_by'];

    public function __construct()
    {
        $this->singular = 'Delivery Proof';
        $this->pluralLabel = 'Delivery Proofs';
    }
}
