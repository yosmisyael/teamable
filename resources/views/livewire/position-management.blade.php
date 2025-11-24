<main class="flex-1 overflow-y-auto bg-surface-low flex flex-col gap-4">
    {{--  Stats  --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-1">
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">badge</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Positions</p>
                <span class="text-2xl font-bold text-primary">{{ $totalPositions }}</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">person_add_alt</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Vacancies</p>
                <span class="text-2xl font-bold text-primary">{{ $openPositions }}</span>
            </div>
            <span class="text-sm font-medium text-green-500">Active</span>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">rule</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Requirements</p>
                <span class="text-2xl font-bold text-primary">--</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-md flex items-center space-x-4">
            <div class="w-12 h-12 rounded-full bg-tertiary flex items-center justify-center flex-shrink-0">
                <span class="material-icons text-xl text-primary">block</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Unavailable</p>
                <span class="text-2xl font-bold text-primary">{{ $totalPositions - $openPositions }}</span>
            </div>
        </div>
    </div>

    {{--  Filters  --}}
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <input type="text"
                       wire:model.live="search"
                       class="bg-gray-100 rounded-md py-2.5 pl-10 pr-4 w-full focus:outline-none focus:ring-2 focus:ring-secondary focus:bg-white"
                       placeholder="Search positions...">
            </div>
            <div class="flex items-center space-x-2">
                <button wire:click="toggleForm" class="button-primary">
                    <span class="material-icons">add</span>
                    Add Position
                </button>
            </div>
        </div>
    </div>

    {{--  Tables  --}}
    <div class="bg-white rounded-lg shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-surface-high">
                <tr>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Position Name</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Details (Job/Dept)</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Fulfillment</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Status</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-500 tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($positions as $position)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $position->name }}</div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-900 font-medium">{{ $position->job->name }}</span>
                                <span class="text-xs text-gray-500">{{ $position->department->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if(is_null($position->required_talents))
                                    <span
                                        class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium border border-blue-200">
                                        Indefinite ({{ $position->employees_count }} Active)
                                    </span>
                                @else
                                    @php
                                        $isFull = $position->employees_count >= $position->required_talents;
                                        $ratioColor = $isFull ? 'text-red-600' : 'text-green-600';
                                        $bgColor = $isFull ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200';
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded text-xs font-medium border {{ $bgColor }} {{ $ratioColor }}">
                                        {{ $position->employees_count }} / {{ $position->required_talents }} Filled
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="p-4 whitespace-nowrap">
                            <button wire:click="toggleStatus({{ $position->id }})"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $position->status === 'available' ? 'bg-primary' : 'bg-gray-200' }}"
                                    role="switch" aria-checked="{{ $position->status === 'available' }}">
                                <span aria-hidden="true"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $position->status === 'available' ? 'translate-x-5' : 'translate-x-0' }}">
                                </span>
                            </button>
                            <span class="ml-2 text-xs text-gray-500">{{ ucfirst($position->status) }}</span>
                        </td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <button wire:click="editPosition({{ $position->id }})"
                                        class="text-gray-400 hover:text-primary cursor-pointer">
                                    <span class="material-icons">edit_square</span>
                                </button>
                                <button wire:click="toggleDeleteModal({{ $position->id }})"
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
        {{ $positions->links('components.pagination') }}
    </div>

    {{--  Add/Edit Form  --}}
    <section
        class="h-screen w-1/3 {{ $isFormOpen ? 'translate-x-0' : 'translate-x-[100%]' }} transition-all duration-300 ease-out fixed right-0 top-0 z-10 bg-surface-high rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="form-title">{{ $positionToEditId ? 'Edit Position' : 'Create Position' }}</h2>
            <button wire:click="toggleForm" class="text-gray-500 hover:text-red-500 cursor-pointer">
                <span class="material-icons">close</span>
            </button>
        </div>
        <form wire:submit.prevent="savePosition" class="flex flex-col gap-4 p-6">
            <div class="input-group">
                <label class="input-label">Position Name</label>
                <div class="relative mt-1">
                    <span class="material-icons text-xl text-primary input-icon">badge</span>
                    <input wire:model="name" type="text" class="input-field" placeholder="e.g. Senior Backend Dev">
                </div>
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label class="input-label">Department</label>
                <div class="relative mt-1">
                    <span class="material-icons text-xl text-primary input-icon">domain</span>
                    <select wire:model.live="department_id" class="input-select">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('department_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label class="input-label">Job Profile</label>
                <div class="relative mt-1">
                    <span class="material-icons text-xl text-primary input-icon">work</span>
                    <select wire:model="job_id" class="input-select" {{ empty($availableJobs) ? 'disabled' : '' }}>
                        <option value="">Select Job Profile</option>
                        @foreach($availableJobs as $job)
                            <option value="{{ $job->id }}">{{ $job->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if(empty($availableJobs) && $department_id)
                    <span class="text-xs text-gray-400">No jobs found for this department.</span>
                @endif
                @error('job_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label class="input-label">Required Talents (Quota)</label>
                <div class="relative mt-1">
                    <span class="material-icons text-xl text-primary input-icon">groups</span>
                    <input wire:model="required_talents" type="number" min="1" class="input-field"
                           placeholder="Leave empty for Indefinite">
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    If set, system checks if assigned employees exceed this number. Leave blank for unlimited.
                </p>
                @error('required_talents') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <label class="input-label">Available for Assignment?</label>
            <div class="flex gap-4">
                <button type="button"
                        wire:click="$set('status', '{{ $status === 'available' ? 'unavailable' : 'available' }}')"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $status === 'available' ? 'bg-primary' : 'bg-gray-300' }}">
                    <span
                        class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $status === 'available' ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
                <p class="{{ $status === 'available' ? 'text-primary' : 'text-gray-500'}}">{{ $status === 'available' ? 'Available' : 'Unavailable' }}</p>
            </div>

            <div class="flex gap-3 justify-end mt-5">
                <button wire:click="toggleForm" type="button" class="button-secondary w-fit">Cancel</button>
                <button type="submit"
                        class="button-primary w-fit">{{ $positionToEditId ? 'Save Changes' : 'Create Position' }}</button>
            </div>
        </form>
    </section>

    {{--  Delete Modal  --}}
    @if($isDeleteModalOpen)
        <section class="fixed w-full h-screen left-0 top-0 bg-black/10 flex justify-center items-center z-50">
            <div class="bg-surface-high p-6 w-96 rounded-lg shadow-xl">
                <h3 class="form-title">Delete Position?</h3>
                <p class="text-gray-600 text-sm mb-6">Are you sure? This will remove the position definition. Active
                    employees may be detached.</p>
                <div class="flex gap-3 justify-end">
                    <button wire:click="toggleDeleteModal" class="button-secondary">Cancel</button>
                    <button wire:click="deletePosition" class="button-danger border-gray-200 border-2 shadow-md">
                        Delete
                    </button>
                </div>
            </div>
        </section>
    @endif
</main>
