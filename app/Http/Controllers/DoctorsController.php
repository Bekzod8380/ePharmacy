<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Pharmacy;
use App\Models\RecipeHistory;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DoctorsController extends Controller
{
    public function dashboard(){
        return view('doctors.dashboard');
    }
    public function patients(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('FISH', 'like', "%{$search}%")
                    ->orWhere('passport', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->get();
        $medicine = Medicine::all();
        $pharmacists = Role::where('name', 'pharmacist')->first()->users;

        return view('doctors.patients', compact('patients', 'medicine', 'pharmacists'));
    }

    public function history()
    {
        $history = RecipeHistory::with('patient', 'medicine', 'pharmacist')
            ->where('user_id', auth()->id())
            ->get();

        return view('doctors.history', compact('history'));
    }


    public function recipe(Request $request)
    {
        RecipeHistory::create($request->all());
        return response()->json("OK");
    }
}
