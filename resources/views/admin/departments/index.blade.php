@extends('master')

@section('title')
    Departments - Employee Management App
@endsection

@section('style')
    <style>
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
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
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .department-card {
            transition: all 0.3s ease;
        }

        .department-card:hover {
            transform: translateY(-4px);
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{--  alert  --}}
        @if (session('success') || session('error'))
            @php
                $isSuccess = session('success');
                $message = $isSuccess ?? session('error');
                $alertClass = $isSuccess ? 'bg-green-100 border-green-400 text-green-800' : 'bg-red-100 border-red-400 text-red-800';
                $iconClass = $isSuccess ? 'fa-check-circle' : 'fa-times-circle';
            @endphp
            <div id="alert" class="{{ $alertClass }} border-l-4 p-4 rounded-lg relative mb-4" role="alert">
                <div class="flex">
                    <div class="py-1">
                        {{-- Success Icon (Checkmark) --}}
                        @if($isSuccess)
                            <svg class="h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            {{-- Error Icon (X-Circle) --}}
                            <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold">{{ $isSuccess ? 'Success' : 'Error' }}</p>
                        <p class="text-sm">{{ $message }}</p>
                    </div>
                </div>

                <button onclick="document.getElementById('alert').classList.add('hidden')" class="absolute top-2.5 right-2.5 text-gray-500 hover:text-gray-800">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Departments</p>
                        <p class="text-3xl font-bold text-gray-900" id="total-departments">{{ $departments->count() }}</p>
                    </div>
                    <div class="bg-blue-100 px-[16px] py-3 rounded-full">
                        <span class="material-icons text-blue-600 text-xl">apartment</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Active Employees</p>
                        <p class="text-3xl font-bold text-green-600">{{ $employeesCount }}</p>
                    </div>
                    <div class="bg-green-100 px-[16px] py-3 rounded-full">
                        <span class="material-icons text-green-600 text-xl">people</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Average per Department</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $employeesCount == 0 ? 0 : $employeesCount / $departments->count() }}</p>
                    </div>
                    <div class="bg-blue-100 px-[15px] py-3 rounded-full">
                        <span class="material-icons text-blue-600 text-xl">analytics</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="bg-white rounded-2xl card-shadow overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="material-icons text-white text-2xl">apartment</span>
                        <h2 class="text-2xl font-semibold text-white">Department Directory</h2>
                    </div>
                    <div class="text-blue-100 text-sm">
                        <span id="department-count">{{ $departments->count() }}</span> departments found
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Actions Bar -->
        <div class="bg-white rounded-2xl card-shadow p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                        <input type="text"
                               placeholder="Search departments..."
                               class="search-input pl-10 pr-4 py-3 w-64 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                               id="searchInput"
                               onkeyup="searchDepartments()">
                    </div>
                    <select
                        class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                        id="sortFilter" onchange="sortDepartments()">
                        <option value="name-asc">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                    </select>
                </div>

                <div class="flex items-center space-x-3">
                    <button
                        class="px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center space-x-2">
                        <span class="material-icons text-sm">download</span>
                        <span>Export</span>
                    </button>
                    <a href="{{ route('departments.create') ?? '#' }}"
                       class="btn-ripple px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2">
                        <span class="material-icons text-sm">add</span>
                        <span>Add Department</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Department Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="departmentGrid">
            @foreach($departments as $department)
                <div class="department-card bg-white rounded-2xl card-shadow overflow-hidden" data-name="{{ $department->nama_departemen }}"
                     data-date="2024-01-15">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                                <span class="material-icons text-blue-600 text-2xl">people</span>
                            </div>
                            <span class="text-blue-600 text-xs font-medium bg-white bg-opacity-20 px-3 py-1 rounded-full">{{ $department->employees_count }} Employees</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">{{ $department->nama_departemen }}</h3>
                        <p class="text-blue-100 text-sm">Department ID: {{ $department->id }}</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <span class="material-icons text-blue-500 text-sm mr-2">event</span>
                                <span>Founded on {{ $department->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('departments.show', $department->id) ?? '#' }}"
                               class="px-4 py-2 bg-blue-50 text-blue-600 text-center rounded-lg hover:bg-blue-100 transition-colors duration-200 flex items-center justify-center space-x-1">
                                <span class="material-icons text-sm">visibility</span>
                            </a>
                            <a href="{{ route('departments.edit', $department->id) ?? '#' }}"
                               class="px-4 py-2 bg-amber-50 text-amber-600 text-center rounded-lg hover:bg-amber-100 transition-colors duration-200 flex items-center justify-center space-x-1">
                                <span class="material-icons text-sm">edit</span>
                            </a>
                            <button onclick="openDeleteModal({{ $department->id }}, '{{ $department->nama_departemen }}')"
                                    class="px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                <span class="material-icons text-sm">delete</span>
                            </button>
                            <form class="hidden" id="deleteDepartment{{ $department->id }}" action="{{ route('departments.destroy', ['department' => $department->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 card-shadow">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <span class="material-icons text-red-600 text-xl">warning</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Delete Department</h3>
                        <p class="text-gray-600">Are you sure you want to delete the department
                            <span id="departmentNameToDelete" class="font-semibold"></span>?
                            All associated data will be permanently removed.
                        </p>
                    </div>
                </div>
                <p class="text-gray-700 mb-8">
                    Are you sure you want to delete the department <span id="departmentNameSpan" class="font-semibold"></span>?
                    All associated data will be permanently removed.
                </p>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" onclick="confirmDeleteDepartment()" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                        Delete Department
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const deleteModal = document.getElementById('deleteModal');
        const departmentNameSpan = document.getElementById('departmentNameSpan');
        let formIdToSubmit = null;

        // Delete modal functions
        function openDeleteModal(departmentId, departmentName) {
            formIdToSubmit = `deleteDepartment${departmentId}`;
            departmentNameSpan.textContent = `${departmentName} (ID: ${departmentId})`;
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            formIdToSubmit = null;
        }

        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        function confirmDeleteDepartment() {
            if (formIdToSubmit) {
                document.getElementById(formIdToSubmit).submit();
            }
        }
    </script>
@endsection
