<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_profiles';

    protected $fillable = [
        'department_id',
        'name',
        'min_salary',
        'max_salary',
    ];

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'job_id', 'id');
    }
}
