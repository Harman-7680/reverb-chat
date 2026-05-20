<?php

use Harman\ReverbChat\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::middleware(config('reverb-chat.middleware'))
    ->prefix(config('reverb-chat.route_prefix'))
    ->group(function () {

        Route::get('/{id}', [ChatController::class, 'index'])->name('reverb-chat.index');
        Route::post('/send', [ChatController::class, 'send'])->name('reverb-chat.send');

    });
