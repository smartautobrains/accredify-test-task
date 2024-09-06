<?php

declare(strict_types=1);

use App\Http\Controllers\IndexController;
use App\Http\Middleware\ValidateContentMiddleware;
use App\Http\Middleware\ValidateIssuer;
use App\Http\Middleware\ValidateRecipient;
use App\Http\Middleware\ValidateSignature;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/', IndexController::class)
    ->middleware([ValidateContentMiddleware::class, ValidateRecipient::class, ValidateIssuer::class, ValidateSignature::class]);
