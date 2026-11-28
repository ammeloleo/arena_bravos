<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComandaController;
use App\Http\Controllers\ComandaItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Models\Comanda;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/comandas');
Route::get('/relatorios', [ReportController::class, 'index'])->name('relatorios.index');

Route::get('/dashboard', function () {
    return view('dashboard.index', [
        'openComandas' => Comanda::query()->open()->count(),
        'closedToday' => Comanda::query()->closed()->whereDate('closed_at', today())->count(),
    ]);
})->name('dashboard');

Route::resource('comandas', ComandaController::class)->only(['index', 'create', 'store', 'show']);
Route::post('comandas/{comanda}/fechar', [ComandaController::class, 'close'])->name('comandas.close');
Route::post('comandas/{comanda}/itens', [ComandaItemController::class, 'store'])->name('comandas.items.store');
Route::delete('comandas/{comanda}/itens/{item}', [ComandaItemController::class, 'destroy'])->name('comandas.items.destroy');

Route::resource('produtos', ProductController::class)
    ->parameters(['produtos' => 'product'])
    ->only(['index', 'store', 'update', 'destroy']);
Route::get('produtos/{product}/foto', [ProductController::class, 'image'])->withTrashed()->name('produtos.image');
Route::resource('categorias', CategoryController::class)
    ->parameters(['categorias' => 'category'])
    ->only(['index', 'store', 'update', 'destroy']);
