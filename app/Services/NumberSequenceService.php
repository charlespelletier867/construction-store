<?php

namespace App\Services;

use App\Models\NumberSequence;
use Illuminate\Support\Facades\DB;

class NumberSequenceService
{
    /**
     * Generate the next document number for a given document type.
     */
    public function next(string $documentType, ?int $companyId = null, ?int $branchId = null, string $defaultPrefix = '', int $defaultPadding = 5): string
    {
        return DB::transaction(function () use ($documentType, $companyId, $branchId, $defaultPrefix, $defaultPadding) {
            $seq = NumberSequence::query()
                ->where('document_type', $documentType)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->lockForUpdate()
                ->first();

            if (! $seq) {
                $seq = NumberSequence::create([
                    'company_id' => $companyId,
                    'branch_id' => $branchId,
                    'document_type' => $documentType,
                    'prefix' => $defaultPrefix,
                    'padding' => $defaultPadding,
                    'next_number' => 1,
                ]);
            }

            $number = (int) ($seq->next_number ?? 1);
            $seq->update(['next_number' => $number + 1]);

            $prefix = $seq->prefix ?: $defaultPrefix;
            $padding = (int) ($seq->padding ?: $defaultPadding);
            $suffix = $seq->suffix ?: '';

            $body = str_pad((string) $number, $padding, '0', STR_PAD_LEFT);

            if ($seq->date_format) {
                $body = now()->format($seq->date_format) . '-' . $body;
            }

            return $prefix . $body . $suffix;
        });
    }
}
