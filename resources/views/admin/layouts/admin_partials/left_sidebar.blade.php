<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon" onerror="this.style.display='none'">
        </div>
        <div>
            <h4 class="logo-text">{{ config('app.name', 'CS POS') }}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i></div>
    </div>

    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class="bi bi-house-door"></i></div>
                <div class="menu-title" data-i18n="menu.dashboard">{{ __('admin.menu.dashboard') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.pos.index') }}">
                <div class="parent-icon"><i class="bi bi-cart-check"></i></div>
                <div class="menu-title" data-i18n="menu.pos">{{ __('admin.menu.pos') }}</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-box-seam"></i></div>
                <div class="menu-title" data-i18n="menu.products_group">{{ __('admin.menu.products_group') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.products.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.products">{{ __('admin.menu.products') }}</span></a></li>
                <li><a href="{{ route('admin.categories.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.categories">{{ __('admin.menu.categories') }}</span></a></li>
                <li><a href="{{ route('admin.brands.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.brands">{{ __('admin.menu.brands') }}</span></a></li>
                <li><a href="{{ route('admin.units.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.units">{{ __('admin.menu.units') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-people"></i></div>
                <div class="menu-title" data-i18n="menu.contacts">{{ __('admin.menu.contacts') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.customers.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.customers">{{ __('admin.menu.customers') }}</span></a></li>
                <li><a href="{{ route('admin.suppliers.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.suppliers">{{ __('admin.menu.suppliers') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-receipt"></i></div>
                <div class="menu-title" data-i18n="menu.sales_group">{{ __('admin.menu.sales_group') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.sale_invoices.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.sale_invoices">{{ __('admin.menu.sale_invoices') }}</span></a></li>
                <li><a href="{{ route('admin.sale_items.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.sale_items">{{ __('admin.menu.sale_items') }}</span></a></li>
                <li><a href="{{ route('admin.sale_payments.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.sale_payments">{{ __('admin.menu.sale_payments') }}</span></a></li>
                <li><a href="{{ route('admin.sale_returns.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.sale_returns">{{ __('admin.menu.sale_returns') }}</span></a></li>
                <li><a href="{{ route('admin.sale_return_items.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.sale_return_items">{{ __('admin.menu.sale_return_items') }}</span></a></li>
                <li><a href="{{ route('admin.quotations.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.quotations">{{ __('admin.menu.quotations') }}</span></a></li>
                <li><a href="{{ route('admin.quotation_items.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.quotation_items">{{ __('admin.menu.quotation_items') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-truck"></i></div>
                <div class="menu-title" data-i18n="menu.purchases_group">{{ __('admin.menu.purchases_group') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.purchase_invoices.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.purchase_invoices">{{ __('admin.menu.purchase_invoices') }}</span></a></li>
                <li><a href="{{ route('admin.purchase_items.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.purchase_items">{{ __('admin.menu.purchase_items') }}</span></a></li>
                <li><a href="{{ route('admin.purchase_payments.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.purchase_payments">{{ __('admin.menu.purchase_payments') }}</span></a></li>
                <li><a href="{{ route('admin.purchase_returns.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.purchase_returns">{{ __('admin.menu.purchase_returns') }}</span></a></li>
                <li><a href="{{ route('admin.purchase_return_items.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.purchase_return_items">{{ __('admin.menu.purchase_return_items') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-boxes"></i></div>
                <div class="menu-title" data-i18n="menu.inventory">{{ __('admin.menu.inventory') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.stock_balances.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.stock_balances">{{ __('admin.menu.stock_balances') }}</span></a></li>
                <li><a href="{{ route('admin.stock_movements.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.stock_movements">{{ __('admin.menu.stock_movements') }}</span></a></li>
                <li><a href="{{ route('admin.stock_transfers.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.stock_transfers">{{ __('admin.menu.stock_transfers') }}</span></a></li>
                <li><a href="{{ route('admin.stock_transfer_items.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.stock_transfer_items">{{ __('admin.menu.stock_transfer_items') }}</span></a></li>
                <li><a href="{{ route('admin.stock_adjustments.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.stock_adjustments">{{ __('admin.menu.stock_adjustments') }}</span></a></li>
                <li><a href="{{ route('admin.stock_adjustment_items.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.stock_adjustment_items">{{ __('admin.menu.stock_adjustment_items') }}</span></a></li>
                <li><a href="{{ route('admin.damaged_stocks.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.damaged_stocks">{{ __('admin.menu.damaged_stocks') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-geo-alt"></i></div>
                <div class="menu-title" data-i18n="menu.delivery_group">{{ __('admin.menu.delivery_group') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.deliveries.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.deliveries">{{ __('admin.menu.deliveries') }}</span></a></li>
                <li><a href="{{ route('admin.delivery_proofs.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.delivery_proofs">{{ __('admin.menu.delivery_proofs') }}</span></a></li>
                <li><a href="{{ route('admin.drivers.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.drivers">{{ __('admin.menu.drivers') }}</span></a></li>
                <li><a href="{{ route('admin.vehicles.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.vehicles">{{ __('admin.menu.vehicles') }}</span></a></li>
                <li><a href="{{ route('admin.vehicle_expenses.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.vehicle_expenses">{{ __('admin.menu.vehicle_expenses') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-cash-coin"></i></div>
                <div class="menu-title" data-i18n="menu.finance_group">{{ __('admin.menu.finance_group') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.expenses.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.expenses">{{ __('admin.menu.expenses') }}</span></a></li>
                <li><a href="{{ route('admin.expense_categories.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.expense_categories">{{ __('admin.menu.expense_categories') }}</span></a></li>
                <li><a href="{{ route('admin.customer_ledger.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.customer_ledger">{{ __('admin.menu.customer_ledger') }}</span></a></li>
                <li><a href="{{ route('admin.customer_ledger_entries.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.customer_ledger_entries">{{ __('admin.menu.customer_ledger_entries') }}</span></a></li>
                <li><a href="{{ route('admin.supplier_ledger.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.supplier_ledger">{{ __('admin.menu.supplier_ledger') }}</span></a></li>
                <li><a href="{{ route('admin.supplier_ledger_entries.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.supplier_ledger_entries">{{ __('admin.menu.supplier_ledger_entries') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-bar-chart"></i></div>
                <div class="menu-title" data-i18n="menu.reports">{{ __('admin.menu.reports') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.reports.sales') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.report_sales">{{ __('admin.menu.report_sales') }}</span></a></li>
                <li><a href="{{ route('admin.reports.stock') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.report_stock">{{ __('admin.menu.report_stock') }}</span></a></li>
                <li><a href="{{ route('admin.reports.profit') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.report_profit">{{ __('admin.menu.report_profit') }}</span></a></li>
                <li><a href="{{ route('admin.reports.payable') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.report_payable">{{ __('admin.menu.report_payable') }}</span></a></li>
                <li><a href="{{ route('admin.reports.receivable') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.report_receivable">{{ __('admin.menu.report_receivable') }}</span></a></li>
                <li><a href="{{ route('admin.reports.branch_performance') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.report_branch_performance">{{ __('admin.menu.report_branch_performance') }}</span></a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-building-gear"></i></div>
                <div class="menu-title" data-i18n="menu.administration">{{ __('admin.menu.administration') }}</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.companies.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.companies">{{ __('admin.menu.companies') }}</span></a></li>
                <li><a href="{{ route('admin.branches.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.branches">{{ __('admin.menu.branches') }}</span></a></li>
                <li><a href="{{ route('admin.warehouses.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.warehouses">{{ __('admin.menu.warehouses') }}</span></a></li>
                <li><a href="{{ route('admin.users.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.users">{{ __('admin.menu.users') }}</span></a></li>
                <li><a href="{{ route('admin.roles.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.roles">{{ __('admin.menu.roles') }}</span></a></li>
                <li><a href="{{ route('admin.permissions.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.permissions">{{ __('admin.menu.permissions') }}</span></a></li>
                <li><a href="{{ route('admin.role_permissions.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.role_permissions">{{ __('admin.menu.role_permissions') }}</span></a></li>
                <li><a href="{{ route('admin.user_branch_roles.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.user_branch_roles">{{ __('admin.menu.user_branch_roles') }}</span></a></li>
                <li><a href="{{ route('admin.system_settings.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.system_settings">{{ __('admin.menu.system_settings') }}</span></a></li>
                <li><a href="{{ route('admin.number_sequences.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.number_sequences">{{ __('admin.menu.number_sequences') }}</span></a></li>
                <li><a href="{{ route('admin.document_templates.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.document_templates">{{ __('admin.menu.document_templates') }}</span></a></li>
                <li><a href="{{ route('admin.notifications.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.notifications">{{ __('admin.menu.notifications') }}</span></a></li>
                <li><a href="{{ route('admin.attachments.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.attachments">{{ __('admin.menu.attachments') }}</span></a></li>
                <li><a href="{{ route('admin.audit_logs.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.audit_logs">{{ __('admin.menu.audit_logs') }}</span></a></li>
                <li><a href="{{ route('admin.login_histories.index') }}"><i class="bi bi-arrow-right-short"></i><span data-i18n="menu.login_histories">{{ __('admin.menu.login_histories') }}</span></a></li>
            </ul>
        </li>
    </ul>
</aside>
