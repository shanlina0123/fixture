<?php

return [

    /**
     * 微信第三方平台配置信息
     */

    /**
     * ------------------------------
     *  公共
     * ------------------------------
     *
     */
    'encodingAesKey'=>'JEYUsglBS4w5FkH3uuXEbqRPiitKv18pASMZVH02aWy', //微信每隔10分钟消息加解密Key
    'token'=>'30b06afa212356',//微信每隔10分钟消息校验Token
    'appId'=>'wxdb0f6f52362d0017',
    'secret'=>'e734776fd0c05c77daaab587bd0b0268',
    'url'=>'https://fixture.yygsoft.com/wx/authorize/back',//授权回调地址
    'requestdomain'=>['https://fixture.yygsoft.com'], //request合法域名
    'wsrequestdomain'=>['wss://fixture.yygsoft.com'], //socket合法域名
    'uploaddomain'=>['https://fixture.yygsoft.com'], //uploadFile合法域名
    'downloaddomain'=>['https://fixture.yygsoft.com'],//downloadFile合法域名
    'address'=>'pages/index/index',//审核代码地址
    'tag'=>'装修',//审核代码标签
    'title'=>'装修',//小程序页面的标题
    'template_id'=>'2',//小程序模板id
    'version'=>'1.0.0',//小程序模板版本
    'desc'=>'云易装v1.0',//小程序模板版本描述
    "wxCode"=>[
            "lucky"=>"pages/prize/prize",
            "site"=>"pages/projectdetail/projectdetail",
            "allow"=>"pages/allowlogin/allowlogin"
        ]
];
