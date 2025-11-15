@extends('components.layouts.admin')

@section('style')
<style>
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-thumb {
        background: #93D5F1;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #27AAE2;
    }
</style>
@endsection

@section('main')
<!-- Top Navigation -->
<header class="h-20 bg-white shadow-md flex items-center justify-between px-6 flex-shrink-0 mx-6 mt-2 rounded-lg">
    <div class="flex items-center">
        <!-- Mobile Menu Button (hidden on md+) -->
        <button class="md:hidden mr-4 text-gray-600">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <h1 class="text-2xl font-bold text-primary">Dashboard Overview</h1>
    </div>

    <div class="flex items-center space-x-5">
        <!-- Search Bar -->
        <div class="relative hidden sm:block">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" class="bg-gray-100 rounded-full py-2 pl-10 pr-4 w-64 focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white" placeholder="Search...">
        </div>

        <!-- Notifications -->
        <div class="relative">
            <button class="text-gray-500 hover:text-primary">
                <!-- Heroicon: bell -->
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2.25c-2.42 0-4.64.93-6.27 2.47a.75.75 0 001.06 1.06A7.5 7.5 0 0112 4.5a7.5 7.5 0 016.21 3.28.75.75 0 101.06-1.06A8.98 8.98 0 0012 2.25zM12 18.75a.75.75 0 00.75-.75V15.75a.75.75 0 00-1.5 0v2.25a.75.75 0 00.75.75zM12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5zM5.1 12.3a.75.75 0 10-1.06-1.06A8.98 8.98 0 002.25 12c0 2.42.93 4.64 2.47 6.27a.75.75 0 101.06-1.06A7.5 7.5 0 014.5 12a7.5 7.5 0 01.6-3.7zM18.9 12.3a.75.75 0 101.06-1.06A8.98 8.98 0 0021.75 12c0 2.42-.93 4.64-2.47 6.27a.75.75 0 10-1.06-1.06A7.5 7.5 0 0119.5 12a7.5 7.5 0 01-.6-3.7z" clip-rule="evenodd" />
                </svg>
            </button>
            <span class="absolute top-0 right-0 -mt-1 -mr-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button class="flex items-center space-x-2">
                <img class="w-10 h-10 rounded-full" src="https://placehold.co/40x40/93D5F1/176688?text=J" alt="John Admin">
                <span class="hidden md:block font-medium text-gray-700">John Admin</span>
                <!-- Heroicon: chevron-down -->
                <svg class="w-5 h-5 text-gray-500 hidden md:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                </svg>
            </button>
            <!-- Dropdown Menu (hidden by default) -->
            <!--
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <a href="login.html" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Log Out</a>
            </div>
            -->
        </div>
    </div>
</header>

