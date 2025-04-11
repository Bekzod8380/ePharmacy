<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicinePharmacie extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'medicine_id',
        'pharmacist_id',
        'quantity',
    ];
}
