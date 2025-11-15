@extends('master')

@section('title')
    Add Position - Employee Management App
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
                <a href="{{ route('positions.index') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">work</span>
                    <span>Positions</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">Add New Position</span>
            </nav>
        </div>

        <div class="mb-8 fade-in">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="flex items-center mb-8 pb-6 border-b border-gray-200">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 py-3 px-4 rounded-full mr-4 shadow-lg">
                        <span class="material-icons text-white text-xl">work</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Add New Position</h2>
                        <p class="text-sm text-gray-600 mt-1">Define a new job role and its base salary</p>
                    </div>
                </div>

                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <span class="material-icons text-blue-500 text-sm mt-0.5 mr-3">info</span>
                        <div>
                            <p class="text-sm text-blue-900 font-medium">Position Details</p>
                            <p class="text-sm text-blue-700 mt-1">Enter the position name and its base salary. Ensure the name is unique.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('positions.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="input-container relative">
                        <input type="text"
                               id="nama_jabatan"
                               name="nama_jabatan"
                               maxlength="100"
                               class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                               required
                               value="{{ old('nama_jabatan') }}"
                               onfocus="toggleLabel(this, true)"
                               onblur="toggleLabel(this, false)">
                        <label for="nama_jabatan" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                            Position Name
                        </label>
                        <span class="text-xs text-gray-500 mt-2 px-1">e.g., Software Engineer, Marketing Manager</span>
                    </div>

                    <div class="input-container relative">
                        <input type="number"
                               id="gaji_pokok"
                               name="gaji_pokok"
                               step="0.01"
                               min="0"
                               class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                               required
                               value="{{ old('gaji_pokok') }}"
                               onfocus="toggleLabel(this, true)"
                               onblur="toggleLabel(this, false)">
                        <label for="gaji_pokok" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                            Base Salary (Rp)
                        </label>
                        <span class="text-xs text-gray-500 mt-2 px-1">e.g., 8000000.00</span>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('positions.index') }}"
                           class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">close</span>
                            <span>Cancel</span>
                        </a>
                        <button type="submit"
                                class="btn-ripple px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">add</span>
                            <span>Create Position</span>
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
            });
        });
    </script>
@endsection
