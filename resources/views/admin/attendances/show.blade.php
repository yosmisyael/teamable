@extends('master')

@section('title')
    Attendance Details - Employee Management App
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
                <a href="{{ route('attendances.index') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">event_available</span>
                    <span>Attendance</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">Attendance Details</span>
            </nav>
        </div>

        @php
            $statusClasses = [
                'hadir' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200', 'gradient' => 'from-green-500 to-green-600'],
                'izin' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'gradient' => 'from-blue-500 to-blue-600'],
                'sakit' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'gradient' => 'from-amber-500 to-amber-600'],
                'alpha' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'gradient' => 'from-red-500 to-red-600'],
            ];
            $currentStatus = $statusClasses[$attendance->status_absensi] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'gradient' => 'from-gray-500 to-gray-600'];
        @endphp

        <div class="bg-white rounded-2xl card-shadow overflow-hidden fade-in mb-6">
            <div class="bg-gradient-to-r {{ $currentStatus['gradient'] }} px-8 py-12 relative overflow-hidden">
                <div class="relative">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm p-4 rounded-xl shadow-lg">
                                <span class="material-icons text-white text-3xl">person</span>
                            </div>
                            <div>
                                <p class="text-white text-opacity-80 text-sm font-medium mb-1">Attendance for {{ \Carbon\Carbon::parse($attendance->tanggal)->format('d F Y') }}</p>
                                <h1 class="text-3xl font-bold text-white">{{ $attendance->employee->nama_lengkap ?? 'N/A' }}</h1>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0">
                             <span class="px-4 py-2 text-sm leading-5 font-semibold rounded-full {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }}">
                                {{ ucfirst($attendance->status_absensi) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="info-card {{ $currentStatus['bg'] }} rounded-xl p-6 border {{ $currentStatus['border'] }}">
                        <p class="text-sm {{ $currentStatus['text'] }} opacity-80 font-medium mb-1">Clock In Time</p>
                        <p class="text-3xl font-bold {{ $currentStatus['text'] }}">{{ $attendance->waktu_masuk ? \Carbon\Carbon::parse($attendance->waktu_masuk)->format('H:i') : 'N/A' }}</p>
                    </div>

                    <div class="info-card {{ $currentStatus['bg'] }} rounded-xl p-6 border {{ $currentStatus['border'] }}">
                        <p class="text-sm {{ $currentStatus['text'] }} opacity-80 font-medium mb-1">Clock Out Time</p>
                        <p class="text-3xl font-bold {{ $currentStatus['text'] }}">{{ $attendance->waktu_keluar ? \Carbon\Carbon::parse($attendance->waktu_keluar)->format('H:i') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('attendances.index') }}"
                       class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">arrow_back</span>
                        <span>Back to List</span>
                    </a>
                    <a href="{{ route('attendances.edit', $attendance->id) }}"
                       class="flex-1 btn-ripple px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-medium rounded-lg hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">edit</span>
                        <span>Edit Record</span>
                    </a>
                    <button onclick="openDeleteModal()"
                            class="flex-1 btn-ripple px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span class="material-icons text-sm">delete</span>
                        <span>Delete Record</span>
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
                    <h3 class="text-xl font-semibold text-gray-900">Delete Attendance Record</h3>
                    <p class="text-gray-600">This action is permanent.</p>
                </div>
            </div>
            <p class="text-gray-700 mb-8">
                Are you sure you want to delete this attendance record?
            </p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                    Cancel
                </button>
                <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-300">
                        Delete Record
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
