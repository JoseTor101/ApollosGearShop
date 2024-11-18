<?php

use App\Http\Middleware\CheckGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

Route::get('locale/{locale}', 'App\Http\Controllers\LocaleController@setLocale')->name('locale.set');

// user routes
// lessons routes
Route::get('/lessons', 'App\Http\Controllers\LessonController@index')->name('lesson.index');
Route::get('/lessons/{id}', 'App\Http\Controllers\LessonController@show')->name('lesson.show');

// instrument routes
Route::get('/instruments', 'App\Http\Controllers\InstrumentController@index')->name('instrument.index');
Route::get('/instruments/{id}', 'App\Http\Controllers\InstrumentController@show')->name('instrument.show');

// stock routes
Route::get('/stocks', 'App\Http\Controllers\StockController@index')->name('stock.index');
Route::get('/stocks/{id}', 'App\Http\Controllers\StockController@show')->name('stock.show');

Route::middleware([CheckGroup::class . ':user'])->group(function () {
// cart routes
    Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');    
    Route::post('/cart/add/{id}/{type}', 'App\Http\Controllers\CartController@add')->name('cart.add');
    Route::delete('/cart/remove-item/{id}/{type}', 'App\Http\Controllers\CartController@removeItem')->name('cart.removeItem');
    Route::delete('/cart/removeAll/', 'App\Http\Controllers\CartController@removeAll')->name('cart.removeAll');

// order routes
    Route::get('/order', 'App\Http\Controllers\OrderController@index')->name('order.index');
    Route::post('/checkout', 'App\Http\Controllers\OrderController@checkout')->name('order.checkout');
    Route::get('/order/{id}', 'App\Http\Controllers\OrderController@show')->name('order.show');

    // reviews routes
    Route::get('/instruments/{id}/create-review', 'App\Http\Controllers\ReviewController@create')->name('review.create');
    Route::post('/instruments/{id}/save-review', 'App\Http\Controllers\ReviewController@save')->name('review.save');
});

// Admin routes
Route::middleware([CheckGroup::class.':admin'])->group(function () {
    Route::get('/admin', 'App\Http\Controllers\Admin\DashboardController@index')->name('admin.index');

    Route::get('/admin/lesson', 'App\Http\Controllers\Admin\AdminLessonController@index')->name('admin.lesson.index');
    Route::get('/admin/lesson/create', 'App\Http\Controllers\Admin\AdminLessonController@create')->name('admin.lesson.create');
    Route::post('/admin/lesson/save', 'App\Http\Controllers\Admin\AdminLessonController@save')->name('admin.lesson.save');
    Route::get('/admin/lesson/{id}', 'App\Http\Controllers\Admin\AdminLessonController@show')->name('admin.lesson.show');
    Route::delete('/admin/lesson/{id}', 'App\Http\Controllers\Admin\AdminLessonController@delete')->name('admin.lesson.delete');

    Route::get('/admin/instrument', 'App\Http\Controllers\Admin\AdminInstrumentController@index')->name('admin.instrument.index');
    Route::get('/admin/instrument/create', 'App\Http\Controllers\Admin\AdminInstrumentController@create')->name('admin.instrument.create');
    Route::post('/admin/instrument/save', 'App\Http\Controllers\Admin\AdminInstrumentController@save')->name('admin.instrument.save');
    Route::get('/admin/instrument/{id}', 'App\Http\Controllers\Admin\AdminInstrumentController@show')->name('admin.instrument.show');
    Route::delete('/admin/instruments/{id}', 'App\Http\Controllers\Admin\AdminInstrumentController@delete')->name('admin.instrument.delete');

    Route::get('/admin/stock', 'App\Http\Controllers\Admin\AdminStockController@index')->name('admin.stock.index');
    Route::get('/admin/stock/{id}', 'App\Http\Controllers\Admin\AdminStockController@show')->name('admin.stock.show');
    Route::post('/admin/stock/{id}/add', 'App\Http\Controllers\Admin\AdminStockController@addStock')->name('admin.stock.add');
    Route::post('/admin/stock/{id}/lower', 'App\Http\Controllers\Admin\AdminStockController@lowerStock')->name('admin.stock.lower');
    Route::delete('/admin/stock/{id}/delete', 'App\Http\Controllers\Admin\AdminStockController@delete')->name('admin.stock.delete');

    Route::get('/admin/order', 'App\Http\Controllers\Admin\AdminOrderController@index')->name('admin.order.index');
    Route::get('/admin/order/{id}', 'App\Http\Controllers\Admin\AdminOrderController@show')->name('admin.order.show');
    Route::delete('/admin/order/{id}/delete', 'App\Http\Controllers\Admin\AdminOrderController@delete')->name('admin.order.delete');
});

Auth::routes();
