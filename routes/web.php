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

    //客服
    Route::any('wx/messageAuthorize', 'WxMessageController@messageAuthorize');//客服
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

    //错误页面
    Route::get("filter/undefined","ErrorController@undefined")->name("error-undefined");//400
    Route::get("filter/syserror","ErrorController@syserror")->name("error-syserror");//500
    Route::get("filter/lock","ErrorController@lock")->name("error-lock");//无权限
    Route::get("filter/coming","ErrorController@coming")->name("error-coming");//敬请期待

    //测试
    Route::get("test/index","TestController@index")->name("test-index");//test

    //手机授权页面
    Route::get('mp/authorize/code','WeChatPublicNumberController@authorizeCode')->name('mp-authorize-code');

    //中间件登录认证路由
    Route::group(['middleware' => ['checkUser']], function () {
        Route::get('/', 'IndexController@index')->name('index'); //入口
        Route::get('index/content', 'IndexController@indexContent')->name('index-content');

        //用户资料
        Route::match(['get', 'post'], 'user/info', 'UserController@userInfo')->name('user-info'); //个人资料跟换电话+绑定电话
        Route::match(['get', 'post'], 'user/set-pass', 'UserController@setPass')->name('set-pass'); //修改密码
        Route::get('user/wxcode', 'UserController@wxcode')->name('user-wxcode');//获取小程序二维码
        Route::get('user/check-openid', 'UserController@checkOpenid')->name('check-openid');//绑定微信检测

       //上传图片
        Route::any('upload-temp-img', 'PublicController@uploadImgToTemp');
        Route::get('upload-temp-del/{name}', 'PublicController@delTempImg');

        //Vip
        Route::get("vip","VipController@index")->name("vip-index");//列表
        Route::get("vip/store","VipController@store")->name("vip-store");//申请标准版

        //通知
        Route::get("notice","NoticeController@index")->name("notice-index");//列表
        Route::get("notice/listen/{time}","NoticeController@listen")->name("notice-listen");//监听
        //聊天消息
        #Route::get("message","MessageController@index")->name("message-index");//列表
        Route::get("chat","ChatController@index")->name("chat-index");//主页面
        Route::get("chat/init","ChatController@getInit")->name("chat-init");//配置
        Route::get("chat/login","ChatController@getLogin")->name("chat-login");//登录用户
        Route::post("chat/message","ChatController@getUserMessageData")->name("chat-message");//获取用户聊天记录

        //腾讯地图
        Route::post('map-address', 'PublicController@getMapAddress')->name('map-address');//获取腾讯地图搜索的地址
        //二维码
        Route::get('wx-code/{type}/{scene}/{width}', 'PublicController@getWxCodeImg')->name('wx-code');
        //体验小程序二维码
        Route::get('wx-experience-code', 'PublicController@getWxExperienceCodeImg')->name('wx-experience-code');
        //中间件权限认证路由
        Route::group(['middleware' => ['checkAuth']], function () {

            //下面的是管理员默认的权限
            //公司信息
            Route::match(['get', 'post'], 'company/setting', 'CompanyController@companySetting')->name('company-setting');  //公司信息设置
            //微信小程序认证页面
            Route::any('user/authorize', 'UserController@userAuthorize')->name('user-authorize');
            //微信小程序代码管理手动
            Route::get('wx/submission', 'WxAuthorizeController@submission')->name('wx-submission');
            //微信公众号授权页面
            Route::any('user/mpauthorize', 'UserController@userMpAuthorize')->name('user-mpauthorize');
            //下面的是其他用户自定义权限
            //工地
            Route::resource('site', 'SiteController');//工地管理
            Route::post('site/template-tag', 'SiteController@templateTag')->name('site-template-tag');
            Route::post('site/isopen', 'SiteController@isOpen')->name('site-isopen');//工地是否公开
            Route::match(['get', 'post'],'site/renew/{uuid}', 'SiteController@siteRenew')->name('site-renew');//更新工地动态
            Route::get("site/extension/{id}","SiteController@extension")->name("site-extension");//推广详情
            //模板
            Route::resource('site-template', 'SiteTemplateController');//模板管理
            Route::post('site/add-default-template', 'SiteTemplateController@addDefaultTemplate')->name('site-add-default-template');//使用系统模板
            Route::post('site/template-default/{id}', 'SiteTemplateController@templateDefault')->name('site-template-default');//模板设置默认
            //客户
            Route::resource('client', 'ClientController');//客户管理
            Route::get('lucky/client','ClientController@getLuckyClient')->name('lucky-client');//活动客户
            Route::get('lucky/client/log/{id}','ClientController@getLuckyClientLog')->name('lucky-client-log');//活动客户

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
            //项目动态
            Route::get('dynamic/{id}', 'DynamicController@getDynamicList')->name("dynamic-index");//动态列表
            Route::get('dynamic/edit/{uuid}', 'DynamicController@edit')->name("dynamic-edit");//动态修改
            Route::put('dynamic/update/{uuid}', 'DynamicController@update')->name("dynamic-update");//动态修改
            Route::delete('dynamic/destroy/{uuid}', 'DynamicController@destroy')->name("dynamic-destroy");//动态删除

            //服务通知
            Route::get('mp/send/index','WeChatPublicNumberController@sendIndex')->name('mp-send-index');//列表
            Route::post('mp/authorize','WeChatPublicNumberController@mpAuthorize')->name('mp-authorize');//授权共号
            Route::post('mp/send/template','WeChatPublicNumberController@sendTemplate')->name('send-template');//添加模板
            Route::post('mp/send/authorize/back','WeChatPublicNumberController@checkOpenidBack');//扫码回调检测
            Route::post('mp/send/addTemplate','WeChatPublicNumberController@sendAddTemplate')->name('mp-usersend-add');//个人添加模板

        });
    });
});



