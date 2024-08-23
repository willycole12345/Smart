<?php

use App\Http\Controllers\Api\v1\AutobotsController;
use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\PostController;
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


Route::group(['prefix' => 'v1', 'App/Http/Controllers/Api/v1/'], function () {

    Route::controller(AutobotsController::class)->group(function () {

        Route::get( 'bot', 'create' );
        Route::get( 'autocreation', 'autocreation' );
        Route::get( 'totalUsersCreated', 'totalUsersCreated' );
      

     });
    Route::controller(PostController::class)->group(function () { 
        Route::get( 'post', 'create' );
     
    });
    Route::controller(CommentController::class)->group(function () { 
     
        Route::get( 'comment', 'create' );
    });

});

Route::middleware('throttle:5,1')->group(function () {

    Route::group(['prefix' => 'v1', 'App/Http/Controllers/Api/v1/'], function () {

        Route::controller(PostController::class)->group(function () { 
            Route::get( 'autobots', 'view' );
            Route::get( 'autobots', 'view' );
         
        });

        Route::controller(CommentController::class)->group(function () { 
     
            Route::get( 'autobotscomment', 'view' );
            Route::get( 'autobotscomment/{id}', 'view_by_commentid' );
        });

        Route::controller(PostController::class)->group(function () { 
            Route::get( 'autobotspost', 'view' );
            Route::get( 'autobotspost/{id}', 'view_with_id' );
         
        });
    });
});