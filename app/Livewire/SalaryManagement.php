<?php

namespace App\Livewire;

use App\Models\Bank;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class SalaryManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $isFormOpen = false;
    public bool $isDeleteModalOpen = false;
    public ?int $salaryToDeleteId = null;
    public ?int $salaryToEditId = null;

    // Form Properties
    public ?int $employee_id = null;
    public ?int $bank_id = null;
    public string $bank_account = '';
    public $base_salary = '';
    public $allowance = 0;
    public $cut = 0;

    // Filter Properties
    public string $searchQuery = '';

    public function toggleForm(): void
    {
        $this->isFormOpen = !$this->isFormOpen;

        if (!$this->isFormOpen) {
            $this->reset(['salaryToEditId', 'employee_id', 'bank_id', 'bank_account', 'base_salary', 'allowance', 'cut']);
        }
    }

    public function toggleDeleteModal(int $id = null): void
    {
        $this->isDeleteModalOpen = !$this->isDeleteModalOpen;
        $this->salaryToDeleteId = $id;
    }

    public function editSalary(int $id): void
    {
        $salary = Salary::query()->findOrFail($id);

        $this->salaryToEditId = $id;
        $this->employee_id = $salary->employee_id;
        $this->bank_id = $salary->bank_id;
        $this->bank_account = $salary->bank_account;
        $this->base_salary = (float) $salary->base_salary;
        $this->allowance = (float) $salary->allowance;
        $this->cut = (float) $salary->cut;

        $this->isFormOpen = true;
    }

    public function saveSalary(): void
    {
        $employeeRule = 'required|exists:employees,id|unique:salaries,employee_id';
        if ($this->salaryToEditId) {
            $employeeRule .= ',' . $this->salaryToEditId;
        }

        $validated = $this->validate([
            'employee_id' => $employeeRule,
            'bank_id' => 'required|exists:banks,id',
            'bank_account' => 'required|string|max:50',
            'base_salary' => 'required|numeric|min:0|max:99999999.99',
            'allowance' => 'nullable|numeric|min:0|max:99999999.99',
            'cut' => 'nullable|numeric|min:0|max:99999999.99',
        ]);

        // Ensure defaults
        $validated['allowance'] = $validated['allowance'] ?? 0;
        $validated['cut'] = $validated['cut'] ?? 0;

        $this->allowance = $this->allowance ?? 0;
        $this->cut = $this->cut ?? 0;

        if ($this->salaryToEditId) {
            Salary::query()->findOrFail($this->salaryToEditId)->update($validated);
            $message = 'Salary details updated successfully!';
        } else {
            Salary::query()->create($validated);
            $message = 'Payroll data defined successfully!';
        }

        $this->toggleForm();
        session()->flash('success', $message);
    }

    public function deleteSalary(): void
    {
        if (!$this->salaryToDeleteId) {
            return;
        }

        Salary::destroy($this->salaryToDeleteId);

        $this->salaryToDeleteId = null;
        $this->toggleDeleteModal();
        session()->flash('success', 'Salary record removed.');
    }

    public function render(): View
    {
        FacadesView::share('pageTitle', 'Salary Management');

        $query = Salary::query()->with(['employee', 'bank']);

        if ($this->searchQuery) {
            $query->whereHas('employee', function ($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%');
            })->orWhere('bank_account', 'like', '%' . $this->searchQuery . '%');
        }

        // Calculations for Stats
        $allSalaries = Salary::all();
        $totalPayroll = $allSalaries->sum(fn($s) => ($s->base_salary + $s->allowance));
        $avgSalary = $allSalaries->count() > 0 ? $allSalaries->avg('base_salary') : 0;

        return view('livewire.salary-management', [
            'salaries' => $query->with(['employee', 'bank'])->latest()->paginate(10),
            'employees' => Employee::query()->orderBy('name')->get(['id', 'name']),
            'banks' => Bank::query()->where('status', 'available')->orderBy('name')->get(['id', 'name']),
            'totalPayroll' => $totalPayroll,
            'avgSalary' => $avgSalary,
            'totalRecords' => $allSalaries->count(),
        ]);
    }
}
