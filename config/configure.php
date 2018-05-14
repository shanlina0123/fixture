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
    "sCache"=>120,//缓存时长

    /**
     * ---------------------------
     * 图片信息
     * ---------------------------
     */
   // "showUploads"=>$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/uploads",//图片预览路径
    "uploads"=>"uploads",//图片文件路径
    "temp"=>"/temp/",//图片临时目录

    /**
     * ----------------------------
     *  模板配置
     * ----------------------------
     */
    "pix_asset"=>"default/",//css js 目录
    "cssVersion"=>"003",//css版本
    "jsVersion"=>"001",//js版本


    /**
     * -----------------------------
     * 短信配置
     * -----------------------------
     */
     'sms_cache'=>10,//短信过期时间
     'is_sms'=>false,//true 开启短息 false 关闭短息

    /**
     * -----------------------------
     * 默认密码
     * ----------------------------*
     */
    "adminPwd"=>"xxs111111"
];