<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicinePharmacie;
use App\Models\User;
use Illuminate\Http\Request;

class MedicineController extends Controller
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
    public function add(Request $request)
    {
        $data = Medicine::find($request->id);
        $data->update([
            'count'=> $data->count + $request->count
        ]);
        return response()->json("OK");
    }

    public function send(Request $request)
    {
        $items = $request->input('items'); // { medicine_id, quantity }

        foreach ($items as $item) {
            $userId = auth()->id(); // Hozirgi foydalanuvchi ID
            $medicineId = $item['medicine_id'];
            $pharmacist_id = $item['pharmacist_id'];
            $quantity = $item['quantity'];

            // Medicine modelidan dori miqdorini olish
            $medicine = Medicine::find($medicineId);

            if (!$medicine) {
                return response()->json(['message' => 'Dori topilmadi.'], 404);
            }

            // Dori mavjud bo'lsa, mavjud count qiymatini tekshirib, quantity ni yangilaymiz
            if ($medicine->count < $quantity) {
                return response()->json(['message' => 'Miqdor yetarli emas.'], 400);
            }

            // MedicinePharmacie modelidan tekshirish
            $medicinePharmacie = MedicinePharmacie::where('pharmacist_id', $pharmacist_id)
                ->where('medicine_id', $medicineId)
                ->first();

            if ($medicinePharmacie) {
                // Agar mavjud bo'lsa, quantity ni yangilash
                $medicinePharmacie->quantity += $quantity;
                $medicinePharmacie->save();
            } else {
                // Agar mavjud bo'lmasa, yangi yozuv yaratish
                MedicinePharmacie::create([
                    'user_id' => $userId,
                    'medicine_id' => $medicineId,
                    'pharmacist_id' => $pharmacist_id,
                    'quantity' => $quantity
                ]);
            }

            // Medicine jadvalidagi count ni kamaytirish
            $medicine->count -= $quantity;
            $medicine->save(); // count yangilandi
        }

        // Javob qaytarish
        return response()->json(['message' => 'Dorilar muvaffaqiyatli saqlandi']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Medicine::create([
            'name' => $request['name'],
            'type_id' => $request['type_id'],
            'price' => $request['price'],
        ]);
        return response()->json('Medicine has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $medicine = Medicine::find($id);

        if (!$medicine) {
            return response()->json(['success' => false, 'message' => 'Dori topilmadi!']);
        }

        if (!$user->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Dorini faqat administrato o‘chirish imkoniga ega!']);
        }

        $medicine->delete();
        return response()->json(['success' => true, 'message' => 'Dori muvaffaqiyatli o‘chirildi!']);
    }
}
