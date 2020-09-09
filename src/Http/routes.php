<?php

use Illuminate\Support\Facades\Route;
use Dmlogic\RecruitmentApi\Http\Controllers\UploadCv;
use Dmlogic\RecruitmentApi\Http\Controllers\StartApplication;
use Dmlogic\RecruitmentApi\Http\Controllers\SubmitApplication;

Route::get('/', [StartApplication::class,'welcome']);
Route::options('/', [StartApplication::class,'docs']);
Route::post('/', [StartApplication::class,'create']);

Route::middleware(['verify_application'])->group(function () {
    Route::options('/{applicationId}', [SubmitApplication::class,'instructions']);
    Route::get('/{applicationId}', [SubmitApplication::class,'view']);
    Route::patch('/{applicationId}', [SubmitApplication::class,'update']);
    Route::post('/{applicationId}/upload_cv', [SubmitApplication::class,'uploadCv']);
    Route::post('/{applicationId}/confirm', [SubmitApplication::class,'confirm']);
});

