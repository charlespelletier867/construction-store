import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import { createI18n } from 'vue-i18n';
import flatpickr from 'flatpickr';
import TomSelect from 'tom-select';
import Swal from 'sweetalert2';
import * as bootstrap from 'bootstrap';
import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';

window.$ = window.jQuery = $;
window.bootstrap = bootstrap;
window.flatpickr = flatpickr;
window.TomSelect = TomSelect;
window.Swal = Swal;
window.DataTable = DataTable;

const initialLocale = window.__APP_LOCALE__ || document.documentElement.dataset.locale || 'en';
const translations = window.__APP_TRANSLATIONS__ || { en: {}, km: {} };

const i18n = createI18n({
    legacy: false,
    locale: initialLocale,
    fallbackLocale: 'en',
    messages: translations,
});

window.i18n = i18n;

function applyDomTranslations(locale) {
    const dict = translations[locale] || {};
    document.querySelectorAll('[data-i18n]').forEach((el) => {
        const key = el.getAttribute('data-i18n');
        const value = getNested(dict, key);
        if (typeof value === 'string') {
            el.textContent = value;
        }
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach((el) => {
        const key = el.getAttribute('data-i18n-placeholder');
        const value = getNested(dict, key);
        if (typeof value === 'string') {
            el.setAttribute('placeholder', value);
        }
    });
    document.documentElement.lang = locale;
    document.documentElement.dataset.locale = locale;
    document.querySelectorAll('.lang-label').forEach((el) => {
        el.textContent = locale === 'km' ? 'ខ្មែរ' : 'English';
    });
    document.querySelectorAll('.lang-switch').forEach((el) => {
        el.classList.toggle('active', el.dataset.locale === locale);
    });
}

function getNested(obj, dottedKey) {
    return dottedKey.split('.').reduce((acc, k) => (acc && acc[k] !== undefined ? acc[k] : null), obj);
}

window.applyDomTranslations = applyDomTranslations;
window.switchLocale = function (locale) {
    i18n.global.locale.value = locale;
    applyDomTranslations(locale);
    try {
        localStorage.setItem('app_locale', locale);
    } catch (_) { /* noop */ }
    // Tell server so AJAX requests get translated server-side too
    return fetch('/locale/' + locale, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json',
        },
    }).then(() => {
        // Reload any DataTables and re-translate their static text
        if (window.DataTable && $.fn.dataTable) {
            $.fn.dataTable.tables({ api: true }).ajax.reload(null, false);
        }
    }).catch(() => {});
};

document.addEventListener('click', (e) => {
    const sw = e.target.closest('.lang-switch');
    if (sw) {
        e.preventDefault();
        window.switchLocale(sw.dataset.locale);
    }

    // Sidebar toggle
    if (e.target.closest('.mobile-toggle-icon, .overlay.nav-toggle-icon, .toggle-icon')) {
        document.querySelector('.wrapper')?.classList.toggle('sidebar-open');
    }

    // Metismenu has-arrow toggle
    const arrow = e.target.closest('.metismenu .has-arrow');
    if (arrow) {
        e.preventDefault();
        const li = arrow.parentElement;
        li.classList.toggle('open');
    }
});

// Auto-init flatpickr / tom-select on Blade pages
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.flatpickr').forEach((el) => {
        flatpickr(el, {
            enableTime: el.dataset.time === 'true',
            dateFormat: el.dataset.time === 'true' ? 'Y-m-d H:i' : 'Y-m-d',
        });
    });
    document.querySelectorAll('.tom-select').forEach((el) => {
        if (!el.tomselect) {
            new TomSelect(el, { create: false, allowEmptyOption: true });
        }
    });

    applyDomTranslations(initialLocale);
});

// Confirm-delete via event delegation (handles DataTables-rendered rows too)
document.addEventListener('submit', (e) => {
    const form = e.target.closest('form.confirm-delete');
    if (!form) return;
    if (form.dataset.confirmed === 'true') return;
    e.preventDefault();
    Swal.fire({
        title: i18n.global.t('alert.delete_title', 'Are you sure?'),
        text: i18n.global.t('alert.delete_text', 'This action cannot be undone.'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: i18n.global.t('alert.delete_confirm', 'Yes, delete it!'),
        cancelButtonText: i18n.global.t('alert.cancel', 'Cancel'),
        confirmButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            form.dataset.confirmed = 'true';
            form.submit();
        }
    });
});

// Inertia setup (mount only if the SSR root is present)
const inertiaEl = document.getElementById('app');
if (inertiaEl && inertiaEl.dataset.page) {
    createInertiaApp({
        resolve: (name) => {
            const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
            return pages[`./Pages/${name}.vue`];
        },
        setup({ el, App, props, plugin }) {
            return createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue)
                .use(i18n)
                .mount(el);
        },
        progress: { color: '#5b73e8' },
    });
}

// Inertia islands (non-SSR Blade pages mount specific Vue components into [data-vue-island])
import POSApp from './Pages/POS/POSApp.vue';

const ISLAND_REGISTRY = {
    POSApp,
};

document.querySelectorAll('[data-vue-island]').forEach((el) => {
    const name = el.getAttribute('data-vue-island');
    const Component = ISLAND_REGISTRY[name];
    if (!Component) return;
    const props = el.dataset.props ? JSON.parse(el.dataset.props) : {};
    createApp(Component, props).use(i18n).mount(el);
});
