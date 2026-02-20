<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeContact extends Model
{
    protected $fillable = [
        'employee_id',
        'contact_number',
        'type',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
