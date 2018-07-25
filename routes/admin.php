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
//后台服务路由
Route::group(['namespace' => 'Admin'], function () {
    //登录、登出
    Route::match(['get', 'post'], 'login', 'LoginController@login')->name('login');//登录
    Route::get('signout', 'LoginController@signOut')->name('signout');//登出

    //登录认证路由
    Route::group(['middleware' => ['checkUser']], function () {
        //入口
        Route::get('/', 'IndexController@index')->name('index');
        //控制面板
        Route::get('index/content', 'IndexController@indexContent')->name('index-content');
        //订单管理
        Route::get('index/content', 'OrderController@index')->name('order-index');//线上订单
        Route::get('index/content', 'OrderController@entity')->name('order-entity-index');//线下订单
        //商户管理
        Route::get('index/content', 'UsedController@index')->name('used-index');//免费版
        Route::get('index/content', 'UsedController@fee')->name('used-fee-index');//标准版
        Route::get('index/content', 'UsedController@entity')->name('used-entity-index');//定制版
        //平台用户管理
        Route::get('index/content', 'UserController@index')->name('user-index');
        //账号设置
        Route::get('index/content', 'AdminController@index')->name('admin-index');
    });
});



