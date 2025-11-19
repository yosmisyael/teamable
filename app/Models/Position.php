<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'name',
        'status',
        'department_id',
        'job_id',
    ];

    public function employees(): HasMany {
        return $this->hasMany(Employee::class, 'position_id');
    }
}
