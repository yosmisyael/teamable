<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    public function salary(): HasMany {
        return $this->hasMany(Salary::class, 'bank_id', 'id');
    }
}
