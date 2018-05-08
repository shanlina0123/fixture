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
//PC端服务路由
Route::group(['namespace' => 'Server'], function () {
    Route::match(['get', 'post'], 'register', 'RegisterController@register')->name('register');//注册页面
    Route::match(['get', 'post'], 'login', 'LoginController@login')->name('login');//登录
    Route::get('signout', 'LoginController@signOut')->name('signout');//登出
    //中间件登录认证路由
    Route::group(['middleware' => ['checkUser']], function () {
        Route::get('/', 'IndexController@index')->name('index'); //入口
        Route::match(['get', 'post'], 'company/setting', 'CompanyController@companySetting')->name('company-setting');  //公司信息设置
        //中间件权限认证路由
        Route::group(['middleware' => ['checkAuth']], function () {
            Route::any('upload-temp-img', 'PublicController@uploadImgToTemp');   //上传图片
            Route::resource('site', 'SiteController');//工地管理
            Route::post('site/template-tag', 'SiteController@templateTag')->name('site-template-tag');
            Route::match(['get', 'post'],'site/renew/{uuid}', 'SiteController@siteRenew')->name('site-renew');//更新工地动态
            Route::resource('activity', 'ActivityController');  //项目管理 - 活动管理 默认路由
            Route::post('activity/setting', 'ActivityController@setting')->name('activity-setting'); //项目管理 - 活动管理-设置是否公开 默认路由
            Route::get('filter/store-index', 'FilterController@storeIndex')->name('filter-store-index'); //系统管理-门店管理 自定义路由
            Route::get('filter/role-index', 'FilterController@roleIndex')->name('filter-role-index'); //系统管理 - 角色管理 自定义路由
            Route::resource('site-template', 'SiteTemplateController');//模板管理
            Route::post('site-template-default/{id}', 'SiteTemplateController@templateDefault')->name('site-template-default');//模板设置默认
            Route::resource('client', 'ClientController');//客户管理
            Route::post('map-address', 'PublicController@getMapAddress')->name('map-address');//获取腾讯地图搜索的地址
        });
    });
});



