<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PharmacistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $doctor = User::create($request->all());
        $doctor->assignRole('pharmacist');

        return response()->json(['message' => 'Aptekachi saqlandi!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pharmacist = User::find($id);

        if (!$pharmacist) {
            return response()->json(['success' => false, 'message' => 'Aptekachi topilmadi!']);
        }

        if (!$pharmacist->hasRole('pharmacist')) {
            return response()->json(['success' => false, 'message' => 'Bu foydalanuvchi aptekachi emas va o‘chirib bo‘lmaydi!']);
        }

        $pharmacist->delete();
        return response()->json(['success' => true, 'message' => 'Aptekachi muvaffaqiyatli o‘chirildi!']);
    }
}
