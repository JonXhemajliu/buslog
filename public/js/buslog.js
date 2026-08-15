// ============================================================
//  BusLog — JavaScript kryesor
//  Ky file ngarkohet nga layouts/app.blade.php
// ============================================================

// ---------- Të dhënat (do zëvendësohen me API/Eloquent) ----------
let buses = [
    {
        id: 1, name: 'Autobusi Nr.1', year: 2018,
        services: [
            { type: 'Ndërrim i vajit të motorit', price: 45,  mechanic: 'Fatlum Krasniqi', date: '2026-06-10', note: '' },
            { type: 'Servis i përgjithshëm',      price: 120, mechanic: 'Arben Gashi',     date: '2026-05-02', note: 'Kontroll i frenave dhe filtrave.' },
        ]
    },
    { id: 2, name: 'Autobusi Nr.2', year: 2021, services: [
        { type: 'Ndërrim gomash', price: 210, mechanic: 'Driton Berisha', date: '2026-04-18', note: '' },
    ]},
    { id: 3, name: 'Autobusi Nr.3', year: 2016, services: [] },
];
let nextBusId    = 4;
let currentBusId = null;
let selectedType = null;

// ---------- Llojet e servisimit ----------
const TYPES = [
    { key: 'oil',      label: 'Ndërrim i vajit të motorit', icon: '<path d="M12 2s6 7 6 11a6 6 0 11-12 0c0-4 6-11 6-11z"/>' },
    { key: 'general',  label: 'Servis i përgjithshëm',      icon: '<path d="M14.7 6.3a4 4 0 00-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 005.4-5.4l-2.1 2.1-2-2z"/>' },
    { key: 'engine',   label: 'Defekt i motorit',            icon: '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/>' },
    { key: 'tires',    label: 'Ndërrim gomash',              icon: '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="2"/><path d="M12 4v2M12 18v2M4 12h2M18 12h2"/>' },
    { key: 'brakes',   label: 'Sistemi i frenave',           icon: '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3"/><path d="M12 3v6M12 15v6"/>' },
    { key: 'electric', label: 'Sistemi elektrik',            icon: '<path d="M13 2 3 14h7l-1 8 10-12h-7l1-8z"/>' },
    { key: 'body',     label: 'Karoseri / Gërvishtje',       icon: '<path d="M5 11l1.5-4.5A2 2 0 018.4 5h7.2a2 2 0 011.9 1.5L19 11"/><rect x="3" y="11" width="18" height="6" rx="2"/><circle cx="7.5" cy="17" r="1.4"/><circle cx="16.5" cy="17" r="1.4"/>' },
    { key: 'other',    label: 'Tjetër',                      icon: '<circle cx="5" cy="12" r="1.4"/><circle cx="12" cy="12" r="1.4"/><circle cx="19" cy="12" r="1.4"/>' },
];

// ============================================================
//  NAVIGIMI
// ============================================================

function showPage(id) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    window.scrollTo(0, 0);
    if (id === 'page-dashboard') renderBusList();
}

function goToAuth(tab) {
    showPage('page-auth');
    showAuthTab(tab);
}

function showAuthTab(tab) {
    const loginForm    = document.getElementById('form-login');
    const registerForm = document.getElementById('form-register');
    const tabLogin     = document.getElementById('tab-login');
    const tabRegister  = document.getElementById('tab-register');

    if (tab === 'login') {
        loginForm.style.display    = 'flex';
        registerForm.style.display = 'none';
        tabLogin.classList.add('active');
        tabRegister.classList.remove('active');
    } else {
        loginForm.style.display    = 'none';
        registerForm.style.display = 'flex';
        tabRegister.classList.add('active');
        tabLogin.classList.remove('active');
    }
}

// ============================================================
//  DASHBOARD — lista e autobusëve
// ============================================================

