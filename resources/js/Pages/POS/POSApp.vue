<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
    customers: { type: Array, default: () => [] },
    warehouses: { type: Array, default: () => [] },
    branchId: { type: [Number, String, null], default: null },
    searchUrl: { type: String, required: true },
    checkoutUrl: { type: String, required: true },
});

const { t } = useI18n();

const search = ref('');
const products = ref([]);
const loading = ref(false);
const cart = ref([]); // {product_id, name, code, unit_price, quantity, discount_amount, max_qty}
const customerId = ref(null);
const warehouseId = ref(props.warehouses.find(w => w.is_default)?.id ?? props.warehouses[0]?.id ?? null);
const paymentMethod = ref('cash');
const amountReceived = ref(0);
const discountAmount = ref(0);
const taxAmount = ref(0);
const note = ref('');
const lastInvoice = ref(null);

async function fetchProducts() {
    loading.value = true;
    try {
        const url = new URL(props.searchUrl, window.location.origin);
        url.searchParams.set('q', search.value);
        if (warehouseId.value) url.searchParams.set('warehouse_id', warehouseId.value);
        const res = await fetch(url, {
            headers: { Accept: 'application/json' },
            credentials: 'same-origin',
        });
        products.value = await res.json();
    } catch (e) {
        console.error(e);
        products.value = [];
    } finally {
        loading.value = false;
    }
}

let debounce = null;
watch(search, () => {
    clearTimeout(debounce);
    debounce = setTimeout(fetchProducts, 250);
});
watch(warehouseId, fetchProducts);

onMounted(fetchProducts);

function addToCart(p) {
    const existing = cart.value.find(c => c.product_id === p.id);
    if (existing) {
        existing.quantity = Number(existing.quantity) + 1;
    } else {
        cart.value.push({
            product_id: p.id,
            name: p.name,
            code: p.product_code,
            unit_price: Number(p.retail_price ?? 0),
            quantity: 1,
            discount_amount: 0,
            max_qty: Number(p.quantity_on_hand ?? 0),
        });
    }
}

function removeLine(idx) {
    cart.value.splice(idx, 1);
}

const subtotal = computed(() =>
    cart.value.reduce((s, l) => s + Number(l.unit_price) * Number(l.quantity) - Number(l.discount_amount || 0), 0)
);

const grandTotal = computed(() =>
    Math.max(0, subtotal.value - Number(discountAmount.value || 0) + Number(taxAmount.value || 0))
);

const change = computed(() =>
    Math.max(0, Number(amountReceived.value || 0) - grandTotal.value)
);

function clearCart() {
    cart.value = [];
    discountAmount.value = 0;
    taxAmount.value = 0;
    amountReceived.value = 0;
    note.value = '';
    customerId.value = null;
}

async function payAndPrint() {
    if (cart.value.length === 0) return;
    if (!warehouseId.value) {
        alert(t('pos.no_branch'));
        return;
    }

    const body = {
        warehouse_id: warehouseId.value,
        customer_id: customerId.value,
        items: cart.value.map(l => ({
            product_id: l.product_id,
            quantity: l.quantity,
            unit_price: l.unit_price,
            discount_amount: l.discount_amount || 0,
        })),
        discount_amount: discountAmount.value,
        tax_amount: taxAmount.value,
        payment_method: paymentMethod.value,
        paid_amount: amountReceived.value || grandTotal.value,
        note: note.value,
    };

    try {
        const res = await fetch(props.checkoutUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify(body),
        });
        const json = await res.json();
        if (!res.ok || !json.ok) {
            alert(json.error || 'Checkout failed');
            return;
        }

        lastInvoice.value = json.invoice;
        if (window.Swal) {
            window.Swal.fire({
                icon: 'success',
                title: json.message,
                text: 'Invoice ' + json.invoice.sale_no,
                showCancelButton: true,
                confirmButtonText: t('action.print'),
                cancelButtonText: t('action.close', 'Close'),
            }).then(r => {
                if (r.isConfirmed) printReceipt();
            });
        }
        clearCart();
        fetchProducts();
    } catch (e) {
        console.error(e);
        alert('Network error.');
    }
}

function printReceipt() {
    if (!lastInvoice.value) return;
    const w = window.open('', 'receipt', 'width=320,height=600');
    if (!w) return;
    const inv = lastInvoice.value;
    const lines = inv.items.map(it => `
        <tr>
            <td>${it.product?.name ?? '-'}</td>
            <td style="text-align:right">${Number(it.quantity).toFixed(2)}</td>
            <td style="text-align:right">${Number(it.unit_price).toFixed(2)}</td>
            <td style="text-align:right">${Number(it.line_total).toFixed(2)}</td>
        </tr>`).join('');
    w.document.write(`
        <html><head><title>Receipt ${inv.sale_no}</title>
        <style>body{font-family:monospace;font-size:12px;width:280px;padding:8px;}
        table{width:100%;border-collapse:collapse}
        th,td{padding:2px 4px}
        .h{text-align:center;font-weight:bold}
        .b{border-top:1px dashed #000;border-bottom:1px dashed #000}</style>
        </head><body>
        <div class="h">${inv.branch?.name ?? ''}</div>
        <div class="h">Receipt</div>
        <div>Invoice: ${inv.sale_no}</div>
        <div>Date: ${inv.sale_date}</div>
        <div>Customer: ${inv.customer?.name ?? 'Walk-in'}</div>
        <table class="b"><thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>${lines}</tbody></table>
        <table><tr><td>Subtotal:</td><td style="text-align:right">${Number(inv.subtotal).toFixed(2)}</td></tr>
        <tr><td>Discount:</td><td style="text-align:right">${Number(inv.discount_amount).toFixed(2)}</td></tr>
        <tr><td>Tax:</td><td style="text-align:right">${Number(inv.tax_amount).toFixed(2)}</td></tr>
        <tr><td><b>Total:</b></td><td style="text-align:right"><b>${Number(inv.grand_total).toFixed(2)}</b></td></tr>
        <tr><td>Paid:</td><td style="text-align:right">${Number(inv.paid_amount).toFixed(2)}</td></tr></table>
        <div class="h">Thank You!</div>
        <script>window.print();<\/script>
        </body></html>
    `);
}
</script>

