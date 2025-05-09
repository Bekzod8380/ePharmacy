<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'FISH',
        'passport',
        'date_of_birth',
        'gender',
        'address',
        'phone',
    ];
}
