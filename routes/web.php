<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'digging_deeper'], function () {
    Route::get('collections', [\App\Http\Controllers\DiggingDeeperController::class, 'collection'])
        ->name('digging_deeper.collection');

    Route::get('process-video', [\App\Http\Controllers\DiggingDeeperController::class, 'processVideo'])
        ->name('digging_deeper.process-video');

    Route::get('prepare-catalog', 'DiggingDeeperController@prepareCatalog')
        ->name('digging_deeper.prepare-catalog');;

});

Route::group(['namespace' => 'App\Http\Controllers\Blog', 'prefix' => 'blog'], function () {
    Route::resource('posts', 'PostController')->names('blog.posts');
});

// Админка блога
$groupData = [
    'namespace' => 'App\Http\Controllers\Blog\Admin',
    'prefix'    => 'admin/blog',
];
Route::group($groupData, function () {
    //BlogCategory
    $methods = ['index', 'edit', 'store', 'update', 'create'];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    //BlogPost
    Route::resource('posts', 'PostController')
    ->except(['show'])
    ->names('blog.admin.posts');
});

//Route::resource('rest', 'RestTestController')->names('restTest');