<!-- Dashboard Content -->
<main class="flex-1 overflow-y-auto p-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1: Total Employees -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Employees</p>
                <span class="text-4xl font-bold text-primary">247</span>
                <p class="text-sm text-green-500 font-medium">+12 this month</p>
            </div>
            <div class="w-14 h-14 bg-tertiary rounded-full flex items-center justify-center">
                <!-- Heroicon: users -->
                <svg class="w-8 h-8 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM1.5 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75H4.5a3 3 0 01-3-3zM11.25 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75h-1.5a3 3 0 01-3-3zM21 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75h-1.5a3 3 0 01-3-3z" />
                </svg>
            </div>
        </div>
        <!-- Card 2: Active Recruitments -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Active Recruitments</p>
                <span class="text-4xl font-bold text-primary">18</span>
                <p class="text-sm text-secondary font-medium">9 new positions</p>
            </div>
            <div class="w-14 h-14 bg-tertiary rounded-full flex items-center justify-center">
                <!-- Heroicon: user-plus -->
                <svg class="w-8 h-8 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a.75.75 0 001.5 0v-2.25a.75.75 0 00-1.5 0v2.25z" />
                    <path fill-rule="evenodd" d="M1.5 13.5A.75.75 0 012.25 12h19.5a.75.75 0 01.75.75v6a.75.75 0 01-.75.75H2.25a.75.75 0 01-.75-.75v-6zM3 13.5v6h1.5a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-2.25H2.25a.75.75 0 01-.75-.75zM21 13.5v6h-1.5a.75.75 0 00-.75.75v3a.75.75 0 001.5 0v-2.25H21.75a.75.75 0 00.75-.75z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <!-- Card 3: Today's Attendance -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Today's Attendance</p>
                <span class="text-4xl font-bold text-green-600">92%</span>
                <p class="text-sm text-gray-500 font-medium">227 present, 20 absent</p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <!-- Heroicon: check-badge -->
                <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.603 3.799A4.5 4.5 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.5 4.5 0 013.498 1.307 4.5 4.5 0 011.307 3.498A4.5 4.5 0 0121.75 12c0 1.357-.6 2.573-1.549 3.397a4.5 4.5 0 01-1.307 3.498 4.5 4.5 0 01-3.498 1.307A4.5 4.5 0 0112 21.75c-1.357 0-2.573-.6-3.397-1.549a4.5 4.5 0 01-3.498-1.307 4.5 4.5 0 01-1.307-3.498A4.5 4.5 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.5 4.5 0 011.307-3.498 4.5 4.5 0 013.498-1.307zm3.397 14.03a.75.75 0 001.06-1.06l-4.03-4.03a.75.75 0 00-1.06 1.06l4.03 4.03z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <!-- Card 4: Pending Approvals -->
        <div class="bg-white p-6 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Pending Approvals</p>
                <span class="text-4xl font-bold text-orange-500">14</span>
                <p class="text-sm text-gray-500 font-medium">7 leave requests</p>
            </div>
            <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                <!-- Heroicon: exclamation-triangle -->
                <svg class="w-8 h-8 text-orange-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.556 13.004c1.155 2-.29 4.5-2.598 4.5H4.443c-2.308 0-3.753-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
        <!-- Employee Growth Chart -->
        <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Employee Growth</h3>
{{--                    <canvas id="employeeGrowthChart"></canvas>--}}
        </div>
        <!-- Department Distribution Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Department Distribution</h3>
{{--                    <canvas id="departmentDistributionChart"></canvas>--}}
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Recent Activities</h3>
            <ul class="space-y-4">
                <!-- Activity Item 1 -->
                <li class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.484 3.494c.091-.091.2-.168.316-.221a4.48 4.48 0 011.83.221c.115.053.224.13.315.221l6.75 6.75a.75.75 0 010 1.06l-6.75 6.75c-.091.091-.2.168-.316.221a4.48 4.48 0 01-1.83.221c-.115-.053-.224-.13-.315-.221l-6.75-6.75a.75.75 0 010-1.06l6.75-6.75zm-6.178 6.91a.75.75 0 000 1.06l6.75 6.75c.091.091.2.168.316.221a4.48 4.48 0 001.83.221c.115-.053.224-.13.315-.221l6.75-6.75a.75.75 0 000-1.06l-6.75-6.75c-.091-.091-.2-.168-.316-.221a4.48 4.48 0 00-1.83-.221c-.115.053-.224.13-.315.221l-6.75 6.75z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">New employee onboarded</h4>
                        <p class="text-sm text-gray-500">Sarah Johnson joined Marketing Department</p>
                        <p class="text-xs text-gray-400">2 hours ago</p>
                    </div>
                </li>
                <!-- Activity Item 2 -->
                <li class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.036.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a.375.375 0 01-.375-.375V6.75A3.75 3.75 0 009 3H5.625zM10.5 17.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10.5 12a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10.5 6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM15 17.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM15 12a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Leave request approved</h4>
                        <p class="text-sm text-gray-500">Michael Chen's vacation leave approved</p>
                        <p class="text-xs text-gray-400">4 hours ago</p>
                    </div>
                </li>
                <!-- Activity Item 3 -->
                <li class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M15.75 2.25a.75.75 0 01.75.75v5.25h.75a.75.75 0 010 1.5h-.75V15a.75.75 0 01-1.5 0v-5.25H14.25a.75.75 0 010-1.5h.75V3a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                            <path d="M3 3.75A.75.75 0 013.75 3h6a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75h-6a.75.75 0 01-.75-.75V3.75z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">New job posting created</h4>
                        <p class="text-sm text-gray-500">Senior Developer position posted</p>
                        <p class="text-xs text-gray-400">6 hours ago</p>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-primary mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-secondary text-white rounded-lg flex items-center justify-center mb-2">
                        <!-- Heroicon: user-plus -->
                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.125 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75h-1.5a3 3 0 01-3-3zM16.125 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75h-1.5a3 3 0 01-3-3zM10.875 15.375a3 3 0 013-3h1.5a.75.75 0 01.75.75V18a.75.75 0 01-.75.75h-1.5a3 3 0 01-3-3z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-primary">Add Employee</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-secondary text-white rounded-lg flex items-center justify-center mb-2">
                        <!-- Heroicon: briefcase -->
                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10.5 1.5H13.5V4.5H10.5V1.5Z" />
                            <path fill-rule="evenodd" d="M3.75 6H20.25C20.6642 6 21 6.33579 21 6.75V20.25C21 20.6642 20.6642 21 20.25 21H3.75C3.33579 21 3 20.6642 3 20.25V6.75C3 6.33579 3.33579 6 3.75 6ZM6 9V18H18V9H6Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-primary">Post Job</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-secondary text-white rounded-lg flex items-center justify-center mb-2">
                        <!-- Heroicon: document-text -->
                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.036.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a.375.375 0 01-.375-.375V6.75A3.75 3.75 0 009 3H5.625zM10.5 17.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10.5 12a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5zM10.5 6.75a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-primary">Generate Report</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-tertiary/30 rounded-lg text-center">
                    <div class="w-12 h-12 bg-secondary text-white rounded-lg flex items-center justify-center mb-2">
                        <!-- Heroicon: cog-6-tooth -->
                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.999 10.5c.276.001.55.023.822.066l1.45 1.45a.75.75 0 001.06-1.06l-1.45-1.45A8.932 8.932 0 0015 9a.75.75 0 00-1.5 0 7.432 7.432 0 01-1.42 4.57l-1.53 1.53a.75.75 0 001.06 1.06l1.53-1.53c.31-.31.593-.647.85-1.011a8.9 8.9 0 002.012 3.885.75.75 0 101.218-.862 7.4 7.4 0 01-1.66 2.023.75.75 0 00.9 1.198 8.903 8.903 0 002.355-2.82.75.75 0 00-1.218-.862 7.4 7.4 0 01-2.023 1.66.75.75 0 00-1.198-.9A8.903 8.903 0 0018 15a.75.75 0 000-1.5 7.432 7.432 0 01-4.57-1.42l-1.53-1.53a.75.75 0 00-1.06-1.06l1.53-1.53c.364-.364.699-.757 1.01-1.176a8.9 8.9 0 00-3.885-2.012.75.75 0 00.862-1.218 7.4 7.4 0 01-2.023 1.66.75.75 0 00-.9-1.198 8.903 8.903 0 002.82-2.355.75.75 0 00.862 1.218 7.4 7.4 0 01-1.66-2.023.75.75 0 001.198.9 8.903 8.903 0 001.5 2.502zM11.999 12a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            <path fill-rule="evenodd" d="M12 21a9 9 0 100-18 9 9 0 000 18zM10.94 3.112a.75.75 0 010 1.056 7.452 7.452 0 00-2.32 1.342.75.75 0 11-.97-1.159 8.947 8.947 0 012.77-1.611.75.75 0 01.52-.377zM4.168 8.622a.75.75 0 011.056 0 7.452 7.452 0 001.342 2.32.75.75 0 11-1.159.97 8.947 8.947 0 01-1.611-2.77.75.75 0 01.373-.52zm15.664 0a.75.75 0 01.52.373 8.947 8.947 0 01-1.611 2.77.75.75 0 11-1.159-.97 7.452 7.452 0 001.342-2.32.75.75 0 01.52-.373zM13.06 19.888a.75.75 0 010-1.056 7.452 7.452 0 002.32-1.342.75.75 0 11.97 1.159 8.947 8.947 0 01-2.77 1.611.75.75 0 01-.52.377zM19.832 15.378a.75.75 0 01-1.056 0 7.452 7.452 0 00-1.342-2.32.75.75 0 111.159-.97 8.947 8.947 0 011.611 2.77.75.75 0 01-.373.52zm-15.664 0a.75.75 0 01-.373-.52 8.947 8.947 0 011.611-2.77.75.75 0 11-1.159.97 7.452 7.452 0 00-1.342 2.32.75.75 0 01.26.857zM10.94 20.888a.75.75 0 01-.52-.377 8.947 8.947 0 01-2.77-1.611.75.75 0 11.97-1.159 7.452 7.452 0 002.32 1.342.75.75 0 01.0 1.056zM4.168 15.378a.75.75 0 01-.52-.373 8.947 8.947 0 011.611-2.77.75.75 0 111.159.97 7.452 7.452 0 00-1.342 2.32.75.75 0 01-1.056 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-primary">Settings</span>
                </a>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const growthCtx = document.getElementById('employeeGrowthChart').getContext('2d');
    const employeeGrowthChart = new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Employees',
                data: [200, 205, 215, 225, 240, 250],
                backgroundColor: 'rgba(23, 102, 136, 0.1)',
                borderColor: '#176688',
                borderWidth: 3,
                pointBackgroundColor: '#176688',
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    min: 50,
                    max: 250,
                    ticks: {
                        stepSize: 50
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    const distributionCtx = document.getElementById('departmentDistributionChart').getContext('2d');
    const departmentDistributionChart = new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Engineering', 'Finance', 'Marketing', 'HR', 'Sales'],
            datasets: [{
                label: 'Department Distribution',
                data: [34.4, 19, 17.11, 7.29, 22.2],
                backgroundColor: [
                    '#176688',
                    '#f59e0b',
                    '#27AAE2',
                    '#10b981',
                    '#6b7280'
                ],
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 20,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + '%';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