<template>
    <div class="pos-grid">
        <!-- Left: products -->
        <div class="pos-products">
            <div class="row g-2 align-items-center mb-3">
                <div class="col-md-7">
                    <input
                        v-model="search"
                        type="text"
                        class="form-control"
                        :placeholder="t('pos.search_products')"
                        autofocus
                    />
                </div>
                <div class="col-md-5">
                    <select v-model="warehouseId" class="form-select">
                        <option :value="null">— {{ t('field.warehouse') }} —</option>
                        <option v-for="w in warehouses" :key="w.id" :value="w.id">{{ w.name }}</option>
                    </select>
                </div>
            </div>

            <div v-if="loading" class="text-center py-4 text-muted">Loading...</div>
            <div v-else-if="!products.length" class="text-center py-4 text-muted">No products found.</div>
            <div v-else class="row g-2">
                <div v-for="p in products" :key="p.id" class="col-6 col-md-4 col-xl-3">
                    <div class="product-card" @click="addToCart(p)">
                        <div class="product-name">{{ p.name }}</div>
                        <div class="product-price">{{ Number(p.retail_price).toFixed(2) }}</div>
                        <div class="product-stock" v-if="p.track_stock">Stock: {{ Number(p.quantity_on_hand).toFixed(2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: cart -->
        <div class="pos-cart">
            <div class="d-flex align-items-center mb-2">
                <h6 class="mb-0">{{ t('pos.cart') }} ({{ cart.length }})</h6>
                <button v-if="cart.length" @click="clearCart" class="btn btn-outline-secondary btn-sm ms-auto">{{ t('pos.clear') }}</button>
            </div>

            <select v-model="customerId" class="form-select form-select-sm mb-2">
                <option :value="null">{{ t('pos.walk_in') }}</option>
                <option v-for="c in customers" :key="c.id" :value="c.id">{{ c.name }} ({{ c.phone || c.customer_code }})</option>
            </select>

            <div class="cart-items">
                <div v-if="!cart.length" class="text-center text-muted py-4">{{ t('pos.empty_cart') }}</div>
                <div v-for="(line, i) in cart" :key="line.product_id" class="cart-line">
                    <div class="line-name">
                        <div class="fw-medium">{{ line.name }}</div>
                        <small class="text-muted">{{ line.code }}</small>
                    </div>
                    <input
                        v-model.number="line.unit_price"
                        type="number"
                        step="0.01"
                        class="form-control form-control-sm"
                        style="width: 80px"
                    />
                    <input
                        v-model.number="line.quantity"
                        type="number"
                        step="0.01"
                        class="form-control form-control-sm line-qty"
                    />
                    <button @click="removeLine(i)" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>

            <div class="cart-totals">
                <div class="row-total">
                    <span>{{ t('pos.subtotal') }}</span>
                    <span>{{ subtotal.toFixed(2) }}</span>
                </div>
                <div class="row-total align-items-center">
                    <span>{{ t('pos.discount') }}</span>
                    <input v-model.number="discountAmount" type="number" step="0.01" class="form-control form-control-sm" style="width: 100px" />
                </div>
                <div class="row-total align-items-center">
                    <span>{{ t('pos.tax') }}</span>
                    <input v-model.number="taxAmount" type="number" step="0.01" class="form-control form-control-sm" style="width: 100px" />
                </div>
                <div class="row-total grand-total mt-2">
                    <span>{{ t('pos.grand_total') }}</span>
                    <span>{{ grandTotal.toFixed(2) }}</span>
                </div>

                <div class="mt-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small">{{ t('pos.payment_method') }}</label>
                            <select v-model="paymentMethod" class="form-select form-select-sm">
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                                <option value="card">Card</option>
                                <option value="qr">QR</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small">{{ t('pos.amount_received') }}</label>
                            <input v-model.number="amountReceived" type="number" step="0.01" class="form-control form-control-sm" />
                        </div>
                    </div>
                    <div class="row-total small mt-1">
                        <span>{{ t('pos.change') }}</span>
                        <span class="fw-bold">{{ change.toFixed(2) }}</span>
                    </div>
                </div>

                <button
                    @click="payAndPrint"
                    :disabled="!cart.length"
                    class="btn btn-primary w-100 mt-3"
                >
                    <i class="bi bi-credit-card me-1"></i>{{ t('pos.pay_and_print') }}
                </button>
            </div>
        </div>
    </div>
</template>
