<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Listen
// get zum auslesen
Route::get('lists',[\App\Http\Controllers\ListsController::class, 'index']);
Route::get('lists/{id}',[\App\Http\Controllers\ListsController::class, 'findbyId']);
Route::get('lists/checkid/{id}',[\App\Http\Controllers\ListsController::class, 'checkid']);
Route::get('lists/search/{searchTerm}',[\App\Http\Controllers\ListsController::class, 'findbySearchTerm']);


//Notizen
Route::get('notes',[\App\Http\Controllers\NoteController::class, 'index']);
Route::get('notes/{id}',[\App\Http\Controllers\NoteController::class, 'findbyId']);
Route::get('notes/checkid/{id}',[\App\Http\Controllers\NoteController::class, 'checkid']);
Route::get('notes/search/{searchTerm}',[\App\Http\Controllers\NoteController::class, 'findbySearchTerm']);


//Todos
Route::get('todos',[\App\Http\Controllers\TodoController::class, 'index']);
Route::get('todos/{id}',[\App\Http\Controllers\TodoController::class, 'findbyId']);
Route::get('todos/checkid/{id}',[\App\Http\Controllers\TodoController::class, 'checkid']);
Route::get('todos/search/{searchTerm}',[\App\Http\Controllers\TodoController::class, 'findbySearchTerm']);


//Tags
Route::get('tags',[\App\Http\Controllers\TagController::class, 'index']);


//anmelden, Login Methode aufrufen
Route::post('auth/login',[\App\Http\Controllers\AuthController::class,'login']);

Route::group(['middleware' => ['api','auth.jwt']], function(){
    //POST=Speichern von Listen
    Route::post('lists',[\App\Http\Controllers\ListsController::class, 'save']);
//PUT=Update von Listen
    Route::put('lists/{id}',[\App\Http\Controllers\ListsController::class, 'update']);
//DELETE=Löschen von Listen
    Route::delete('lists/{id}',[\App\Http\Controllers\ListsController::class, 'delete']);
    //POST=Speichern von Notizen
    Route::post('notes',[\App\Http\Controllers\NoteController::class, 'save']);
//PUT=Update von Notizen
    Route::put('notes/{id}',[\App\Http\Controllers\NoteController::class, 'update']);
//DELETE=Löschen von Notizen
    Route::delete('notes/{id}',[\App\Http\Controllers\NoteController::class, 'delete']);

    //POST=Speichern von Todos
    Route::post('todos',[\App\Http\Controllers\TodoController::class, 'save']);
//PUT=Update von Todos
    Route::put('todos/{id}',[\App\Http\Controllers\TodoController::class, 'update']);
//DELETE=Löschen von Notizen
    Route::delete('todos/{id}',[\App\Http\Controllers\TodoController::class, 'delete']);

    //POST=Speichern von Tags
    Route::post('tags',[\App\Http\Controllers\TagController::class, 'save']);
//PUT=Update von Tags
    Route::put('tags/{id}',[\App\Http\Controllers\TagController::class, 'update']);
//DELETE=Löschen von Tags
    Route::delete('tags/{id}',[\App\Http\Controllers\TagController::class, 'delete']);

    //abmelden
    Route::post('auth/logout', [\App\Http\Controllers\AuthController::class,'logout']);

});







