<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollSchedule extends Model
{
    protected $fillable = [
        'is_active',
        'run_date',
        'run_time'
    ];
}
