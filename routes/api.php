<?php

declare(strict_types=1);

use App\Http\Controllers\GetProductsController;

Route::get('/products', GetProductsController::class);
