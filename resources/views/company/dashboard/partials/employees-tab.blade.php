{{-- EMPLOYEES TAB --}}
<div id="employees-content" class="tab-content hidden mt-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Punonjësit</h1>
            <p class="text-gray-500 mt-1">Menaxhimi i ekipit tuaj</p>
        </div>
        <button type="button" onclick="openModal('addEmployeeModal')"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
            + Shto Punonjës
        </button>
    </div>
<button type="button" onclick="switchTab('dashboard')"
        class="mb-4 inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    Kthehu
</button>
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-x-auto">
        <table class="w-full text-left table-fixed min-w-[700px]">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase">
                <tr>
                    <th class="px-6 py-3 w-1/4">Emri</th>
                    <th class="px-6 py-3 w-1/5">Posti</th>
                    <th class="px-6 py-3 w-1/6">Username</th>
                    <th class="px-6 py-3 w-1/4">Email</th>
                    <th class="px-6 py-3 w-1/6 text-right">Veprimet</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($employees as $employee)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 truncate">{{ $employee->name }} {{ $employee->surname }}</td>
                        <td class="px-6 py-4 truncate">{{ $employee->title }}</td>
                        <td class="px-6 py-4 truncate">{{ $employee->username }}</td>
                        <td class="px-6 py-4 truncate">{{ $employee->email }}</td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
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
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nuk ka punonjës.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>