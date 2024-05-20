<?php

use App\Models\Lists;
use App\Models\Note;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
    //$notes = DB::table('notes')->get();
    //return $notes;
//});


Route::get('/', [App\Http\Controllers\ListsController::class, "index"]);
Route::get('/lists', [App\Http\Controllers\ListsController::class, "index"]);
Route::get('/lists/{id}', function ($id) {
    $list = Lists::find($id);
    $notes = Note::all();
    $todos = Todo::all();
    return view('notes.index', compact('list', 'notes', 'todos'));
});

Route::get('/notes', [App\Http\Controllers\ListsController::class, "index"]);
Route::get('/todos', [App\Http\Controllers\ListsController::class, "index"]);


Route::get('/notes/{id}', function ($id) {
    $note = Note::find($id);
    return view('notes.show',compact('note'));
});


