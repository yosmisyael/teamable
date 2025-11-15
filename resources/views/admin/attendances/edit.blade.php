@extends('master')

@section('title')
    Edit Attendances - Employee Management App
@endsection

@section('style')
    <style>
        .material-input {
            transition: all 0.3s ease;
        }
        .material-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }
        .floating-label {
            transition: all 0.2s ease-in-out;
        }
        /* Style for text, date, time inputs */
        .input-container.input-focused .floating-label,
        .input-container.input-filled .floating-label {
            transform: translateY(-36px) scale(0.85);
            color: #3b82f6; /* blue-500 */
            padding: 8px 16px;
            background-color: #fff;
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
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
    </style>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 fade-in">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('attendances.index') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">event</span>
                    <span>Attendance</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">Edit Attendances</span>
            </nav>
        </div>

        <div class="mb-8 fade-in">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-amber-500 to-amber-600 py-3 px-4 rounded-full mr-4 shadow-lg">
                            <span class="material-icons text-white text-xl">edit_calendar</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Edit Attendance Log</h2>
                            {{-- Asumsi ada relasi ke employee dan kolom nama --}}
                            <p class="text-sm text-gray-600 mt-1">Update attendance log of employee {{ $attendance->employee->nama }}</p>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <span class="material-icons text-red-500 text-sm mt-0.5 mr-3">error</span>
                            <div>
                                <p class="text-sm text-red-900 font-medium">Please fix the following errors:</p>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('attendances.update', $attendance->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- Karyawan (Dropdown) --}}
                    <div>
                        <label for="karyawan_id" class="block text-sm font-medium text-gray-700 mb-2">Karyawan</label>
                        <select id="karyawan_id" name="karyawan_id" class="material-input w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none @error('karyawan_id') border-red-500 @enderror" required disabled>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('karyawan_id', $attendance->karyawan_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('karyawan_id')
                        <p class="mt-2 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="input-container relative">
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $attendance->tanggal->format('Y-m-d')) }}"
                               class="material-input w-full px-4 pt-4 pb-2 border-2 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer @error('tanggal') border-red-500 @enderror"
                               required
                               onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                        <label for="tanggal" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                            Tanggal
                        </label>
                        @error('tanggal')
                        <p class="mt-2 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Waktu Masuk & Keluar (Side by Side) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="input-container relative">
                            <input type="time" id="waktu_masuk" name="waktu_masuk" value="{{ old('waktu_masuk', $attendance->waktu_masuk) }}"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer @error('waktu_masuk') border-red-500 @enderror"
                                   onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                            <label for="waktu_masuk" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Waktu Masuk
                            </label>
                            @error('waktu_masuk')
                            <p class="mt-2 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="input-container relative">
                            <input type="time" id="waktu_keluar" name="waktu_keluar" value="{{ old('waktu_keluar', $attendance->waktu_keluar) }}"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer @error('waktu_keluar') border-red-500 @enderror"
                                   onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                            <label for="waktu_keluar" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Waktu Keluar
                            </label>
                            @error('waktu_keluar')
                            <p class="mt-2 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status Absensi (Dropdown) --}}
                    <div>
                        <label for="status_absensi" class="block text-sm font-medium text-gray-700 mb-2">Status Absensi</label>
                        <select id="status_absensi" name="status_absensi" class="material-input w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none @error('status_absensi') border-red-500 @enderror" required>
                            @foreach(['hadir', 'izin', 'sakit', 'alpha'] as $status)
                                <option value="{{ $status }}" {{ old('status_absensi', $attendance->status_absensi) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_absensi')
                        <p class="mt-2 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('attendances.show', $attendance->id) }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">close</span>
                            <span>Cancel</span>
                        </a>
                        <button type="submit" class="btn-ripple px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">save</span>
                            <span>Update Attendance Log</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleLabel(input, isFocused) {
            const container = input.parentElement;
            if (isFocused) {
                container.classList.add('input-focused');
            } else {
                container.classList.remove('input-focused');
            }
            // Check if input has value
            if (input.value) {
                container.classList.add('input-filled');
            } else {
                container.classList.remove('input-filled');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Pre-fill labels for inputs that have a value on page load
            document.querySelectorAll('.material-input').forEach(input => {
                // For select, we don't need floating label. For others, check value.
                if (input.tagName.toLowerCase() !== 'select' && input.value) {
                    input.parentElement.classList.add('input-filled');
                }
            });
        });
    </script>
@endsection
