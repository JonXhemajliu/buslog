{{-- Modali "Edito Punonjës": CRUD i punonjësve (shto / ndrysho / fshi) --}}
<div id="employeeManagerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40 p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] flex flex-col">

        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Edito Punonjësit</h2>
                <p class="text-sm text-gray-500">Shto, ndrysho ose fshi punonjësit e ekipit</p>
            </div>
            <div class="flex items-center gap-4">
                <button type="button" onclick="openModal('addEmployeeModal')"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                    + Shto Punonjës
                </button>
                <button type="button" onclick="closeModal('employeeManagerModal')" aria-label="Mbyll" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div class="overflow-y-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase sticky top-0">
                    <tr>
                        <th class="px-6 py-3">Emri</th>
                        <th class="px-4 py-3">Posti</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-6 py-3 text-right">Veprimet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $employee->name }} {{ $employee->surname }}</td>
                            <td class="px-4 py-3">{{ $employee->title }}</td>
                            <td class="px-4 py-3">{{ $employee->username }}</td>
                            <td class="px-4 py-3">{{ $employee->email }}</td>
                            <td class="px-6 py-3 text-right whitespace-nowrap">
                                <button type="button"
                                        data-employee="{{ json_encode($employee) }}"
                                        onclick="editEmployee(this)"
                                        class="text-blue-600 hover:underline mr-3">Ndrysho</button>

                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Je i sigurt?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Fshij</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Nuk ka punonjës.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('employeeManagerModal');

    // Klikimi jashtë modalit e mbyll
    modal.addEventListener('click', function (e) {
        if (e.target === modal) modal.classList.add('hidden');
    });

    // Esc e mbyll, por vetëm nëse modalet e shtimit/ndryshimit (sipër) nuk janë hapur
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape' || modal.classList.contains('hidden')) return;
        var add = document.getElementById('addEmployeeModal');
        var edit = document.getElementById('editEmployeeModal');
        var onTop = (add && !add.classList.contains('hidden')) || (edit && !edit.classList.contains('hidden'));
        if (!onTop) modal.classList.add('hidden');
    });
})();
</script>