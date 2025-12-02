<?php

use App\Http\Controllers\Api\RecaptchaController;
use Illuminate\Support\Facades\Route;

Route::post('/recaptcha/verify', [RecaptchaController::class, 'verify']);
