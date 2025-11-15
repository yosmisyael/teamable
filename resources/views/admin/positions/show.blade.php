@extends('master')

@section('title')
    {{ $position->nama_jabatan ?? 'Position Details' }} - Employee Management App
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
        <div class="mb-6 fade-in">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('positions.index') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">work</span>
                    <span>Positions</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">{{ $position->nama_jabatan ?? 'Position Details' }}</span>
            </nav>
        </div>

        <div class="bg-white rounded-2xl card-shadow overflow-hidden fade-in mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-12 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute transform rotate-45 -right-20 -top-20 w-40 h-40 bg-white rounded-full"></div>
                    <div class="absolute transform rotate-45 -left-20 -bottom-20 w-32 h-32 bg-white rounded-full"></div>
                </div>

                <div class="relative">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm p-4 rounded-xl shadow-lg">
                                <span class="material-icons text-white text-3xl">work</span>
                            </div>
                            <div>
                                <p class="text-blue-100 text-sm font-medium mb-1">Position</p>
                                <h1 class="text-3xl font-bold text-white">{{ $position->nama_jabatan ?? 'N/A' }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="text-blue-100 font-semibold text-lg">
                        Base Salary: Rp {{ number_format($position->gaji_pokok, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="info-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="bg-blue-500 bg-opacity-20 p-3 rounded-lg inline-block mb-4">
                            <span class="material-icons text-blue-900 text-xl">people</span>
                        </div>
                        <p class="text-sm text-blue-600 font-medium mb-1">Employees in this Role</p>
                        {{-- Assuming you pass employees_count from controller with withCount('employees') --}}
                        <p class="text-3xl font-bold text-blue-900">{{ $position->employees_count ?? 0 }}</p>
                    </div>

                    <div class="info-card bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                        <div class="bg-green-500 bg-opacity-20 p-3 rounded-lg inline-block mb-4">
                            <span class="material-icons text-green-900 text-xl">event</span>
                        </div>
                        <p class="text-sm text-green-600 font-medium mb-1">Date Created</p>
                        <p class="text-2xl font-bold text-green-900">{{ $position->created_at ? $position->created_at->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <div class="info-card bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="bg-purple-500 bg-opacity-20 p-3 rounded-lg inline-block mb-4">
                            <span class="material-icons text-purple-900 text-xl">update</span>
                        </div>
                        <p class="text-sm text-purple-600 font-medium mb-1">Last Updated</p>
                        <p class="text-2xl font-bold text-purple-900">{{ $position->updated_at ? $position->updated_at->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('positions.index') }}"
                       class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">arrow_back</span>
                        <span>Back to List</span>
                    </a>
                    <a href="{{ route('positions.edit', $position->id) }}"
                       class="flex-1 btn-ripple px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-medium rounded-lg hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">edit</span>
                        <span>Edit Position</span>
                    </a>
                    <button onclick="openDeleteModal()"
                            class="flex-1 btn-ripple px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">delete</span>
                        <span>Delete Position</span>
                    </button>
                </div>
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
                    <h3 class="text-xl font-semibold text-gray-900">Delete Position</h3>
                    <p class="text-gray-600">This action cannot be undone.</p>
                </div>
            </div>
            <p class="text-gray-700 mb-8">
                Are you sure you want to delete the position <span class="font-semibold">{{ $position->nama_jabatan ?? 'N/A' }}</span>?
                This may affect employees currently assigned to this role.
            </p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                    Cancel
                </button>
                {{-- This form is outside the button to avoid nesting forms if this modal were ever moved --}}
                <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                        Delete Position
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const deleteModal = document.getElementById('deleteModal');

        function openDeleteModal() {
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // Close modal when clicking outside of it or pressing Escape key
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
