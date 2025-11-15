@extends('master')

@section('title')
    Edit Salary Slip - Employee Management App
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
        .material-input:disabled {
            background-color: #f3f4f6; /* gray-100 */
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 fade-in">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('salaries.index') }}" class="hover:text-blue-600 transition-colors duration-200 flex items-center space-x-1">
                    <span class="material-icons text-sm">payments</span>
                    <span>Salaries</span>
                </a>
                <span class="material-icons text-sm">chevron_right</span>
                <span class="text-gray-900 font-medium">Edit Salary Slip</span>
            </nav>
        </div>

        <div class="mb-8 fade-in">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="flex items-center mb-8 pb-6 border-b border-gray-200">
                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 py-3 px-4 rounded-full mr-4 shadow-lg">
                        <span class="material-icons text-white text-xl">edit_document</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Edit Salary Slip</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Updating record for <span class="font-semibold">{{ $salary->employee->nama_lengkap }}</span> - <span class="font-semibold">{{ $salary->bulan }}</span>
                        </p>
                    </div>
                </div>

                <form action="{{ route('salaries.update', $salary->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="input-container relative">
                            <input type="text" id="karyawan_id" name="karyawan_id"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg peer"
                                   value="{{ $salary->employee->nama_lengkap }}" disabled>
                            <label for="karyawan_id" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Employee
                            </label>
                        </div>
                        <div class="input-container relative">
                            <input type="month" id="bulan" name="bulan"
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg peer"
                                   value="{{ \Carbon\Carbon::parse($salary->bulan)->format('Y-m') }}" disabled>
                            <label for="bulan" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">
                                Salary Period
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="input-container relative">
                            <input type="number" id="gaji_pokok" name="gaji_pokok" step="0.01" min="0" required value="{{ old('gaji_pokok', $salary->gaji_pokok) }}"
                                   class="salary-component material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                   onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                            <label for="gaji_pokok" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Base Salary (Rp)</label>
                        </div>
                        <div class="input-container relative">
                            <input type="number" id="tunjangan" name="tunjangan" step="0.01" min="0" required value="{{ old('tunjangan', $salary->tunjangan) }}"
                                   class="salary-component material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                   onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                            <label for="tunjangan" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Allowance (Rp)</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="input-container relative">
                            <input type="number" id="potongan" name="potongan" step="0.01" min="0" required value="{{ old('potongan', $salary->potongan) }}"
                                   class="salary-component material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none peer"
                                   onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                            <label for="potongan" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Deduction (Rp)</label>
                        </div>
                        <div class="input-container relative">
                            <input type="number" id="total_gaji" name="total_gaji" readonly
                                   class="material-input w-full px-4 pt-4 pb-2 border-2 border-gray-200 rounded-lg bg-gray-100 text-gray-700 font-bold peer"
                                   onfocus="toggleLabel(this, true)" onblur="toggleLabel(this, false)">
                            <label for="total_gaji" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Total Salary (Rp)</label>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('salaries.show', $salary->id) }}"
                           class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">close</span>
                            <span>Cancel</span>
                        </a>
                        <button type="submit"
                                class="btn-ripple px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-2">
                            <span class="material-icons text-sm">save</span>
                            <span>Update Salary Slip</span>
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
            // Add 'input-filled' class if the input has a value
            if (input.value || (input.type === 'month' && input.value !== '')) {
                container.classList.add('input-filled');
            } else {
                container.classList.remove('input-filled');
            }
        }

        function calculateTotalSalary() {
            const base = parseFloat(document.getElementById('gaji_pokok').value) || 0;
            const allowance = parseFloat(document.getElementById('tunjangan').value) || 0;
            const deduction = parseFloat(document.getElementById('potongan').value) || 0;

            const total = base + allowance - deduction;

            const totalInput = document.getElementById('total_gaji');
            totalInput.value = total.toFixed(2);
            toggleLabel(totalInput, false); // Update label state for the total field
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize all labels based on initial values on page load
            document.querySelectorAll('.material-input, .material-select').forEach(input => {
                toggleLabel(input, false);
            });

            // Add event listeners to salary components for real-time calculation
            document.querySelectorAll('.salary-component').forEach(input => {
                input.addEventListener('input', calculateTotalSalary);
            });

            // Perform initial calculation on page load
            calculateTotalSalary();
        });
    </script>
@endsection
