<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function contactNumbers()
    {
        return $this->hasMany(ContactNumber::class);
    }

}
