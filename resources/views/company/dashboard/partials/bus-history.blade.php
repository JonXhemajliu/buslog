{{--
    Historiku i autobusit (servise + defekte) - modal në qendër.
    Përfshije vetëm NJË herë në faqen ku listohen autobusët.
    Çdo rresht ose buton që e hap duhet të ketë atributet data-bus-history dhe data-bus-name.
--}}
@php
    $input = 'w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 disabled:opacity-50';
    $label = 'block text-sm font-medium text-gray-700 mb-1';
    $err   = 'mt-1 hidden text-xs text-red-600';
@endphp

<div id="bh-root">

    {{-- ============ MODALI KRYESOR (historiku) ============ --}}
    <div id="bh-drawer" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="bh-overlay" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-200"></div>

        <div id="bh-panel" role="dialog" aria-modal="true" aria-labelledby="bh-title"
             class="relative flex max-h-[90vh] w-full max-w-3xl scale-95 flex-col overflow-hidden rounded-lg bg-white opacity-0 shadow-lg transition duration-200">

            <header class="flex items-start justify-between gap-4 border-b border-gray-200 px-6 py-4">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wide text-red-600">Historiku i autobusit</p>
                    <h2 id="bh-title" class="truncate text-xl font-semibold text-gray-900">—</h2>
                </div>
                <div class="flex shrink-0 items-center gap-4">
                    <div class="flex items-center gap-2">
                        <button id="bh-add-service" type="button"
                                class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            + Servis
                        </button>
                        <button id="bh-add-defect" type="button"
                                class="rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            + Defekt
                        </button>
                    </div>
                    <button id="bh-close" type="button" aria-label="Mbyll" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto bg-gray-50">
                <section id="bh-summary" class="grid grid-cols-2 gap-3 px-6 pt-5 sm:grid-cols-4"></section>
                <nav id="bh-tabs" class="flex flex-wrap gap-2 px-6 pt-4" aria-label="Filtra"></nav>
                <div id="bh-list" class="space-y-3 px-6 py-4"></div>
            </div>
        </div>
    </div>

    {{-- ============ FORMULARI (shto / ndrysho) ============ --}}
    <div id="bh-form-wrap" class="fixed inset-0 z-[60] hidden items-center justify-center p-4">
        <div id="bh-form-backdrop" class="absolute inset-0 bg-black/50"></div>

        <form id="bh-form" novalidate class="relative max-h-full w-full max-w-lg overflow-y-auto rounded-lg bg-white p-6 shadow-lg">
            <div class="mb-4 flex items-center justify-between">
                <h3 id="bh-form-title" class="text-xl font-semibold text-gray-900">Regjistrim i ri</h3>
                <button type="button" id="bh-form-x" aria-label="Mbyll" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="mb-4 grid grid-cols-2 gap-1 rounded-lg bg-gray-100 p-1" role="group" aria-label="Lloji">
                <button type="button" data-type="service" class="bh-type">🔧 Servis</button>
                <button type="button" data-type="defect" class="bh-type">⚠️ Defekt</button>
            </div>

            <div class="space-y-4">
                <input type="hidden" name="type" value="service">

                <div>
                    <label for="bh-f-title" class="{{ $label }}">Titulli *</label>
                    <input id="bh-f-title" name="title" type="text" maxlength="150" class="{{ $input }}">
                    <div id="bh-chips" class="mt-2 flex flex-wrap gap-1.5"></div>
                    <p class="{{ $err }}" data-error="title"></p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="bh-f-date" class="{{ $label }}">Data *</label>
                        <input id="bh-f-date" name="record_date" type="date" max="{{ now()->toDateString() }}" class="{{ $input }}">
                        <p class="{{ $err }}" data-error="record_date"></p>
                    </div>
                    <div>
                        <label for="bh-f-km" class="{{ $label }}">Kilometrazhi (km)</label>
                        <input id="bh-f-km" name="odometer_km" type="number" min="0" step="1" class="{{ $input }}" placeholder="p.sh. 482000">
                        <p class="{{ $err }}" data-error="odometer_km"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="bh-f-cost" class="{{ $label }}">Kosto (€)</label>
                        <input id="bh-f-cost" name="cost" type="number" min="0" step="0.01" class="{{ $input }}" placeholder="0.00">
                        <p class="{{ $err }}" data-error="cost"></p>
                    </div>
                    <div>
                        <label for="bh-f-workshop" class="{{ $label }}">Servisi / Punishtja</label>
                        <input id="bh-f-workshop" name="workshop" type="text" maxlength="150" class="{{ $input }}">
                        <p class="{{ $err }}" data-error="workshop"></p>
                    </div>
                </div>

                <div data-for="defect" class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="bh-f-severity" class="{{ $label }}">Ashpërsia *</label>
                        <select id="bh-f-severity" name="severity" class="{{ $input }}">
                            <option value="low">E ulët</option>
                            <option value="medium" selected>Mesatare</option>
                            <option value="high">E lartë</option>
                            <option value="critical">Kritike</option>
                        </select>
                        <p class="{{ $err }}" data-error="severity"></p>
                    </div>
                    <div>
                        <label for="bh-f-status" class="{{ $label }}">Statusi</label>
                        <select id="bh-f-status" name="status" class="{{ $input }}">
                            <option value="open" selected>I hapur</option>
                            <option value="in_progress">Në proces</option>
                            <option value="resolved">Zgjidhur</option>
                        </select>
                        <p class="{{ $err }}" data-error="status"></p>
                    </div>
                </div>

                <div data-for="service">
                    <label for="bh-f-next" class="{{ $label }}">Servisi i radhës (opsionale)</label>
                    <input id="bh-f-next" name="next_service_date" type="date" class="{{ $input }}">
                    <p class="{{ $err }}" data-error="next_service_date"></p>
                </div>

                <div>
                    <label for="bh-f-desc" class="{{ $label }}">Përshkrimi</label>
                    <textarea id="bh-f-desc" name="description" rows="3" maxlength="2000" class="{{ $input }}" placeholder="Çfarë u bë / çfarë u vërejt…"></textarea>
                    <p class="{{ $err }}" data-error="description"></p>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="button" id="bh-form-cancel" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Anulo</button>
                <button type="submit" id="bh-submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-60">Ruaj</button>
            </div>
        </form>
    </div>

    {{-- ============ KONFIRMIMI I FSHIRJES ============ --}}
    <div id="bh-confirm-wrap" class="fixed inset-0 z-[70] hidden items-center justify-center p-4">
        <div id="bh-confirm-backdrop" class="absolute inset-0 bg-black/50"></div>
        <div role="alertdialog" aria-modal="true" class="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg">
            <h3 id="bh-confirm-title" class="text-lg font-semibold text-gray-900"></h3>
            <p id="bh-confirm-text" class="mt-2 text-sm text-gray-600"></p>
            <div class="mt-6 flex gap-3">
                <button type="button" id="bh-confirm-cancel" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Anulo</button>
                <button type="button" id="bh-confirm-ok" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Fshij</button>
            </div>
        </div>
    </div>

    <div id="bh-toast" class="hidden" role="status"></div>
