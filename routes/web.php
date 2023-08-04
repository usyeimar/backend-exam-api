<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\CustomerForm;
use App\Http\Livewire\CustomerShow;
use App\Http\Livewire\CustomersTable;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/customers', CustomersTable::class)
        ->name('customers.index');

    Route::get('/customers/create',CustomerForm::class)
        ->name('customers.create');

    Route::get('/customers/{customer}/edit',CustomerForm::class)
        ->name('customers.edit');

    Route::get('/customers/{customer}',CustomerShow::class)
        ->name('customers.show');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
