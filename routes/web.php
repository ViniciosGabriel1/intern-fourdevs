<?php

use App\Services\PermissionGenerateService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

$service = new PermissionGenerateService();

$show = $service->handle();
dd($show);
    return view('welcome');
});
