<?php
// use Igorkalm\IDPcontroller\IDPcontroller;
use Igorkalm\IDPcontroller\Http\Controllers\IDPcontroller;

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () { 
    // Open relay #?
    Route::get('/open-relay/{relay_number}/{acid}', [IDPcontroller::class, 'openRelay'])->middleware('api');
    
    // Close relay #?
    Route::get('/close-relay/{relay_number}/{acid}', [IDPcontroller::class, 'closeRelay'])->middleware('api');
    
    // Receives controller events' data
    Route::post('/get-controller-event/{idp_event}', [IDPcontroller::class, 'getControllerEvent']);
});