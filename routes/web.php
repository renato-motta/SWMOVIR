<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Productable;

// Route::redirect('/', '/admin');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    // 1. Verificar si el usuario está autenticado
    if (Auth::check()) {
        // 2. Si está autenticado, redirigir al dashboard
        return redirect()->route('admin.dashboard'); // Usamos el nombre de la ruta: 'admin.dashboard'
    }

    // 3. Si NO está autenticado, mostrar la vista de bienvenida (login/registro)
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});

Route::get('/prueba', function(){
    return Productable::where('productable_type', 'App\Models\Sale')
    ->join('products', 'productables.product_id', '=', 'products.id')
     ->selectRaw('
        products.id as id,
        products.name as name,
        products.description as description,
        SUM(productables.quantity) as quantity,
        SUM(productables.subtotal) as subtotal    
    ')
    ->groupBy('products.id','products.name','products.description')
    ->orderBy('subtotal','desc')
    ->get();
})->name('prueba');

