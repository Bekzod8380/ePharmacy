<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'medicine_id',
        'pharmacist_id',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
