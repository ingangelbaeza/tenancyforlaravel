<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Middleware\InitializeTenancyByDomain;

use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        // dd(\App\Models\User::all());
        return 'Subdominio actual: ' . tenant('id');
    });
});

Route::middleware([
    'web',
    'universal',
    PreventAccessFromCentralDomains::class,
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
