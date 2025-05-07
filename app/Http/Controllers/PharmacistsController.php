<?php

namespace App\Http\Controllers;

use App\Models\MedicinePharmacie;
use App\Models\RecipeHistory;
use Illuminate\Http\Request;

class PharmacistsController extends Controller
{
    public function index(Request $request){
        $data = RecipeHistory::where('status', 0)->where('pharmacist_id', auth()->user()->id)->with('patient')->with('medicine')->get();

        $data = RecipeHistory::where('status', 0)->with('patient')->with('medicine')->get();



        return view('pharmacists.index', compact('data'));
    }
    public function completed($id){
        $data = RecipeHistory::find($id);
        $data->status = 1;
        $data->save();
        return response()->json(['success' => true, 'message' => 'Muvaffaqiyatli yakunlandi!']);
    }
}
