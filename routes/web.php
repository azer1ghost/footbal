<?php

use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::controller(TeamController::class)
    ->group(function (){
        Route::get('/', 'index');
        Route::get('/teams', 'teams');
        Route::get('/week/{id}', 'week');
        Route::post('/week/{id}', 'playWeek');
    });

