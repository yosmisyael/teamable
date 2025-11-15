@extends('master')

@section('title')
    Add Department - Employee Management App
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
    <!-- Form -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6 fade-in">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ url('/department') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">apartment</span>
                    <span>Departments</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">Add New Department</span>
            </nav>
        </div>

        <div class="mb-8 fade-in">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <!-- Header -->
                <div class="flex items-center mb-8 pb-6 border-b border-gray-200">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 py-3 px-4 rounded-full mr-4 shadow-lg">
                        <span class="material-icons text-white text-xl">add_business</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Add New Department</h2>
                        <p class="text-sm text-gray-600 mt-1">Create a new department for your organization</p>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex items-start">
                        <span class="material-icons text-blue-500 text-sm mt-0.5 mr-3">info</span>
                        <div>
                            <p class="text-sm text-blue-900 font-medium">Department Information</p>
                            <p class="text-sm text-blue-700 mt-1">Enter the department name below. Make sure it's unique and descriptive.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Department Name -->
                    <div class="input-container relative">
                        <input type="text"
                               id="nama_departemen"
                               name="nama_departemen"
                               maxlength="100"
                               class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-all duration-300 peer"
                               required
                               onfocus="toggleLabel(this, true)"
                               onblur="toggleLabel(this, false)"
                               oninput="updateCharCount(this)">
                        <label for="nama_departemen" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                            Department Name
                        </label>
                        <div class="flex items-center justify-between mt-2 px-1">
                            <span class="text-xs text-gray-500">e.g., Human Resources, Information Technology</span>
                            <span id="charCount" class="text-xs text-gray-400">0 / 100</span>
                        </div>
                    </div>

                    <!-- Additional Info Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <span class="material-icons text-gray-600 text-sm mr-2">lightbulb</span>
                            <h3 class="text-sm font-semibold text-gray-900">Tips for Department Names</h3>
                        </div>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <span class="material-icons text-blue-500 text-xs mr-2 mt-0.5">check_circle</span>
                                <span>Use clear and professional names</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons text-blue-500 text-xs mr-2 mt-0.5">check_circle</span>
                                <span>Avoid special characters or numbers unless necessary</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons text-blue-500 text-xs mr-2 mt-0.5">check_circle</span>
                                <span>Keep it concise but descriptive (maximum 100 characters)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="material-icons text-blue-500 text-xs mr-2 mt-0.5">check_circle</span>
                                <span>Ensure the name is unique within your organization</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ url('/department') }}"
                           class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">close</span>
                            <span>Cancel</span>
                        </a>
                        <button type="submit"
                                class="btn-ripple px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">add</span>
                            <span>Create Department</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-2xl card-shadow p-6 fade-in">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <span class="material-icons text-blue-500 text-sm mr-2">flash_on</span>
                Quick Actions
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ url('/department') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                        <span class="material-icons text-blue-600 text-sm">list</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">View All Departments</p>
                        <p class="text-xs text-gray-500">See complete list</p>
                    </div>
                </a>
                <a href="{{ url('/employees') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group">
                    <div class="bg-green-100 p-2 rounded-lg mr-3 group-hover:bg-green-200 transition-colors duration-200">
                        <span class="material-icons text-green-600 text-sm">people</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Manage Employees</p>
                        <p class="text-xs text-gray-500">View all employees</p>
                    </div>
                </a>
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

            // Check for content to apply 'filled' class
            if (input.value) {
                container.classList.add('input-filled');
            } else {
                container.classList.remove('input-filled');
            }
        }

        function updateCharCount(input) {
            const charCount = document.getElementById('charCount');
            const currentLength = input.value.length;
            const maxLength = input.getAttribute('maxlength');
            charCount.textContent = `${currentLength} / ${maxLength}`;

            // Change color based on character count
            if (currentLength > maxLength * 0.9) {
                charCount.classList.add('text-red-500');
                charCount.classList.remove('text-gray-400');
            } else if (currentLength > maxLength * 0.7) {
                charCount.classList.add('text-yellow-500');
                charCount.classList.remove('text-gray-400', 'text-red-500');
            } else {
                charCount.classList.add('text-gray-400');
                charCount.classList.remove('text-yellow-500', 'text-red-500');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.material-input');
            inputs.forEach(input => {
                if (input.value) {
                    input.parentElement.classList.add('input-filled');
                }

                // For select elements, check selectedIndex
                if (input.tagName === 'SELECT' && input.selectedIndex > 0) {
                    input.parentElement.classList.add('input-filled');
                }
            });

            // Initialize character count
            const deptNameInput = document.getElementById('nama_department');
            if (deptNameInput) {
                updateCharCount(deptNameInput);
            }
        });
    </script>
@endsection
