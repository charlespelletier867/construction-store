@extends('admin.layouts.admin_layout')

@section('pageTitle', $supplier->name . ' - ' . __('admin.menu.supplier_ledger'))

@section('content')
<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">{{ $supplier->name }}</h5>
            <small class="text-muted">{{ $supplier->supplier_code }} · {{ $supplier->phone }}</small>
        </div>
        <div class="text-end">
            <p class="mb-0 text-muted small">Current Balance</p>
            <h4 class="mb-0">{{ number_format((float) $supplier->current_balance, 2) }}</h4>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>{{ __('admin.field.date') }}</th>
                    <th>Type</th>
                    <th>Reference</th>
                    <th>Description</th>
                    <th class="text-end">Debit</th>
                    <th class="text-end">Credit</th>
                    <th class="text-end">Balance</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $e)
                    <tr>
                        <td>{{ $e->entry_date }}</td>
                        <td>{{ $e->entry_type }}</td>
                        <td>{{ $e->reference_no }}</td>
                        <td>{{ $e->description }}</td>
                        <td class="text-end">{{ $e->debit ? number_format((float) $e->debit, 2) : '-' }}</td>
                        <td class="text-end">{{ $e->credit ? number_format((float) $e->credit, 2) : '-' }}</td>
                        <td class="text-end">{{ number_format((float) $e->running_balance, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No entries.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $entries->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
