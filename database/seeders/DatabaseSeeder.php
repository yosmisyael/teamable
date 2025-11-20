<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use App\Models\Position;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        $positionLevels = ['Intern', 'Junior', 'Senior'];

        $departments = [];
        $allEmployees = collect();

        foreach ($departmentNames as $deptName) {
            $departments[] = Department::factory()->create(['name' => $deptName]);
        }

        foreach ($departments as $department) {
            $jobs = [];

            Job::factory(3)->create([
                'department_id' => $department->id,
            ])->each(function (Job $jobProfile) use ($department, $positionLevels, &$allEmployees) {

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
        echo " - " . Job::count() . " Job Profiles created (5 departments * 3 jobs = 15).\n";
        echo " - " . Position::count() . " Positions created (15 jobs * 3 levels = 45).\n";
        echo " - " . Employee::count() . " Employees created (45 positions * 1 employee = 45).\n";
    }
}
