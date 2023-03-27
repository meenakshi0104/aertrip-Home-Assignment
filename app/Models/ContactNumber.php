<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'number'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
