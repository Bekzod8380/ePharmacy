<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\TypeMedicine;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MainController extends Controller
{
    public function dashboard(){
        return view('main.dashboard');
    }
    public function patients()
    {
        return view('main.patients');
    }
    public function doctors(){
        $doctors = Role::where('name', 'doctor')->first()->users;
        return view('main.doctors', compact('doctors'));
    }
    public function pharmacists(){
        $medicines = Medicine::all();
        $pharmacists = Role::where('name', 'pharmacist')->first()->users;
        return view('main.pharmacists', compact('pharmacists', 'medicines'));
    }
    public function medicines(){
        $medicines = Medicine::all();
        $type_md = TypeMedicine::all();
        return view('main.medicines', compact('medicines', 'type_md'));
    }
}
