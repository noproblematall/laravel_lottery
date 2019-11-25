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

Route::get('/', 'FrontEndController@index')->name('welcome');

Auth::routes(['verify' => true]);

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']],function ($router){
    Route::get('home', 'AdminController@index')->name('admin.home');
    Route::any('user_manage', 'AdminController@user_manage')->name('admin.user_manage');
    Route::get('user_delete/{id}', 'AdminController@user_delete')->name('admin.user_delete');

    Route::any('lottery_manage', 'LotteryController@lottery_manage')->name('admin.lottery_manage');
    Route::get('lottery_detail/{id}', 'LotteryController@lottery_detail')->name('admin.lottery_detail');
    Route::get('lottery_delete/{id}', 'LotteryController@lottery_delete')->name('admin.lottery_delete');
    // Route::get('lottery_edit/{id}', 'LotteryController@lottery_edit')->name('admin.lottery_edit');
    // Route::post('lottery_update', 'LotteryController@lottery_update')->name('admin.lottery_update');
    // Route::get('lottery_new', 'LotteryController@lottery_new')->name('admin.lottery_new');
    // Route::post('lottery_create', 'LotteryController@lottery_create')->name('admin.lottery_create');

    Route::any('order_manage', 'AdminController@order_manage')->name('admin.order_manage');
    Route::get('order_detail/{id}', 'AdminController@order_detail')->name('admin.order_detail');
    Route::get('setting', 'AdminController@setting')->name('admin.setting');
    Route::post('time_cost', 'AdminController@time_cost')->name('admin.time_cost');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/history', 'HomeController@history')->name('history');
Route::post('/profile', 'HomeController@change_profile')->name('profile');
Route::get('/password', 'HomeController@change_password')->name('password');

Route::post('/post_home', 'FrontEndController@post_home')->name('post_home');
Route::get('/payment', 'HomeController@payment')->name('payment');

Route::any('/callback', 'FrontEndController@callback')->name('callback');
Route::any('/payment_verify', 'FrontEndController@payment_verify')->name('payment_verify');
Route::post('/clear_seesion', 'FrontEndController@clear_seesion')->name('clear_seesion');

Route::get('more_view/{id}', 'FrontEndController@more_view')->name('more_view');

