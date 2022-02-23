<?php

use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::controller(TeamController::class)
    ->group(function (){
        Route::get('/', 'index');
        Route::get('/teams', 'teams');
        Route::get('/week/{week}', 'week');
        Route::post('/week/{week}', 'playWeek');
    });

