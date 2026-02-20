<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'first_name',
        'last_name',
        'designation',
        'email',
        'date_of_birth',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function contacts()
    {
        return $this->hasMany(EmployeeContact::class);
    }

    public function addresses()
    {
        return $this->hasMany(EmployeeAddress::class);
    }
}
