<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


/**
 * B端
 */
Route::group(['namespace' => 'Store'], function () {
    Route::post('user/login', 'LoginController@login');//登陆
    Route::group(['middleware'=>'ApiCheck'], function () {
        //工地
        Route::post('site/store', 'SiteController@store');//发布工地
        Route::get('site/site-list', 'SiteController@siteList');//工地列表
        Route::delete('site/site-destroy', 'SiteController@siteDestroy');//工地删除
        Route::put('site/is-open', 'SiteController@isOpen');//工地是否公开
        Route::put('site/is-finish', 'SiteController@isFinish');//工地是否完工
        Route::post('site/edit', 'SiteController@siteEdit');//工地修改数据
        Route::put('site/update', 'SiteController@siteUpdate');//工地修改数据
        Route::get('site/info', 'SiteController@siteInfo');//工地详情
        Route::get('site/dynamic', 'SiteController@siteDynamic');//工地详情动态

        //门店
        Route::post('store/store-list', 'StoreController@storeList');//门店列表
        //模板
        Route::post('template/default-template', 'TemplateController@defaultTemplate');//添加工地默认模板
        Route::post('template/template-list', 'TemplateController@templateList');//添加工模板列表
        Route::post('template/template-set', 'TemplateController@templateSet');//模板设置默认
        Route::post('template/template-destroy', 'TemplateController@templateDestroy');//模板删除
    });
});
