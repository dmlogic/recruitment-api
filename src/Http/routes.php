<?php

use Illuminate\Support\Facades\Route;
use Dmlogic\RecruitmentApi\Http\Controllers\UploadCv;
use Dmlogic\RecruitmentApi\Http\Controllers\StartApplication;
use Dmlogic\RecruitmentApi\Http\Controllers\SubmitApplication;

Route::get('/', [StartApplication::class,'welcome'])->name('welcome');
Route::options('/', [StartApplication::class,'docs'])->name('docs');
Route::post('/', [StartApplication::class,'create'])->name('create');

Route::middleware(['verify_application'])->group(function () {
    Route::options('/{uuid}', [SubmitApplication::class,'instructions'])->name('instructions');
    Route::get('/{uuid}', [SubmitApplication::class,'view'])->name('view');
    Route::patch('/{uuid}', [SubmitApplication::class,'update'])->name('update');
    Route::post('/{uuid}/upload_cv', [SubmitApplication::class,'uploadCv'])->name('upload');
    Route::post('/{uuid}/confirm', [SubmitApplication::class,'confirm'])->name('confirm');
});

