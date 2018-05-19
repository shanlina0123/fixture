<?php

return [

    /**
     * 微信第三方平台配置信息
     */

    'token'=>'30b06afa212356',
    'encodingAesKey'=>'JEYUsglBS4w5FkH3uuXEbqRPiitKv18pASMZVH02aWy',
    'appId'=>'wxdb0f6f52362d0017',
    'extAppid'=>'wx676c383c431ecc6e',//关联的小程序appid
    'secret'=>'e734776fd0c05c77daaab587bd0b0268',
    'url'=>'https://fixture.yygsoft.com/wx/authorize/back',//授权回调地址
    'requestdomain'=>['https://fixture.yygsoft.com'], //request合法域名
    'wsrequestdomain'=>['wss://fixture.yygsoft.com'], //socket合法域名
    'uploaddomain'=>['https://fixture.yygsoft.com'], //uploadFile合法域名
    'downloaddomain'=>['https://fixture.yygsoft.com'],//downloadFile合法域名
    'address'=>'pages/index/index',//审核代码地址
    'tag'=>'装修',//审核代码标签
    'title'=>'装修',//小程序页面的标题
    'template_id'=>'0',//小程序模板id
    'version'=>'1.0',//小程序模板版本
    'desc'=>'云易装v1.0',//小程序模板版本描述
    "wxCode"=>[
            "prizepage"=>"pages/index/prize",
            "width"=>"50"
        ]
];
