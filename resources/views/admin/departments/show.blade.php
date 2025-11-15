@extends('master')

@section('title')
    {{ $department->nama_departemen ?? 'Department Details' }} - Employee Management App
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
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .info-card {
            transition: all 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6 fade-in">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ url('/department') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">apartment</span>
                    <span>Departments</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">{{ $department->nama_departemen ?? 'Department Details' }}</span>
            </nav>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl card-shadow overflow-hidden fade-in mb-6">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-12 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute transform rotate-45 -right-20 -top-20 w-40 h-40 bg-white rounded-full"></div>
                    <div class="absolute transform rotate-45 -left-20 -bottom-20 w-32 h-32 bg-white rounded-full"></div>
                </div>

                <div class="relative">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm py-4 px-5 rounded-xl shadow-lg">
                                <span class="material-icons text-blue-600 text-3xl mt-1">apartment</span>
                            </div>
                            <div>
                                <p class="text-blue-100 text-sm font-medium mb-1">Department</p>
                                <h1 class="text-3xl font-bold text-white">{{ $department->nama_departemen ?? 'N/A' }}</h1>
                            </div>
                        </div>
                        <div class="hidden sm:block bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2 rounded-lg">
                            <span class="text-blue-100 text-xs font-medium">ID: DEPT{{ str_pad($department->id ?? '001', 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Employees -->
                    <div class="info-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-500 bg-opacity-20 p-3 rounded-lg">
                                <span class="material-icons text-blue-900 text-xl mx-1">people</span>
                            </div>
                        </div>
                        <p class="text-sm text-blue-600 font-medium mb-1">Total Employees</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $totalEmployees ?? 0 }}</p>
                        <p class="text-xs text-blue-600 mt-2">Active members</p>
                    </div>

                    <!-- Founded Date -->
                    <div class="info-card bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-green-500 bg-opacity-20 p-3 rounded-lg">
                                <span class="material-icons text-green-900 mx-1 text-xl">event</span>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 font-medium mb-1">Founded Date</p>
                        <p class="text-2xl font-bold text-green-900">{{ $department->created_at ? $department->created_at->format('M d, Y') : 'N/A' }}</p>
                        <p class="text-xs text-green-600 mt-2">{{ $department->created_at ? $department->created_at->diffForHumans() : 'N/A' }}</p>
                    </div>

                    <!-- Last Updated -->
                    <div class="info-card bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-purple-500 bg-opacity-20 p-3 rounded-lg">
                                <span class="material-icons text-purple-900 mx-1 text-xl">update</span>
                            </div>
                        </div>
                        <p class="text-sm text-purple-600 font-medium mb-1">Last Updated</p>
                        <p class="text-2xl font-bold text-purple-900">{{ $department->updated_at ? $department->updated_at->format('M d, Y') : 'N/A' }}</p>
                        <p class="text-xs text-purple-600 mt-2">{{ $department->updated_at ? $department->updated_at->diffForHumans() : 'N/A' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ url('/departments') }}"
                       class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">arrow_back</span>
                        <span>Back to List</span>
                    </a>
                    <a href="{{ route('departments.edit', $department->id ?? 1) }}"
                       class="flex-1 btn-ripple px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-medium rounded-lg hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">edit</span>
                        <span>Edit Department</span>
                    </a>
                    <button onclick="openDeleteModal()"
                            class="flex-1 btn-ripple px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">delete</span>
                        <span>Delete Department</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
            <div class="flex items-start">
                <div class="bg-blue-100 p-2 rounded-lg mr-4">
                    <span class="material-icons text-blue-600 text-sm">info</span>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Department Information</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        This department was created on <span class="font-medium text-gray-900">{{ $department->created_at ? $department->created_at->format('F d, Y') : 'N/A' }}</span>
                        and currently has <span class="font-medium text-gray-900">{{ $totalEmployees ?? 0 }} employee(s)</span> assigned to it.
                        @if($department->updated_at && $department->updated_at != $department->created_at)
                            The last modification was made on <span class="font-medium text-gray-900">{{ $department->updated_at->format('F d, Y') }}</span>.
                        @endif
                    </p>
                </div>
            </div>
        </div>
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
                    <p class="text-gray-600">This action cannot be undone</p>
                </div>
            </div>
            <p class="text-gray-700 mb-8">
                Are you sure you want to delete the department <span class="font-semibold">{{ $department->nama_departemen ?? 'N/A' }}</span>?
                This will permanently remove the department and all associated data.
            </p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                    Cancel
                </button>
                <form action="{{ route('departments.destroy', $department->id ?? 1) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                        Delete Department
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Delete modal functions
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
