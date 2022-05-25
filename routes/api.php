<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendMailController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSale;
use Illuminate\Mail\Events\MessageSending;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('send-mail', [SendMailController::class, 'sendMail']);
Route::get('history/{id}', [SendMailController::class, 'history']);

Route::get('test', [SendMailController::class, 'test']);
