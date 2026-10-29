{{-- Quick Actions --}}
{{--
    Çdo kartë ka data-qa = tab-et ku shfaqet:
    dashboard (faqja kryesore), buses, maintenance, employees.
--}}
<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Veprimet e Shpejta</h2>
    <div id="qa-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

        {{-- Shto Autobus --}}
        <button type="button" data-qa="dashboard buses maintenance" onclick="openModal('addBusModal')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-red-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <p class="text-sm font-medium text-gray-900">Shto Autobus</p>
        </button>

        {{-- Shto Punonjës --}}
        <button type="button" data-qa="dashboard employees" onclick="openModal('addEmployeeModal')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <p class="text-sm font-medium text-gray-900">Shto Punonjës</p>
        </button>

        {{-- Edito Punonjës (modal CRUD) - shfaqet vetëm te tab-i Punonjësit --}}
        <button type="button" data-qa="employees" onclick="openModal('employeeManagerModal')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-teal-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            <p class="text-sm font-medium text-gray-900">Edito Punonjës</p>
        </button>

        {{-- Edito Autobuse (modal CRUD) --}}
        <button type="button" data-qa="dashboard buses maintenance" onclick="openModal('busManagerModal')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-indigo-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            <p class="text-sm font-medium text-gray-900">Edito Autobuse</p>
        </button>

        {{-- Mirëmbajtja (faqja me të gjithë autobusët) --}}
        <button type="button" data-qa="dashboard buses maintenance" onclick="bhShowTab('maintenance')" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-orange-600 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
            <p class="text-sm font-medium text-gray-900">Mirëmbajtja</p>
        </button>

        {{-- Raportet --}}
        <button type="button" data-qa="dashboard employees" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-medium text-gray-900">Shikoni Raportet</p>
        </button>

        {{-- Cilësimet --}}
        <button type="button" data-qa="dashboard" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-center">
            <svg class="w-6 h-6 text-purple-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p class="text-sm font-medium text-gray-900">Cilësimet</p>
        </button>

    </div>
</div>

<script>
// Shfaq vetëm kartat që i përkasin tab-it të hapur (shih data-qa te çdo kartë)
(function () {
    function init() {
        var grid = document.getElementById('qa-grid');
        var cards = grid ? [].slice.call(grid.querySelectorAll('[data-qa]')) : [];
        var tabs = [].slice.call(document.querySelectorAll('.tab-content'));
        if (!grid || !tabs.length) return;

        // Cili tab është i hapur: buses, maintenance, employees, ose dashboard (çdo tjetër)
        function context() {
            for (var i = 0; i < tabs.length; i++) {
                if (tabs[i].classList.contains('hidden')) continue;
                var name = (tabs[i].id || '').replace(/-content$/, '');
                if (/^employee/.test(name)) return 'employees';
                if (name === 'buses' || name === 'maintenance') return name;
                return 'dashboard';
            }
            return 'dashboard';
        }

        function sync() {
            var ctx = context();
            var shown = 0;
            cards.forEach(function (c) {
                var show = c.getAttribute('data-qa').split(' ').indexOf(ctx) !== -1;
                c.classList.toggle('hidden', !show);
                if (show) shown++;
            });
            grid.style.gridTemplateColumns = ctx === 'dashboard' ? '' : 'repeat(' + shown + ', minmax(0, 1fr))';
        }

        var observer = new MutationObserver(sync);
        tabs.forEach(function (t) { observer.observe(t, { attributes: true, attributeFilter: ['class'] }); });
        sync();
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>