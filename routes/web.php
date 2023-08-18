<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Models\{File,Folder};
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dash', function () {

    $folders= Folder::where('user_id','=',Auth::id())->get();
    $files= File::where('user_id','=',Auth::id())->get();

    return view('dashboard',['folders'=>$folders,'files'=>$files]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/folders/create', [FolderController::class, 'create'])->name('folder.create');
    Route::post('/folders/store', [FolderController::class, 'store'])->name('folder.store');
    // Route::get('/folders', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/files/create', [FileController::class, 'create'])->name('file.create');
    Route::post('/files/store', [FileController::class, 'store'])->name('file.store');
    Route::get('/files/destroy/{file}', [FileController::class, 'destroy'])->name('file.destroy');
    Route::get('/files/download/{file}', [FileController::class, 'download'])->name('file.download');

    Route::get('/files/move/{file}', [FileController::class, 'movePage'])->name('file.move');
    Route::post('/files/move/{file}', [FileController::class, 'moveAction'])->name('file.move');

});





require __DIR__.'/auth.php';
