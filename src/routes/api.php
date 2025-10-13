<?php

use EnEH2\FileManager\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;


Route::name('eneh-filemanager')->prefix('/eneh-filemanager')->group(function () {
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
    Route::post('/show', [FileController::class, 'show'])->name('show');
});

