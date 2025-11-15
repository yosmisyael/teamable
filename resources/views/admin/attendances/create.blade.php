@extends('master')

@section('title')
    Add Attendance Record - Employee Management App
@endsection

@section('style')
    <style>
        .material-input {
            transition: all 0.3s ease;
        }
        .material-input:focus, .material-select:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }
        .floating-label {
            transition: all 0.2s ease-in-out;
        }
        .input-focused .floating-label,
        .input-filled .floating-label {
            transform: translateY(-36px) scale(0.85);
            color: #3b82f6; /* blue-500 */
            padding: 8px 16px;
            background-color: #fff;
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
        /* For hiding/showing time fields smoothly */
        .time-fields-container {
            transition: all 0.3s ease-in-out;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
        }
        .time-fields-container.show {
            max-height: 200px; /* Adjust as needed */
            opacity: 1;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 fade-in">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('attendances.index') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">event_available</span>
                    <span>Attendance</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">Add New Record</span>
            </nav>
        </div>

        <div class="mb-8 fade-in">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="flex items-center mb-8 pb-6 border-b border-gray-200">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 py-3 px-4 rounded-full mr-4 shadow-lg">
                        <span class="material-icons text-white text-xl">playlist_add_check</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Add Attendance Record</h2>
                        <p class="text-sm text-gray-600 mt-1">Log a new attendance entry for an employee</p>
                    </div>
                </div>

                <form action="{{ route('attendances.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="input-container relative">
                            {{-- Assumes $employees is passed from the controller --}}
                            <select name="karyawan_id" id="karyawan_id" required
                                    class="material-input material-select w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                    onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)" onchange="toggleLabel(this, false)">
                                <option value="" disabled selected></option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('karyawan_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="karyawan_id" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Select Employee
                            </label>
                        </div>

                        <div class="input-container relative">
                            <input type="date" id="tanggal" name="tanggal"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                   required value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                                   onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                            <label for="tanggal" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Date
                            </label>
                        </div>
                    </div>

                    <div class="input-container relative">
                        <select name="status_absensi" id="status_absensi" required
                                class="material-input material-select w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)" onchange="toggleTimeFields(this)">
                            <option value="" disabled selected></option>
                            <option value="hadir" {{ old('status_absensi') == 'hadir' ? 'selected' : '' }}>Hadir (Present)</option>
                            <option value="izin" {{ old('status_absensi') == 'izin' ? 'selected' : '' }}>Izin (Permission)</option>
                            <option value="sakit" {{ old('status_absensi') == 'sakit' ? 'selected' : '' }}>Sakit (Sick)</option>
                            <option value="alpha" {{ old('status_absensi') == 'alpha' ? 'selected' : '' }}>Alpha (Absent)</option>
                        </select>
                        <label for="status_absensi" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                            Attendance Status
                        </label>
                    </div>

                    <div id="timeFieldsContainer" class="time-fields-container">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="input-container relative">
                                <input type="time" id="waktu_masuk" name="waktu_masuk"
                                       class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                       value="{{ old('waktu_masuk') }}"
                                       onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                                <label for="waktu_masuk" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                    Clock In Time
                                </label>
                            </div>
                            <div class="input-container relative">
                                <input type="time" id="waktu_keluar" name="waktu_keluar"
                                       class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                       value="{{ old('waktu_keluar') }}"
                                       onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                                <label for="waktu_keluar" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                    Clock Out Time
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('attendances.index') }}"
                           class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">close</span>
                            <span>Cancel</span>
                        </a>
                        <button type="submit"
                                class="btn-ripple px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">save</span>
                            <span>Save Record</span>
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
            if (input.value) {
                container.classList.add('input-filled');
            } else {
                container.classList.remove('input-filled');
            }
        }

        function toggleTimeFields(selectElement) {
            toggleLabel(selectElement, false); // Update select label
            const timeFieldsContainer = document.getElementById('timeFieldsContainer');
            const clockInInput = document.getElementById('waktu_masuk');
            const clockOutInput = document.getElementById('waktu_keluar');

            if (selectElement.value === 'hadir') {
                timeFieldsContainer.classList.add('show');
                clockInInput.required = true;
            } else {
                timeFieldsContainer.classList.remove('show');
                clockInInput.required = false;
                // Optional: Clear values when hiding
                clockInInput.value = '';
                clockOutInput.value = '';
                toggleLabel(clockInInput, false);
                toggleLabel(clockOutInput, false);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize all labels based on initial values
            document.querySelectorAll('.material-input, .material-select').forEach(input => {
                toggleLabel(input, false);
            });

            // Initial check for the time fields on page load (for validation errors)
            const statusSelect = document.getElementById('status_absensi');
            if (statusSelect.value) {
                toggleTimeFields(statusSelect);
            }
        });
    </script>
@endsection