</div>

<script>
(() => {
    const $  = (s, r = document) => r.querySelector(s);
    const $$ = (s, r = document) => [...r.querySelectorAll(s)];

    const URLS = {
        list:    @json(route('bus-records.index',   ['bus' => '__ID__'])),
        store:   @json(route('bus-records.store',   ['bus' => '__ID__'])),
        update:  @json(route('bus-records.update',  ['record' => '__ID__'])),
        resolve: @json(route('bus-records.resolve', ['record' => '__ID__'])),
        destroy: @json(route('bus-records.destroy', ['record' => '__ID__'])),
    };
    const CSRF = @json(csrf_token());
    const url  = (key, id) => URLS[key].replace('__ID__', id);

    const el = {
        drawer: $('#bh-drawer'), overlay: $('#bh-overlay'), panel: $('#bh-panel'),
        title: $('#bh-title'), summary: $('#bh-summary'), tabs: $('#bh-tabs'), list: $('#bh-list'),
        formWrap: $('#bh-form-wrap'), form: $('#bh-form'), formTitle: $('#bh-form-title'), submit: $('#bh-submit'),
        confirmWrap: $('#bh-confirm-wrap'), confirmTitle: $('#bh-confirm-title'),
        confirmText: $('#bh-confirm-text'), confirmOk: $('#bh-confirm-ok'),
        toast: $('#bh-toast'), chips: $('#bh-chips'),
    };

    const state = { busId: null, busName: '', records: [], filter: 'all', editing: null };

    /* ---------- helpers ---------- */
    const esc = (v) => String(v ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const todayISO = () => new Date().toLocaleDateString('sv-SE');
    const fmtDate  = (d) => d ? new Date(d + 'T00:00:00').toLocaleDateString('sq', { day: '2-digit', month: 'short', year: 'numeric' }) : '—';
    const fmtMoney = (n) => new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(n ?? 0);
    const fmtKm    = (n) => n != null ? new Intl.NumberFormat('de-DE').format(n) + ' km' : null;
    const fmtDMY   = (d) => d ? d.slice(8, 10) + '.' + d.slice(5, 7) + '.' + d.slice(0, 4) : '—'; // njësoj si në tabelën e Mirëmbajtjes

    // Statistikat e një autobusi nga regjistrimet e tij
    const stats = (rs) => {
        const services = rs.filter((r) => r.type === 'service');
        return {
            services: services.length,
            openDefects: rs.filter((r) => r.type === 'defect' && r.status !== 'resolved').length,
            total: rs.reduce((a, r) => a + (r.cost ?? 0), 0),
            last: services.reduce((m, r) => (!m || r.record_date > m ? r.record_date : m), null),
            next: services.reduce((m, r) => (r.next_service_date && (!m || r.next_service_date > m) ? r.next_service_date : m), null),
        };
    };
    const svg = (inner, cls = 'h-5 w-5') =>
        `<svg class="${cls}" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">${inner}</svg>`;

    const ICON = {
        tool:  '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        warn:  '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        edit:  '<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>',
        trash: '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>',
        check: '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
    };

    const SEVERITY = {
        low:      { label: 'E ulët',   cls: 'bg-gray-100 text-gray-700 ring-gray-200' },
        medium:   { label: 'Mesatare', cls: 'bg-yellow-50 text-yellow-700 ring-yellow-200' },
        high:     { label: 'E lartë',  cls: 'bg-orange-50 text-orange-700 ring-orange-200' },
        critical: { label: 'Kritike',  cls: 'bg-red-100 text-red-800 ring-red-300' },
    };
    const STATUS = {
        open:        { label: 'I hapur',   cls: 'bg-red-50 text-red-700 ring-red-200' },
        in_progress: { label: 'Në proces', cls: 'bg-yellow-50 text-yellow-700 ring-yellow-200' },
        resolved:    { label: 'Zgjidhur',  cls: 'bg-green-50 text-green-700 ring-green-200' },
    };
    const badge = (b) => `<span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium ring-1 ring-inset ${b.cls}">${b.label}</span>`;

    async function api(method, href, body) {
        const res = await fetch(href, {
            method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: body ? JSON.stringify(body) : undefined,
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw { status: res.status, data };
        return data;
    }

    /* ---------- toast ---------- */
    let toastTimer;
    function toast(msg, kind = 'ok') {
        el.toast.textContent = msg;
        el.toast.className = 'pointer-events-none fixed bottom-6 left-1/2 z-[80] -translate-x-1/2 rounded-lg px-4 py-2.5 text-sm font-medium text-white shadow-lg '
            + (kind === 'error' ? 'bg-red-600' : 'bg-gray-900');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => el.toast.classList.add('hidden'), 2800);
    }

    /* ---------- modali kryesor ---------- */
    let closeTimer;
    function openPanel(busId, busName) {
        clearTimeout(closeTimer);
        Object.assign(state, { busId, busName, records: [], filter: 'all' });
        el.title.textContent = busName || `Autobusi #${busId}`;
        el.drawer.classList.remove('hidden');
        el.drawer.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        void el.panel.offsetWidth; // reflow për animacionin
        el.overlay.classList.replace('opacity-0', 'opacity-100');
        el.panel.classList.remove('opacity-0', 'scale-95');
        el.panel.classList.add('opacity-100', 'scale-100');
        load();
    }

    function closePanel() {
        el.overlay.classList.replace('opacity-100', 'opacity-0');
        el.panel.classList.remove('opacity-100', 'scale-100');
        el.panel.classList.add('opacity-0', 'scale-95');
        document.body.classList.remove('overflow-hidden');
        closeTimer = setTimeout(() => {
            el.drawer.classList.add('hidden');
            el.drawer.classList.remove('flex');
        }, 200);
        state.busId = null;
    }

    async function load() {
        const id = state.busId;
        el.summary.innerHTML = '';
        el.tabs.innerHTML = '';
        el.list.innerHTML = Array.from({ length: 3 }, () =>
            '<div class="h-24 animate-pulse rounded-lg bg-gray-200"></div>').join('');
        try {
            const { records } = await api('GET', url('list', id));
            if (id !== state.busId) return; // modali u mbyll ose u hap për tjetër autobus
            state.records = records;
            render();
        } catch {
            if (id !== state.busId) return;
            el.list.innerHTML = `<div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                Historiku nuk u ngarkua.
                <button type="button" data-action="retry" class="font-semibold underline">Provo përsëri</button></div>`;
        }
    }

    /* ---------- render ---------- */
    function render() { renderSummary(); renderTabs(); renderList(); }

    function renderSummary() {
        const { services, openDefects, total, next } = stats(state.records);
        const overdue = next && next < todayISO();

        const cards = [
            ['Servise', services, 'text-gray-900'],
            ['Defekte të hapura', openDefects, openDefects ? 'text-red-600' : 'text-gray-900'],
            ['Kosto totale', fmtMoney(total), 'text-gray-900'],
            [overdue ? 'Servisi i vonuar' : 'Servisi i radhës', next ? fmtDate(next) : '—', overdue ? 'text-red-600' : 'text-gray-900'],
        ];
        el.summary.innerHTML = cards.map(([l, v, c]) => `
            <div class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                <p class="text-[11px] font-medium uppercase tracking-wide text-gray-500">${l}</p>
                <p class="mt-1 truncate text-base font-semibold ${c}">${esc(v)}</p>
            </div>`).join('');
    }

    function renderTabs() {
        const count = (t) => t === 'all' ? state.records.length : state.records.filter((r) => r.type === t).length;
        const ON  = 'bg-red-600 text-white ring-red-600';
        const OFF = 'bg-white text-gray-600 ring-gray-200 hover:bg-gray-100';
        el.tabs.innerHTML = [['all', 'Të gjitha'], ['service', 'Servise'], ['defect', 'Defekte']].map(([k, l]) => `
            <button type="button" data-filter="${k}"
                class="rounded-full px-3.5 py-1.5 text-sm font-medium ring-1 ring-inset ${state.filter === k ? ON : OFF}">
                ${l} <span class="opacity-70">${count(k)}</span>
            </button>`).join('');
    }

    function recordCard(r) {
        const isDefect = r.type === 'defect';
        const tone = isDefect ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600';
        const badges = isDefect
            ? badge(SEVERITY[r.severity] ?? SEVERITY.medium) + badge(STATUS[r.status] ?? STATUS.open)
            : badge({ label: 'Servis', cls: 'bg-blue-50 text-blue-700 ring-blue-200' });
        const meta = [fmtDate(r.record_date), fmtKm(r.odometer_km), r.workshop].filter(Boolean).map(esc).join(' · ');
        const next = !isDefect && r.next_service_date
            ? `<p class="mt-2 text-xs text-gray-500">Servisi i radhës: <span class="font-medium text-gray-700">${fmtDate(r.next_service_date)}</span></p>` : '';
        const solved = isDefect && r.status === 'resolved' && r.resolved_at
            ? `<p class="mt-2 text-xs text-green-700">Zgjidhur më ${fmtDate(r.resolved_at)}</p>` : '';
        const btn = 'rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-500';

        return `
        <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:shadow-md">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg ${tone}">${svg(isDefect ? ICON.warn : ICON.tool)}</div>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h4 class="text-sm font-semibold text-gray-900">${esc(r.title)}</h4>${badges}
                    </div>
                    <p class="mt-0.5 text-xs text-gray-500">${meta}</p>
                    ${r.description ? `<p class="mt-2 whitespace-pre-line text-sm text-gray-600">${esc(r.description)}</p>` : ''}
                    ${next}${solved}
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-900">${r.cost != null ? fmtMoney(r.cost) : ''}</span>
                        <div class="flex items-center gap-1">
                            ${isDefect && r.status !== 'resolved' ? `<button type="button" data-action="resolve" data-id="${r.id}" class="inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-medium text-green-700 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500">${svg(ICON.check, 'h-4 w-4')} Zgjidhe</button>` : ''}
                            <button type="button" data-action="edit" data-id="${r.id}" aria-label="Ndrysho" class="${btn} hover:text-blue-600">${svg(ICON.edit, 'h-4 w-4')}</button>
                            <button type="button" data-action="delete" data-id="${r.id}" aria-label="Fshij" class="${btn} hover:text-red-600">${svg(ICON.trash, 'h-4 w-4')}</button>
                        </div>
                    </div>
                </div>
            </div>
        </article>`;
    }

    function renderList() {
        const rows = state.records.filter((r) => state.filter === 'all' || r.type === state.filter);
        if (!rows.length) {
            const none = state.records.length === 0;
            el.list.innerHTML = `
                <div class="rounded-lg border border-dashed border-gray-300 bg-white px-6 py-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">${svg(ICON.tool, 'h-6 w-6')}</div>
                    <p class="mt-3 text-sm font-semibold text-gray-900">${none ? 'Ende pa regjistrime' : 'Asnjë rezultat në këtë filtër'}</p>
                    <p class="mt-1 text-sm text-gray-500">${none ? 'Shto servisin ose defektin e parë të këtij autobusi.' : 'Provo një filtër tjetër.'}</p>
                    ${none ? `<div class="mt-4 flex justify-center gap-2">
                        <button type="button" data-action="add-service" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">+ Servis</button>
                        <button type="button" data-action="add-defect" class="rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">+ Defekt</button>
                    </div>` : ''}
                </div>`;
            return;
        }
        el.list.innerHTML = rows.map(recordCard).join('');
    }

    // Rifreskon rreshtin e autobusit në tabelën e Mirëmbajtjes pa rifreskuar faqen
    async function refreshRow(busId) {
        const row = document.querySelector(`[data-mt-row="${busId}"]`);
        if (!row) return;
        try {
            const { records } = await api('GET', url('list', busId));
            const s = stats(records);
            const overdue = s.next && s.next < todayISO();

            const d = row.querySelector('[data-mt-defects]');
            d.textContent = s.openDefects ? `${s.openDefects} të hapura` : 'Asnjë';
            d.className = 'px-2 py-1 rounded text-xs font-medium ' + (s.openDefects ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500');

            row.querySelector('[data-mt-last]').textContent = fmtDMY(s.last);

            const n = row.querySelector('[data-mt-next]');
            n.textContent = s.next ? fmtDMY(s.next) + (overdue ? ' · vonuar' : '') : '—';
            n.className = 'text-sm ' + (overdue ? 'text-red-600 font-semibold' : 'text-gray-700');
        } catch { /* rreshti përditësohet në rifreskimin e radhës të faqes */ }
    }

    function upsert(rec) {
        const i = state.records.findIndex((r) => r.id === rec.id);
        if (i === -1) state.records.push(rec); else state.records[i] = rec;
        state.records.sort((a, b) => b.record_date.localeCompare(a.record_date) || b.id - a.id);
    }

    /* ---------- formulari ---------- */
    const SEG_ON  = 'bh-type rounded-md bg-white px-3 py-2 text-sm font-semibold text-red-600 shadow-sm';
    const SEG_OFF = 'bh-type rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700';
    const FIELDS = ['title', 'description', 'record_date', 'odometer_km', 'cost', 'workshop', 'severity', 'status', 'next_service_date'];

    // Sugjerime me një klik për titullin (vetëm kur shtohet regjistrim i ri)
    const SUGGEST = {
        service: ['Ndërrim vaji dhe filtrash', 'Ndërrim frenash', 'Ndërrim gomash', 'Servis i përgjithshëm', 'Kontroll teknik'],
        defect:  ['Zhurmë në motor', 'Problem me frenat', 'Klima nuk punon', 'Dritat nuk punojnë', 'Rrjedhje vaji'],
    };

    function renderChips(type) {
        el.chips.classList.toggle('hidden', !!state.editing);
        el.chips.innerHTML = SUGGEST[type].map((s) =>
            `<button type="button" data-chip="${esc(s)}" class="rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-600 hover:bg-red-50 hover:text-red-600">${esc(s)}</button>`).join('');
    }

    function setType(type) {
        el.form.elements.type.value = type;
        renderChips(type);
        if (!state.editing) {
            el.formTitle.textContent = (type === 'service' ? 'Servis i ri' : 'Defekt i ri') + (state.busName ? ' · ' + state.busName : '');
        }
        $$('.bh-type', el.form).forEach((b) => {
            const on = b.dataset.type === type;
            b.className = on ? SEG_ON : SEG_OFF;
            b.setAttribute('aria-pressed', on);
        });
        $$('[data-for]', el.form).forEach((g) => {
            const show = g.dataset.for === type;
            g.classList.toggle('hidden', !show);
            $$('input, select, textarea', g).forEach((i) => { i.disabled = !show; }); // fushat e fshehura nuk dërgohen
        });
        el.form.elements.title.placeholder = type === 'service' ? 'p.sh. Ndërrim vaji dhe filtrash' : 'p.sh. Zhurmë në frena';
    }

    function clearErrors() {
        $$('[data-error]', el.form).forEach((p) => { p.textContent = ''; p.classList.add('hidden'); });
        $$('.border-red-400', el.form).forEach((i) => i.classList.replace('border-red-400', 'border-gray-300'));
    }

    function showErrors(errors) {
        let first = null;
        Object.entries(errors).forEach(([key, msgs]) => {
            const p = $(`[data-error="${key}"]`, el.form);
            const input = el.form.elements[key];
            if (p) { p.textContent = msgs[0]; p.classList.remove('hidden'); }
            if (input && input.classList) { input.classList.replace('border-gray-300', 'border-red-400'); first ??= input; }
        });
        first?.focus();
    }

    function openForm(rec = null, type = 'service') {
        state.editing = rec;
        el.form.reset();
        clearErrors();
        el.formTitle.textContent = 'Ndrysho regjistrimin';
        el.submit.textContent = rec ? 'Ruaj ndryshimet' : 'Ruaj';
        setType(rec?.type ?? type);
        if (rec) {
            FIELDS.forEach((k) => { if (rec[k] != null) el.form.elements[k].value = rec[k]; });
        } else {
            el.form.elements.record_date.value = todayISO();
        }
        el.formWrap.classList.remove('hidden');
        el.formWrap.classList.add('flex');
        el.form.elements.title.focus();
    }

    function closeForm() {
        el.formWrap.classList.add('hidden');
        el.formWrap.classList.remove('flex');
        state.editing = null;
    }

    el.form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();
        const wasEditing = !!state.editing;
        const busId = state.busId;
        const label = el.submit.textContent;
        el.submit.disabled = true;
        el.submit.textContent = 'Duke ruajtur…';
        try {
            const payload = Object.fromEntries(new FormData(el.form));
            const { record } = wasEditing
                ? await api('PUT', url('update', state.editing.id), payload)
                : await api('POST', url('store', state.busId), payload);
            upsert(record);
            closeForm();
            render();
            refreshRow(busId);
            toast(wasEditing ? 'Regjistrimi u përditësua'
                : (payload.type === 'service' ? 'Servisi u shtua' : 'Defekti u shtua') + (state.busName ? ' te ' + state.busName : ''));
        } catch (err) {
            if (err.status === 422 && err.data?.errors) showErrors(err.data.errors);
            else toast('Ndodhi një gabim. Provo përsëri.', 'error');
        } finally {
            el.submit.disabled = false;
            el.submit.textContent = label;
        }
    });

    $$('.bh-type', el.form).forEach((b) => b.addEventListener('click', () => setType(b.dataset.type)));
    $('#bh-form-cancel').addEventListener('click', closeForm);
    $('#bh-form-x').addEventListener('click', closeForm);
    $('#bh-form-backdrop').addEventListener('click', closeForm);

    /* ---------- konfirmimi ---------- */
    let confirmResolve = null;
    function askConfirm(title, text) {
        el.confirmTitle.textContent = title;
        el.confirmText.textContent = text;
        el.confirmWrap.classList.remove('hidden');
        el.confirmWrap.classList.add('flex');
        el.confirmOk.focus();
        return new Promise((resolve) => { confirmResolve = resolve; });
    }
    function closeConfirm(value) {
        el.confirmWrap.classList.add('hidden');
        el.confirmWrap.classList.remove('flex');
        confirmResolve?.(value);
        confirmResolve = null;
    }
    el.confirmOk.addEventListener('click', () => closeConfirm(true));
    $('#bh-confirm-cancel').addEventListener('click', () => closeConfirm(false));
    $('#bh-confirm-backdrop').addEventListener('click', () => closeConfirm(false));

    /* ---------- ngjarjet ---------- */
    // Klikimi mbi një autobus (rresht/buton me data-bus-history) hap historikun
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-bus-history]');
        if (!trigger) return;
        const inner = e.target.closest('button, a, input, select, textarea, label');
        if (inner && inner !== trigger && trigger.contains(inner)) return; // mos e hap kur klikohen butonat e tjerë të rreshtit
        openPanel(trigger.dataset.busHistory, trigger.dataset.busName);
    });

    el.overlay.addEventListener('click', closePanel);
    $('#bh-close').addEventListener('click', closePanel);
    $('#bh-add-service').addEventListener('click', () => openForm(null, 'service'));
    $('#bh-add-defect').addEventListener('click', () => openForm(null, 'defect'));

    // Sugjerimet e titullit: një klik e plotëson fushën
    el.chips.addEventListener('click', (e) => {
        const b = e.target.closest('[data-chip]');
        if (!b) return;
        el.form.elements.title.value = b.dataset.chip;
        el.form.elements.odometer_km.focus();
    });

    // Shtim i shpejtë direkt nga tabela: hap vetëm formularin, pa historikun
    document.addEventListener('click', (e) => {
        const add = e.target.closest('[data-bus-add]');
        if (!add) return;
        Object.assign(state, { busId: add.dataset.busId, busName: add.dataset.busName, records: [], filter: 'all' });
        openForm(null, add.dataset.busAdd);
    });

    el.tabs.addEventListener('click', (e) => {
        const b = e.target.closest('[data-filter]');
        if (!b) return;
        state.filter = b.dataset.filter;
        renderTabs();
        renderList();
    });

    el.list.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;
        const action = btn.dataset.action;
        if (action === 'retry') return load();
        if (action === 'add-service') return openForm(null, 'service');
        if (action === 'add-defect') return openForm(null, 'defect');

        const rec = state.records.find((r) => r.id === Number(btn.dataset.id));
        if (!rec) return;
        const busId = state.busId;

        if (action === 'edit') return openForm(rec);

        if (action === 'resolve') {
            try {
                const { record } = await api('PATCH', url('resolve', rec.id));
                upsert(record);
                render();
                refreshRow(busId);
                toast('Defekti u shënua si i zgjidhur');
            } catch { toast('Veprimi dështoi.', 'error'); }
            return;
        }

        if (action === 'delete') {
            const ok = await askConfirm('Të fshihet regjistrimi?', `“${rec.title}” do të fshihet përgjithmonë.`);
            if (!ok) return;
            try {
                await api('DELETE', url('destroy', rec.id));
                state.records = state.records.filter((r) => r.id !== rec.id);
                render();
                refreshRow(busId);
                toast('Regjistrimi u fshi');
            } catch { toast('Fshirja dështoi.', 'error'); }
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        if (!el.confirmWrap.classList.contains('hidden')) return closeConfirm(false);
        if (!el.formWrap.classList.contains('hidden')) return closeForm();
        if (!el.drawer.classList.contains('hidden')) closePanel();
    });
})();
</script>