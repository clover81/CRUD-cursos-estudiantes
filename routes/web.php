<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

// Cualquier ruta que NO empiece por api/ -> la sirve la SPA
Route::view('/{any}', 'home')->where('any', '^(?!api).*$');
