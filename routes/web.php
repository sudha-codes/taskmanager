<?php

use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class);
});
