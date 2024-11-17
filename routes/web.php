<?php

use App\Http\Middleware\CheckGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

// user routes
// lessons routes
Route::get('/lessons', 'App\Http\Controllers\LessonController@index')->name('lesson.index');
Route::get('/lessons/{id}', 'App\Http\Controllers\LessonController@show')->name('lesson.show');

// orders routes
Route::get('/orders', 'App\Http\Controllers\OrderController@index')->name('order.index');
Route::get('/orders/{id}', 'App\Http\Controllers\OrderController@show')->name('order.show');
Route::get('/orders/create', 'App\Http\Controllers\OrderController@create')->name('order.create');
Route::post('/orders/save', 'App\Http\Controllers\OrderController@save')->name('order.save');
Route::delete('/orders/{id}', 'App\Http\Controllers\OrderController@delete')->name('order.delete');

// instrument routes
Route::get('/instruments', 'App\Http\Controllers\InstrumentController@index')->name('instrument.index');
Route::get('/instruments/{id}', 'App\Http\Controllers\InstrumentController@show')->name('instrument.show');

// stock routes
Route::get('/stocks', 'App\Http\Controllers\StockController@index')->name('stock.index');
Route::get('/stocks/{id}', 'App\Http\Controllers\StockController@show')->name('stock.show');
Route::post('/stocks/{id}/add', 'App\Http\Controllers\StockController@addStock')->name('stock.add');
Route::post('/stocks/{id}/lower', 'App\Http\Controllers\StockController@lowerStock')->name('stock.lower');
Route::delete('/stocks/{id}/delete', 'App\Http\Controllers\StockController@delete')->name('stock.delete');

// reviews routes
Route::get('/instruments/{id}/create-review', 'App\Http\Controllers\ReviewController@create')->name('review.create');
Route::post('/instruments/{id}/save-review', 'App\Http\Controllers\ReviewController@save')->name('review.save');

// cart routes
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::post('/cart/add/{id}/{type}', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::get('/cart/removeAll/', 'App\Http\Controllers\CartController@removeAll')->name('cart.removeAll');

// Admin routes
Route::middleware([CheckGroup::class.':admin'])->group(function () {
    Route::get('/admin', 'App\Http\Controllers\Admin\DashboardController@index')->name('admin.index');

    Route::get('/admin/lesson', 'App\Http\Controllers\Admin\AdminLessonController@lesson_index')->name('admin.lesson.index');
    Route::get('/admin/lesson/create', 'App\Http\Controllers\Admin\AdminLessonController@lesson_create')->name('admin.lesson.create');
    Route::post('/admin/lesson/save', 'App\Http\Controllers\Admin\AdminLessonController@lesson_save')->name('admin.lesson.save');
    Route::get('/admin/lesson/{id}', 'App\Http\Controllers\Admin\AdminLessonController@lesson_show')->name('admin.lesson.show');
    Route::delete('/admin/lesson/{id}', 'App\Http\Controllers\Admin\AdminLessonController@lesson_delete')->name('admin.lesson.delete');

    Route::get('/admin/instrument', 'App\Http\Controllers\Admin\AdminInstrumentController@instrument_index')->name('admin.instrument.index');
    Route::get('/admin/instrument/create', 'App\Http\Controllers\Admin\AdminInstrumentController@instrument_create')->name('admin.instrument.create');
    Route::post('/admin/instrument/save', 'App\Http\Controllers\Admin\AdminInstrumentController@instrument_save')->name('admin.instrument.save');
    Route::get('/admin/instrument/{id}', 'App\Http\Controllers\Admin\AdminInstrumentController@instrument_show')->name('admin.instrument.show');
    Route::delete('/admin/instruments/{id}', 'App\Http\Controllers\Admin\AdminInstrumentController@instrument_delete')->name('admin.instrument.delete');

    Route::get('/admin/stock', 'App\Http\Controllers\Admin\AdminStockController@stock_index')->name('admin.stock.index');
    Route::get('/admin/stock/{id}', 'App\Http\Controllers\Admin\AdminStockController@stock_show')->name('admin.stock.show');
    Route::post('/admin/stock/{id}/add', 'App\Http\Controllers\Admin\AdminStockController@addStock')->name('admin.stock.add');
    Route::post('/admin/stock/{id}/lower', 'App\Http\Controllers\Admin\AdminStockController@lowerStock')->name('admin.stock.lower');
    Route::delete('/admin/stock/{id}/delete', 'App\Http\Controllers\Admin\AdminStockController@delete')->name('admin.stock.delete');

});

Auth::routes();