function renderBusList() {
    const grid = document.getElementById('bus-grid');
    grid.innerHTML = buses.map(b => `
        <button onclick="openBusDetail(${b.id})"
                class="text-left p-5 rounded-2xl border border-gray-200 hover:border-red-300 hover:shadow-sm transition">
            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center mb-3">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="11" rx="2"/>
                    <path d="M3 11h18"/><path d="M7 16v3M17 16v3"/>
                    <circle cx="7" cy="19" r="1.3"/><circle cx="17" cy="19" r="1.3"/>
                </svg>
            </div>
            <p class="font-display font-semibold">${b.name}</p>
            <p class="text-sm text-gray-500 mb-3">Viti i prodhimit: ${b.year}</p>
            <p class="text-xs font-medium text-red-600">${b.services.length} servisime të regjistruara</p>
        </button>
    `).join('');
}

// ============================================================
//  MODAL — shto autobus
// ============================================================

function openAddBusModal() {
    document.getElementById('add-bus-backdrop').classList.remove('hidden');
}

function closeAddBusModal() {
    document.getElementById('add-bus-backdrop').classList.add('hidden');
    document.getElementById('add-bus-form').reset();
}

function submitAddBus(e) {
    e.preventDefault();
    buses.push({
        id:       nextBusId++,
        name:     document.getElementById('new-bus-name').value,
        year:     document.getElementById('new-bus-year').value,
        services: [],
    });
    closeAddBusModal();
    renderBusList();
}

// ============================================================
//  BUS DETAIL
// ============================================================

function openBusDetail(id) {
    currentBusId = id;
    selectedType = null;
    const bus = buses.find(b => b.id === id);

    document.getElementById('detail-name').textContent = bus.name;
    document.getElementById('detail-year').textContent = 'Viti i prodhimit: ' + bus.year;

    renderTypeGrid();
    document.getElementById('service-form').classList.add('hidden');
    renderServiceHistory();
    showPage('page-bus-detail');
}

function renderTypeGrid() {
    document.getElementById('type-grid').innerHTML = TYPES.map(t => `
        <button type="button" onclick="selectType('${t.key}')" data-key="${t.key}"
                class="type-card flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-gray-200 transition text-center">
            <span class="type-icon w-9 h-9 rounded-full bg-red-50 text-red-600 flex items-center justify-center transition">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    ${t.icon}
                </svg>
            </span>
            <span class="text-xs font-medium leading-tight">${t.label}</span>
        </button>
    `).join('');
}

function selectType(key) {
    selectedType = key;
    document.querySelectorAll('.type-card').forEach(c => c.classList.toggle('active', c.dataset.key === key));
    document.getElementById('selected-type-label').textContent = TYPES.find(t => t.key === key).label;
    document.getElementById('service-form').classList.remove('hidden');
    document.getElementById('service-date').valueAsDate = new Date();
}

function submitService(e) {
    e.preventDefault();
    const bus = buses.find(b => b.id === currentBusId);
    bus.services.unshift({
        type:     TYPES.find(t => t.key === selectedType).label,
        price:    document.getElementById('service-price').value,
        mechanic: document.getElementById('service-mechanic').value,
        date:     document.getElementById('service-date').value,
        note:     document.getElementById('service-note').value,
    });
    document.getElementById('service-form').reset();
    document.getElementById('service-form').classList.add('hidden');
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('active'));
    renderServiceHistory();
}

function renderServiceHistory() {
    const bus = buses.find(b => b.id === currentBusId);
    const box = document.getElementById('service-history');

    if (bus.services.length === 0) {
        box.innerHTML = `
            <div class="text-sm text-gray-500 border border-gray-200 rounded-xl p-6 text-center">
                Ende s'ka servisime të regjistruara për këtë autobus.
            </div>`;
        return;
    }

    box.innerHTML = bus.services.map(s => `
        <div class="flex items-center justify-between p-4 rounded-xl border border-gray-200">
            <div>
                <p class="font-medium text-sm">${s.type}</p>
                <p class="text-xs text-gray-500">
                    ${s.mechanic} · ${s.date}${s.note ? ' · ' + s.note : ''}
                </p>
            </div>
            <span class="font-display font-semibold text-red-600 text-sm">
                €${Number(s.price).toFixed(2)}
            </span>
        </div>
    `).join('');
}