<?php
return [

    /**
     * ---------------------------
     *  密码配置
     * ---------------------------
     */
    'salt' => 'ABCDEF%%%!!@@@4444',//登录加密秘钥

    /**
     * ---------------------------
     *  分页缓存
     * ---------------------------
     */
    "sPage"=>10,//每页显示条数
    "sCache"=>60,//缓存时长

    /**
     * ---------------------------
     * 图片信息
     * ---------------------------
     */
   // "showUploads"=>$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/uploads",//图片预览路径
    "uploads"=>"uploads",//图片文件路径
    "temp"=>"/temp/",//图片临时目录
    "maxImgSize"=>"2M",//图片最大上传大小
    "maxImgSizeByte"=>"2097152",//图片最大上传大小

    /**
     * ----------------------------
     *  模板配置
     * ----------------------------
     */
    "pix_asset"=>"default/",//css js 目录
    "cssVersion"=>"V1.0.1.1_201807171844",//strtotime(date("Y-m-d H:i:s")),//css版本
    "jsVersion"=>"V1.0.1.1_201807171844",//strtotime(date("Y-m-d H:i:s")),//js版本


    /**
     * -----------------------------
     * 短信配置
     * -----------------------------
     */
     'sms_cache'=>10,//短信过期时间
     'is_sms'=>false,//true 开启短息 false 关闭短息

    /***
     * ----------------------------
     * 邮件配置
     *  ----------------------------
     */
    "emails"=>[
        "mail_title"=>"系统异常，请及时维护！",
        "mail_is_open"=>false,//true开启异常邮件通知，false关闭异常邮件通知
        "mail_to_address"=>[
             ["name"=>"单莉娜","addr"=>"1161110682@qq.com"],
             ["name"=>"舒全刚","addr"=>"645064175@qq.com"]
        ]
    ],
    /**
     * -----------------------------
     * 默认密码
     * ----------------------------*
     */
    "adminPwd"=>"xxs111111",

    //抽奖活动默认图
    "lucky"=>[
        "companylogo"=>"default/lucky/defultlogo.jpg",
        "bgurl"=>"default/lucky/activebg.jpg",
        "makeurl"=>"default/lucky/brginprize.png",//立即抽奖默认
        "winurl"=>"default/lucky/gift.png",
        "loseurl"=>"default/lucky/noprize.png",
        "prize"=>[
            1=>"default/lucky/prize9.png",
            2=>"default/lucky/prize1.png",
            3=>"default/lucky/prize2.png",
            4=>"default/lucky/prize3.png",
            5=>"default/lucky/prize4.png",
            6=>"default/lucky/prize5.png",
            7=>"default/lucky/prize6.png",
            8=>"default/lucky/prize7.png",
            9=>"default/lucky/prize8.png",
        ]
    ],
    //工地默认图
    "site"=>[
        'logo'=>"default/site/defaultsite.jpg"
    ],
    "sys"=>[
        'site_phone'=>"029-89379272",
        'site_icp'=>"页面技术由西安灰熊家族网络科技提供（<a href='http://www.yygsoft.com'  class='colorbule' target=''>点击了解</a>）提供，技术支持方仅能提供页面技术，不承担由活动引起的相关法律责任"
        ],
    /**
     * 应用名称配置
     */
    'applicationName'=>'云易装',

    //外连接配置
    "website"=>[
        "home"=>"http://www.yygsoft.com",
        "tel"=>"029 - 89379272",
        "time"=>"(周一至周六09:00-18:00)"
    ],
	
	/**
     * -----------------------------
     * 筛选预算数据配置
     * -----------------------------
     */
    'budget'=>[
        ['value'=>'','name'=>'不限'],
        ['value'=>'0,3','name'=>'3万以下'],
        ['value'=>'3,5','name'=>'3-5万'],
        ['value'=>'5,8','name'=>'5-8万'],
        ['value'=>'8,12','name'=>'8-12万'],
        ['value'=>'12,18','name'=>'12-18万'],
        ['value'=>'18,30','name'=>'18-30万'],
        ['value'=>'30,100','name'=>'30-100万'],
        ['value'=>'100,0','name'=>'100万以上'],
    ]
];