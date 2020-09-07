<?php

Illuminate\Support\Facades\Route::get('/', 'ApplicationController@welcome');
Illuminate\Support\Facades\Route::options('/', 'ApplicationController@docs');
Illuminate\Support\Facades\Route::post('/', 'ApplicationController@create');
Illuminate\Support\Facades\Route::get('/{applicationId}', 'ApplicationController@view');
Illuminate\Support\Facades\Route::match(['put','patch'],'/{applicationId}', 'ApplicationController@update');
Illuminate\Support\Facades\Route::post('/{applicationId}/confirm', 'ApplicationController@confirm');
