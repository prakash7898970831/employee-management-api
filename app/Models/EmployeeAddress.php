<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    protected $fillable = [
        'employee_id',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
