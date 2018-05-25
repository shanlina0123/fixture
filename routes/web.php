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
    //微信第三方授权
    Route::any('wx/verify_ticket', 'WxTicketController@verifyTicket');//微信第三方推荐verify_ticket地址
    Route::any('wx/{appid}/callback/message', 'WxTicketController@message'); //通过该URL接收公众号或小程序消息和事件推送
    Route::get('wx/authorize', 'WxAuthorizeController@WxAuthorize')->name('wx-authorize');//发起授权
    Route::any('wx/authorize/back', 'WxAuthorizeController@WxAuthorizeBack');//授权回调
    //注册登陆
    Route::match(['get', 'post'], 'register', 'RegisterController@register')->name('register');//注册页面
    Route::match(['get', 'post'], 'login', 'LoginController@login')->name('login');//登录
    Route::get('signout', 'LoginController@signOut')->name('signout');//登出
    Route::match(['get', 'post'],'recover-pass', 'RecoverPassController@recoverPass')->name('recover-pass');//忘记密码
    //发短信
    Route::put('sms/code', 'PublicController@sendSms')->name('sms-code');
    //中间件登录认证路由
    Route::group(['middleware' => ['checkUser']], function () {
        Route::get('/', 'IndexController@index')->name('index'); //入口
        //微信代码管理
        Route::get('wx/upcode/{appid}', 'WxAuthorizeController@upCode')->name('wx-upcode');//提交代码
        Route::get('wx/upsourcecode/{appid}', 'WxAuthorizeController@upSourceCode')->name('wx-upsource-code');//发布代码
        Route::get('wx/auditid', 'WxAuthorizeController@auditid');//发布代码审核状态查询
        //公司信息
        Route::match(['get', 'post'], 'company/setting', 'CompanyController@companySetting')->name('company-setting');  //公司信息设置

        //用户资料
        Route::match(['get', 'post'], 'user/info', 'UserController@userInfo')->name('user-info'); //个人资料跟换电话
        Route::match(['get', 'post'], 'user/set-pass', 'UserController@setPass')->name('set-pass'); //修改密码
        //中间件权限认证路由
        Route::group(['middleware' => ['checkAuth']], function () {
            //微信认证页面
            Route::get('user/authorize', 'UserController@userAuthorize')->name('user-authorize');
            Route::any('upload-temp-img', 'PublicController@uploadImgToTemp');   //上传图片
            //工地
            Route::resource('site', 'SiteController');//工地管理
            Route::post('site/template-tag', 'SiteController@templateTag')->name('site-template-tag');
            Route::post('site/isopen', 'SiteController@isOpen')->name('site-isopen');//工地是否公开
            Route::match(['get', 'post'],'site/renew/{uuid}', 'SiteController@siteRenew')->name('site-renew');//更新工地动态
            //活动
            Route::resource('activity', 'ActivityController');  //项目管理 - 活动管理 默认路由
            Route::post('activity/setting', 'ActivityController@setting')->name('activity-setting'); //项目管理 - 活动管理-设置是否公开 默认路由
            Route::get('filter/store-index', 'FilterController@storeIndex')->name('filter-store-index'); //系统管理-门店管理 自定义路由
            Route::get('filter/storedel','FilterController@storeDel');
            Route::get('filter/storeadd','FilterController@storeAdd');
            Route::get('filter/storeedit','FilterController@storeEdit');
            Route::get('filter/storeedits','FilterController@storeEdits');
            Route::get('filter/role-index', 'FilterController@roleIndex')->name('filter-role-index'); //系统管理 - 角色管理 自定义路由
            //模板
            Route::resource('site-template', 'SiteTemplateController');//模板管理
            Route::post('site/add-default-template', 'SiteTemplateController@addDefaultTemplate')->name('site-add-default-template');//使用系统模板
            Route::post('site/template-default/{id}', 'SiteTemplateController@templateDefault')->name('site-template-default');//模板设置默认
            //客户
            Route::resource('client', 'ClientController');//客户管理
            Route::get('lucky/client','ClientController@getLuckyClient')->name('lucky-client');//活动客户
            Route::get('lucky/client/log/{id}','ClientController@getLuckyClientLog')->name('lucky-client-log');//活动客户
            Route::post('map-address', 'PublicController@getMapAddress')->name('map-address');//获取腾讯地图搜索的地址
            //角色
            Route::get("roles","RolesController@index")->name("roles-index");//列表
            Route::post("roles","RolesController@store")->name("roles-store");//新增-执行
            Route::put("roles/{uuid}","RolesController@update")->name("roles-update");//修改-执行
            Route::put("roles/setting/{uuid}","RolesController@setting")->name("roles-setting");//设置-执行
            Route::delete("roles/{uuid}","RolesController@delete")->name("roles-delete");//删除-执行
            Route::get("roles/auth/{roleid}","RolesController@auth")->name("roles-auth");//角色权限详情
            Route::put("roles/auth/{roleid}","RolesController@updateAuth")->name("roles-auth-update");//勾选权限
            //用户
            Route::get("admin","AdminController@index")->name("admin-index");//列表
            Route::post("admin","AdminController@store")->name("admin-store");//新增-执行
            Route::put("admin/{uuid}","AdminController@update")->name("admin-update");//修改-执行
            Route::delete("admin/{uuid}","AdminController@delete")->name("admin-delete");//删除-执行
            Route::put("admin/setting/{uuid}","AdminController@setting")->name("admin-setting");//设置-执行
            //门店
            Route::get("store","StoreController@index")->name("store-index");//列表
            Route::post("store","StoreController@store")->name("store-store");//新增-执行
            Route::put("store/{uuid}","StoreController@update")->name("store-update");//修改-执行
            Route::delete("store/{uuid}","StoreController@delete")->name("store-delete");//删除-执行
            //属性
            Route::get("data","DataController@index")->name("data-index");//列表
            Route::get("data/edit/{cateid}","DataController@edit")->name("data-edit");//详情列表
            Route::put("data/{id}","DataController@update")->name("data-update");//修改+新增-执行
            Route::delete("data/{id}","DataController@delete")->name("data-delete");//删除-执行
            //抽奖活动
            Route::get("lucky","ActivityLuckyController@index")->name("lucky-index");//列表
            Route::get("lucky/edit/{id}","ActivityLuckyController@edit")->name("lucky-edit");//详情列表
            Route::get("lucky/create","ActivityLuckyController@create")->name("lucky-create");//进入添加页
            Route::put("lucky/{id}","ActivityLuckyController@update")->name("lucky-update");//修改+新增-执行
            Route::delete("lucky/{id}","ActivityLuckyController@delete")->name("lucky-delete");//删除-执行
            Route::delete("lucky/prize/{id}","ActivityLuckyController@deleteprize")->name("lucky-prize-delete");//删除奖项-执行
            Route::put("lucky/setting/{id}","ActivityLuckyController@setting")->name("lucky-setting");//上线/下线
            Route::get("lucky/extension/{id}","ActivityLuckyController@extension")->name("lucky-extension");//推广详情
            //Vip
            Route::get("vip","VipController@index")->name("vip-index");//列表
            //通知
            Route::get("notice","NoticeController@index")->name("notice-index");//列表
            Route::get("notice/listen/{time}","NoticeController@listen")->name("notice-listen");//监听
            //消息
            Route::get("message","MessageController@index")->name("message-index");//列表
        });
    });
});



