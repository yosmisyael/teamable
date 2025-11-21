<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">work</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Job Profiles</p>
                <span class="text-2xl font-bold text-primary">{{ $totalJobs }}</span>
            </div>
            <span class="text-sm font-medium text-green-500">+4%</span>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">payments</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Avg Base Salary</p>
                {{-- Assuming a currency helper exists, or standard formatting --}}
                <span
                    class="text-2xl font-bold text-primary">Rp{{ number_format($avgMinSalary, decimal_separator: ',', thousands_separator: '.') }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">trending_up</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Avg Max Cap</p>
                <span
                    class="text-2xl font-bold text-primary">Rp{{ number_format($avgMaxSalary, decimal_separator: ',', thousands_separator: '.') }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">assignment_ind</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Active Allocations</p>
                <span class="text-2xl font-bold text-primary">--</span>
            </div>
            <span class="text-sm font-medium text-gray-400">N/A</span>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <input type="text"
                       class="bg-gray-100 rounded-md py-2.5 pl-10 pr-4 w-full focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white"
                       placeholder="Search jobs by title, department...">
            </div>
            <div class="flex items-center space-x-2">
                <button
                    class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <span class="material-icons text-gray-400 text-sm mr-2">filter_list</span>
                    Filters
                </button>
                <button
                    class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <span class="material-icons text-gray-400 text-sm mr-2">download</span>
                    Export
                </button>
                {{-- Corrected method name to match Component (toggleForm) --}}
                <button
                    wire:click="toggleForm"
                    class="button-primary">
                        <span class="material-icons">
                            add
                        </span>
                    Add New Job
                </button>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-gray-500">Quick filters:</span>
            <a href="#" class="px-3 py-1 rounded-full text-sm font-medium bg-tertiary text-primary">All
                Jobs</a>
            <a href="#" class="px-3 py-1 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100">High
                Salary</a>
            <a href="#" class="px-3 py-1 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100">Tech Dept</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 w-12"><input type="checkbox"
                                                class="h-4 w-4 text-secondary rounded border-gray-300 focus:ring-secondary">
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Job Title
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Department
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Salary Range
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Created Date
                    </th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($jobs as $job)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4">
                            <input type="checkbox"
                                   class="h-4 w-4 text-secondary rounded border-gray-300 focus:ring-secondary">
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $job->name }}</div>
                                    <div class="text-xs text-gray-500">ID: #{{ $job->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span class="material-icons text-gray-400 text-sm">domain</span>
                                <span
                                    class="text-sm text-gray-700">{{ $job->department ? $job->department->name : 'Unassigned' }}</span>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                Rp{{ number_format($job->min_salary, decimal_separator: ',', thousands_separator: '.') }}
                                -
                                Rp{{ number_format($job->max_salary, decimal_separator: ',', thousands_separator: '.') }}
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            @php
                                $date = Carbon\Carbon::parse($job->created_at)
                            @endphp
                            <div class="text-sm text-gray-900">{{ $date->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $date->diffForHumans() }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                {{--  action view  --}}
                                <button class="text-gray-400 hover:text-primary cursor-pointer">
                                    <span class="material-icons">visibility</span>
                                </button>
                                {{--  action edit  --}}
                                <button wire:click="editJob({{ $job->id }})" class="text-gray-400 hover:text-primary cursor-pointer">
                                    <span class="material-icons">edit_square</span>
                                </button>
                                {{--  action delete  --}}
                                <button wire:click="toggleDeleteModal({{ $job->id }})"
                                        class="text-gray-400 hover:text-red-500 cursor-pointer">
                                    <span class="material-icons">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $jobs->links('components.pagination') }}
    </div>

    {{--  Add/Edit Job Form  --}}
    <section
        class="h-screen w-1/3 {{ $isFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-10 bg-surface-high rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="form-title">
                {{ $jobToEditId ? 'Edit Job: ' . $this->name : 'Add New Job' }}
            </h2>
            <button wire:click="toggleForm" class="text-gray-500 hover:text-red-500 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>
        <form wire:submit.prevent="saveJob" class="flex flex-col gap-4 p-6">
            {{-- Job Name --}}
            <div class="input-group">
                <label for="name" class="input-label">Job Title</label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <span class="material-icons text-xl text-primary input-icon">work_outline</span>
                    <input id="name" wire:model.live="name" type="text" class="input-field"
                           placeholder="e.g. Senior Engineer">
                </div>
                @error('name')
                <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                @enderror
            </div>

            {{-- Department Select --}}
            <div class="input-group">
                <label for="department_id" class="input-label">Department</label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <span class="material-icons text-xl text-primary input-icon">domain</span>
                    <select wire:model="department_id" id="department_id" class="input-select">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('department_id')
                <p class="mt-2.5 text-sm text-red-500"><span class="font-medium">Error:</span> {{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- Min Salary --}}
                <div class="input-group">
                    <label for="min_salary" class="input-label">Min Salary</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">money</span>
                        <input id="min_salary" wire:model="min_salary" type="number" class="input-field"
                               placeholder="0">
                    </div>
                    @error('min_salary')
                    <p class="mt-2.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Max Salary --}}
                <div class="input-group">
                    <label for="max_salary" class="input-label">Max Salary</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <span class="material-icons text-xl text-primary input-icon">money</span>
                        <input id="max_salary" wire:model="max_salary" type="number" class="input-field"
                               placeholder="0">
                    </div>
                    @error('max_salary')
                    <p class="mt-2.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 justify-end mt-5">
                <button wire:click="toggleForm" type="button" class="button-secondary w-fit">
                    Cancel
                </button>
                <button type="submit" class="button-primary w-fit">
                    {{ $jobToEditId ? 'Save Changes' : 'Add Job' }}
                </button>
            </div>
        </form>
    </section>

    {{--  Delete Job Modal  --}}
    @if($isDeleteModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center">
            <div class="bg-surface-high p-4 w-fit rounded-lg shadow-xl">
                <form wire:submit.prevent="deleteJob" class="flex flex-col gap-4">
                    <h3 class="form-title text-red-600">Delete Confirmation</h3>
                    <p class="text-primary">Are you sure you want to remove this Job Profile?</p>
                    <p class="text-xs text-gray-500">This might affect employees currently assigned to this title.</p>
                    <div class="flex gap-3 justify-end">
                        <button wire:click="toggleDeleteModal" type="button" class="button-secondary">
                            Cancel
                        </button>
                        <button
                            class="button-danger shadow-md border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded"
                            type="submit">
                            Remove
                        </button>
                    </div>
                </form>
            </div>
        </section>
    @endif
</main>
