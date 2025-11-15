@extends('master')

@section('title')
    Salaries - Employee Management App
@endsection

@section('style')
    <style>
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }
        .btn-ripple::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn-ripple:active::before {
            width: 300px;
            height: 300px;
        }
        .search-input {
            transition: all 0.3s ease;
        }
        .search-input:focus {
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        tbody tr:hover {
            background-color: #f9fafb; /* gray-50 */
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Success/Error Alert Messages --}}
        @if (session('success') || session('error'))
            @php
                $isSuccess = session('success');
                $message = $isSuccess ?? session('error');
                $alertClass = $isSuccess ? 'bg-green-100 border-green-400 text-green-800' : 'bg-red-100 border-red-400 text-red-800';
            @endphp
            <div id="alert" class="{{ $alertClass }} border-l-4 p-4 rounded-lg relative mb-4" role="alert">
                <div class="flex">
                    <div class="py-1">
                        @if($isSuccess)
                            <svg class="h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @else
                            <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold">{{ $isSuccess ? 'Success' : 'Error' }}</p>
                        <p class="text-sm">{{ $message }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('alert').classList.add('hidden')" class="absolute top-2.5 right-2.5 text-gray-500 hover:text-gray-800">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        <div class="bg-white rounded-2xl card-shadow p-6 mb-8 fade-in">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3.5 rounded-full shadow-lg">
                        <span class="material-icons text-white text-2xl">payments</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Salary Records</h2>
                        <p class="text-sm text-gray-600 mt-1">Manage all employee salary slips</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('salaries.create') }}"
                       class="btn-ripple px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2">
                        <span class="material-icons text-sm">add</span>
                        <span>Create Salary Slip</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl card-shadow overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Salary</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allowance</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deduction</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Salary</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($salaries as $salary)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{-- Assumes you eager load the employee: Salary::with('employee')->get() --}}
                                {{ $salary->employee->nama_lengkap ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $salary->bulan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($salary->gaji_pokok, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">+ Rp {{ number_format($salary->tunjangan, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">- Rp {{ number_format($salary->potongan, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($salary->total_gaji, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('salaries.show', $salary->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 transition-colors" title="View Details">
                                    <span class="material-icons text-sm">visibility</span>
                                </a>
                                <a href="{{ route('salaries.edit', $salary->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-md hover:bg-amber-100 transition-colors" title="Edit Salary">
                                    <span class="material-icons text-sm">edit</span>
                                </a>
                                <button onclick="openDeleteModal({{ $salary->id }}, '{{ addslashes($salary->employee->nama_lengkap ?? 'N/A') }} for {{ $salary->bulan }}')" class="p-2 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition-colors" title="Delete Salary">
                                    <span class="material-icons text-sm">delete</span>
                                </button>
                                <form id="deleteSalaryForm{{ $salary->id }}" action="{{ route('salaries.destroy', $salary->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                <span class="material-icons text-4xl text-gray-300">receipt_long</span>
                                <p class="mt-2 font-medium">No salary records found</p>
                                <p class="mt-1">Get started by creating a new salary slip.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 card-shadow">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <span class="material-icons text-red-600 text-xl">warning</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Delete Salary Record</h3>
                    <p class="text-gray-600">This action cannot be undone.</p>
                </div>
            </div>
            <p class="text-gray-700 mb-8">
                Are you sure you want to delete the salary record for <span id="salaryIdentifier" class="font-semibold"></span>?
            </p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                    Cancel
                </button>
                <button onclick="confirmDelete()" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                    Delete Record
                </button>
            </div>
        </div>
    </div>

    <script>
        let formToSubmitId = null;
        const deleteModal = document.getElementById('deleteModal');
        const salaryIdentifierSpan = document.getElementById('salaryIdentifier');

        function openDeleteModal(salaryId, identifier) {
            formToSubmitId = `deleteSalaryForm${salaryId}`;
            salaryIdentifierSpan.textContent = identifier;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            formToSubmitId = null;
        }

        function confirmDelete() {
            if (formToSubmitId) {
                document.getElementById(formToSubmitId).submit();
            }
        }

        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        });
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
