<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Bank;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use App\Models\Position;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Salary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE employees RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE positions RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE job_profiles RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE departments RESTART IDENTITY CASCADE');

        // setup admin account
        Admin::query()->create([
            'name' => 'Jose Michael',
            'email' => 'jose@gmail.com',
            'password' => bcrypt('test1234'),
        ]);

        $departmentNames = [
            'Cloud Infrastructure',
            'Financial Planning',
            'Global Marketing',
            'Core Product Development',
            'Legal & Compliance'
        ];

        // setup authorized banks
        $bankNames = ['BCA', 'Mandiri', 'BNI', 'BRI', 'CIMB Niaga', 'Danamon', 'Jago', 'BSI'];
        $banks = collect();
        foreach ($bankNames as $name) {
            $banks->push(Bank::query()->create([
                'name' => $name,
                'status' => 'available',
            ]));
        }

        $positionLevels = ['Intern', 'Junior', 'Senior'];

        $departments = [];
        $allEmployees = collect();

        foreach ($departmentNames as $deptName) {
            $departments[] = Department::factory()->create(['name' => $deptName]);
        }

        foreach ($departments as $department) {
            Job::factory(3)->create([
                'department_id' => $department->id,
            ])->each(function (Job $jobProfile) use ($banks, $department, $positionLevels, &$allEmployees) {
                foreach ($positionLevels as $level) {
                    $position = Position::factory()->available()->create([
                        'name' => $level . ' ' . $jobProfile->name,
                        'department_id' => $department->id,
                        'job_id' => $jobProfile->id,
                        'status' => 'unavailable',
                    ]);
                    $employee = Employee::factory()->create([
                        'department_id' => $department->id,
                        'job_id' => $jobProfile->id,
                        'position_id' => $position->id,
                        'status' => 'active',
                    ]);
                    $allEmployees->push($employee);

                    $baseSalary = match ($level) {
                        'Intern' => rand(3_000_000, 4_500_000),
                        'Junior' => rand(6_000_000, 10_000_000),
                        'Senior' => rand(12_000_000, 25_000_000),
                        default => 5_000_000
                    };

                    Salary::query()->create([
                        'employee_id' => $employee->id,
                        'bank_id' => $banks->random()->id,
                        'bank_account' => (string) rand(1000000000, 9999999999),
                        'base_salary' => $baseSalary,
                        'allowance' => rand(500_000, 2_000_000),
                        'cut' => rand(50_000, 300_000),
                    ]);
                }
            });
        }

        foreach ($departments as $department) {
            $manager = $allEmployees
                ->where('department_id', $department->id)
                ->random();

            $department->update(['manager_id' => $manager->id]);
        }

        echo "Database seeded successfully:\n";
        echo " - " . count($departments) . " Departments created.\n";
        echo " - " . Bank::query()->count() . " Bank records created.\n";
        echo " - " . Job::query()->count() . " Job Profiles created (5 departments * 3 jobs = 15).\n";
        echo " - " . Position::query()->count() . " Positions created (15 jobs * 3 levels = 45).\n";
        echo " - " . Salary::query()->count() . " Salary records created.\n";
        echo " - " . Employee::query()->count() . " Employees created (45 positions * 1 employee = 45).\n";
    }
}
