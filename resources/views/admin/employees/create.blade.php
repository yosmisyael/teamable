@extends('master')

@section('title')
    Add New Employee - Employee Management App
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
        .input-focused .floating-label,
        .input-filled .floating-label {
            transform: translateY(-36px) scale(0.85);
            color: #3b82f6;
            padding: 8px 16px;
            background-color: #fff;
        }

        /* controlled field */
        .label-floated-default .floating-label {
            transform: translateY(-26px) scale(0.85);
            color: #6b7280;
            padding: 0 4px;
            background-color: #fff;
        }

        .label-floated-default.input-focused .floating-label {
            color: #3b82f6;
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
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 py-3 px-4 rounded-full mr-4">
                        <span class="material-icons text-blue-600 text-xl">person_add</span>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-800">Add New Employee</h2>
                </div>

                <form action="{{ route('employees.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="input-container relative">
                            <input type="text"
                                   id="nama_lengkap"
                                   name="nama_lengkap"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   value="{{ old('nama_lengkap') }}"
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="nama_lengkap" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Full Name
                            </label>
                        </div>

                        <div class="input-container relative">
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   value="{{ old('email') }}"
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="email" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Email Address
                            </label>
                        </div>

                        <div class="input-container relative">
                            <input type="tel"
                                   id="nomor_telepon"
                                   name="nomor_telepon"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   value="{{ old('nomor_telepon') }}"
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="nomor_telepon" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Phone Number
                            </label>
                        </div>

                        <div class="input-container relative">
                            <input type="date"
                                   id="tanggal_lahir"
                                   name="tanggal_lahir"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   value="{{ old('tanggal_lahir') }}"
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="tanggal_lahir" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Birth Date
                            </label>
                        </div>

                        <div class="input-container relative md:col-span-2">
                                <textarea id="alamat"
                                          name="alamat"
                                          rows="3"
                                          class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer resize-none"
                                          required
                                          onfocus="toggleLabel(this, true)"
                                          onblur="toggleLabel(this, false)">{{ old('alamat') }}</textarea>
                            <label for="alamat" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Address
                            </label>
                        </div>

                        {{-- Department Selection --}}
                        <div class="input-container relative">
                            <select id="departemen_id"
                                    name="departemen_id"
                                    class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                    required
                                    onfocus="toggleLabel(this, true)"
                                    onblur="toggleLabel(this, false)"
                                    onchange="toggleLabel(this, false)">
                                <option value="" disabled selected></option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('departemen_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="departemen_id" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Department
                            </label>
                        </div>

                        {{-- Position Selection --}}
                        <div class="input-container relative">
                            <select id="jabatan_id"
                                    name="jabatan_id"
                                    class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                    required
                                    onfocus="toggleLabel(this, true)"
                                    onblur="toggleLabel(this, false)"
                                    onchange="toggleLabel(this, false)">
                                <option value="" disabled selected></option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('jabatan_id') == $position->id ? 'selected' : '' }}>
                                        {{ $position->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="jabatan_id" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Position
                            </label>
                        </div>

                        <div class="input-container relative">
                            <input type="date"
                                   id="tanggal_masuk"
                                   name="tanggal_masuk"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                   required
                                   value="{{ old('tanggal_masuk') }}"
                                   onfocus="toggleLabel(this, true)"
                                   onblur="toggleLabel(this, false)">
                            <label for="tanggal_masuk" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Start Date
                            </label>
                        </div>

                        <div class="input-container relative">
                            <select id="status"
                                    name="status"
                                    class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                                    required
                                    onfocus="toggleLabel(this, true)"
                                    onblur="toggleLabel(this, false)"
                                    onchange="toggleLabel(this, false)">
                                <option value="" disabled selected></option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Active</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <label for="status" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Employment Status
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('employees.index') }}"
                           class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300">
                            Cancel
                        </a>
                        <button type="submit"
                                class="btn-ripple px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2">
                            <span class="material-icons text-sm">add</span>
                            <span>Add Employee</span>
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
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.material-input').forEach(input => {
                if (input.value) {
                    input.parentElement.classList.add('input-filled');
                }
                // For select elements, check selectedIndex
                if (input.tagName === 'SELECT' && input.selectedIndex > 0) {
                    input.parentElement.classList.add('input-filled');
                }
            });
        });
    </script>
@endsection
