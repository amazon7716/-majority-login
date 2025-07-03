<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/enviar-telefono', [AuthController::class, 'enviarTelefono'])->name('enviar.telefono');

Route::post('/verificar-codigo', [AuthController::class, 'verificarCodigo'])->name('verificar.codigo');
Route::post('/ingresar-password', [AuthController::class, 'ingresarPassword'])->name('ingresar.password');
