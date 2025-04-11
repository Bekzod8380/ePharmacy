<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PharmacistsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('doctor')) {
            return redirect()->route('doctors.dashboard');
        } elseif ($user->hasRole('pharmacist')) {
            return redirect()->route('pharmacists.dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        // boshqa rollar uchun default
        return redirect()->route('welcome');
    }

    return redirect()->route('login');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (){ return redirect()->route('admin.doctors'); })->name('admin.dashboard');
    Route::get('/doctors', [MainController::class, 'doctors'])->name('admin.doctors');
    Route::get('/pharmacists', [MainController::class, 'pharmacists'])->name('admin.pharmacists');
    Route::get('/medicines', [MainController::class, 'medicines'])->name('admin.medicines');

    Route::resource('/doctor', DoctorController::class);
    Route::resource('/pharmacist', PharmacistController::class);
    Route::resource('/medicine', MedicineController::class);
    Route::resource('/patient', PatientController::class);

    Route::post('medicine/add', [MedicineController::class, 'add'])->name('medicine.add');
    Route::post('medicine/send', [MedicineController::class, 'send'])->name('medicine.send');

});


//Doctors
Route::middleware(['auth', 'verified'])->prefix('doctors')->group(function () {
    Route::get('/dashboard', function (){ return redirect()->route('doctors.patients'); })->name('doctors.dashboard');
    Route::get('/patients', [DoctorsController::class, 'patients'])->name('doctors.patients');
    Route::get('/history', [DoctorsController::class, 'history'])->name('doctors.history');

    Route::post('recipe', [DoctorsController::class, 'recipe'])->name('doctors.recipe');
});



//Pharmacist
Route::middleware(['auth', 'verified'])->prefix('pharmacists')->group(function () {
    Route::get('/dashboard', function (){ return redirect()->route('pharmacist.index'); })->name('pharmacists.dashboard');
    Route::get('/index', [PharmacistsController::class, 'index'])->name('pharmacist.index');
    Route::get('completed/{id}', [PharmacistsController::class, 'completed'])->name('pharmacist.completed');
});
