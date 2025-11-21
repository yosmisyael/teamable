<?php

use App\Models\PayrollSchedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Payroll;
use App\Services\PayrollService;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $currentMonth = now()->format('Y-m');
    $service = app(PayrollService::class);

    $paidEmployeeIds = Payroll::query()->where('period_month', $currentMonth)
        ->pluck('employee_id');

    $targets = Employee::query()->with('salary')->where('status', 'active')
        ->whereNotIn('id', $paidEmployeeIds)
        ->get();

    if ($targets->isNotEmpty()) {
        $count = $targets->count();
        Log::info("Scheduler Payroll Running for $count employees.");

        foreach ($targets as $employee) {
            try {
                $service->generatePayrollForEmployee($employee);
            } catch (Exception $e) {
                Log::error("Payroll Error ID $employee->id: " . $e->getMessage());
            }
        }
    }

})->everyMinute()->when(function () {
    if (!Schema::hasTable('payroll_schedules')) {
        return false;
    }

    $settings = PayrollSchedule::query()->first();

    if (!$settings || !$settings->is_active) {
        \Illuminate\Support\Facades\Log::info('[Payroll Service] Payrolls automation is inactive');
        return false;
    }

    if (now()->day !== $settings->run_date) {
        return false;
    }

    $scheduledTime = Carbon::parse($settings->run_time)->format('H:i');
    $currentTime = now()->format('H:i');

    return $scheduledTime === $currentTime;
});
