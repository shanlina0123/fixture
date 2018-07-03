<?php

/**
 * @param $password
 * @param $salt
 * @param int $saltGain
 * @return string
 * 加密
 */
function optimizedSaltPwd($password, $salt, $saltGain = 1)
{
    // 过滤参数
    if(!is_numeric($saltGain)) exit;
    if(intval($saltGain) < 0 || intval($saltGain) > 35) exit;
    // 对 Md5 后的盐值进行变换，添加信息增益
    $tempSaltMd5 = md5($salt);
    for($i = 0;$i < strlen($tempSaltMd5);$i ++)
    {
        if(ord($tempSaltMd5[$i]) < 91 && ord($tempSaltMd5[$i]) > 32)
        {
            // 每一个字符添加同样的增益
            $tempSaltMd5[$i] = chr(ord($tempSaltMd5[$i]) + $saltGain);
        }
    }
    // 返回整个哈希值
    return md5($password . $tempSaltMd5);
}


/**
 * @param string $prefix
 * @return string
 * UUID
 */
function create_uuid($prefix = "")
{
    $str = md5(uniqid(mt_rand(), true));
    $uuid  = substr($str,0,8);
    $uuid .= substr($str,8,4);
    $uuid .= substr($str,12,4);
    $uuid .= substr($str,16,4);
    $uuid .= substr($str,20,12);
    return $prefix . $uuid;
}

/**
 * @param $data
 * @return array
 * 递归去除空格
 */
function trimValue( $data )
{
    $t_data = array();
    foreach ( $data as $k=>$v )
    {
        if( is_array($v) )
        {
            $t_data[$k] = trimValue( $v );
        }else
        {
            $t_data[$k] = trim( $v );
        }
    }
    return $t_data;
}

/**
 * @param $data
 * @return array
 * 查询参数过滤
 */
function ParameterFiltering( $data )
{
    $t_data = array();
    $pregs = '/select|insert|update|CR|document|LF|eval|delete|script|alert|\'|\/\*|\#|\--|\ --|\/|\*|\-|\+|\=|\~|\*@|\*!|\$|\%|\^|\&|\(|\)|\/|\/\/|\.\.\/|\.\/|union|into|load_file|outfile/';
    foreach ( $data as $k=>$v )
    {
        if( is_array($v) )
        {
            $t_data[$k] = ParameterFiltering( $v );
        }else
        {
            if( preg_match($pregs,$v) == 1)
            {
                $t_data[$k] = str_replace(trim( $v ),'',trim( $v ));
            }else
            {
                $t_data[$k] = trim( $v );
            }
        }
    }
    return $t_data;
}

/**
 * @param $data
 * @return mixed
 * 返回数据类型
 */
function dataType( $data )
{
   return $data;
}


/**
 * @param $path
 * @return string
 * 返回图片地址
 */
function getImgUrl( $path )
{

    $uploads="/".config("configure.uploads")."/";
    return $uploads.$path;
}

/**
 * @param $str
 * @param $name
 * @return array
 * 拆分字符串
 */
function extractionInt( $str,$key )
{
    preg_match_all('/\d+/',$str,$array );
    if( is_array($array[0]) )
    {
        $arr = $array[0];
        return isset($arr[$key])?$arr[$key]:'';
    }else
    {
        return '';
    }
}

/***
 * 拼接字符串
 * @return string
 */
function mosaic($segmentation="")
{
    $params=func_get_args();
    unset($params[0]);
    return implode($segmentation,$params);
}

/***
 * 判断是否图片文件是否存在
 * @param $url
 * @return string
 */
function image($url,$point="50%")
{
    $imageUrl=mosaic("",config('configure.uploads'),$url);
    $showImageUrl=mosaic("",config('configure.showUploads'),$url);
    if(file_exists($imageUrl))
    {
        $html = "<img src=\"$showImageUrl\" width=\"$point\" >";
    }else{
        $html =  "<i class=\"layui-icon\" data-icon=\"#xe64a\"></i>";
    }
    return $html;
}

/**
 * @param string $status
 * @param string $messages
 * @param string $data
 * @param string $errorparam
 *
 */
function responseData( $status="", $messages="", $data="", $errorparam="" )
{
    $res["status"] = $status;//请求结果的状态
    $res["messages"] = $messages;//请求结果的文字描述
    $res["data"] = $data;//返回的数据结果
    if( $errorparam )
    {
        $res["errorparam"] = $errorparam; //错误参数对应提示
    }
    echo json_encode($res);
    die;
}

/***
 * 返回数组格式的返回值
 * @param string $status
 * @param string $messages
 * @param string $data
 * @param string $errorparam
 * @return mixed
 */
function responseCData( $status="", $messages="", $data="", $errorparam="" )
{
    $res["status"] = $status;//请求结果的状态
    $res["messages"] = $messages;//请求结果的文字描述
    $res["data"] = $data;//返回的数据结果
    if( $errorparam )
    {
        $res["errorparam"] = $errorparam; //错误参数对应提示
    }
    return $res;
}

/***
 * ajax返回
 * @param $backData
 */
function responseAjax($backData)
{
    echo json_encode($backData);
    die;

}

/**
 * @param $path
 * @param null $secure
 * @return string
 * 给css加默认前缀
 */
function pix_asset($path,$versionFlag = true,$secure=null)
{
    $path = config('configure.pix_asset').$path;
    if($versionFlag)
        $path.="?v=".config('configure.cssVersion');
    return asset($path, $secure,null);
}

/***
 * 获取登录用户信息
 * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
 */
function getUserInfo()
{
   return   session('userInfo');
}

/***
 * 根据路由名称返回原始的路由地址
 * @param $name
 * @return mixed
 * 比如：echo route_uri('blog.show'); // 会输出/blog/{blog}
 */
function route_uri($name)
{
    return app('router')->getRoutes()->getByName($name)->getUri();
}


/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}


/****
 * 过滤下划线和%
 * @param $str
 * @return mixed|string
 */
function searchFilter($str)
{
    $search = addslashes($str);
    $search = str_replace('_',"\\_",$search);
    $search = str_replace('%',"\\%",$search);
    return $search;
}

/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function httpRequest($url, $params, $method = 'GET', $header = array(), $multi = false){
    $opts = array(
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => $header
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            return false;// throw new Exception('不支持的请求方式！');
    }

    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error)  return false;//throw new Exception('请求发生错误：' . $error);
    return  $data;
}



/***
 * 图片转成base64编码
 * @param $image_file
 * @return string
 * 调用：
 * $img = 'test.jpg';
    $base64_img = base64EncodeImage($img);
    echo '<img src="' . $base64_img . '" />';
 */
function base64EncodeImage ($image_file) {
    $base64_image = '';
    $image_info = getimagesize($image_file);
    $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    return $base64_image;
}


/***
 * @param $url
 * @param $dataObj
 * @return mixed
 * 微信接口 curl post请求
 */
function wxPostCurl( $url , $dataObj )
{
    //初使化init方法
    $ch = curl_init();
    //指定URL
    curl_setopt($ch, CURLOPT_URL, $url);
    //设定请求后返回结果
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //声明使用POST方式来进行发送
    curl_setopt($ch, CURLOPT_POST, 1);
    //发送什么数据呢
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataObj,JSON_UNESCAPED_UNICODE));
    //忽略证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //忽略header头信息
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //设置超时时间
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    //发送请求
    $output = curl_exec($ch);
    //关闭curl
    curl_close($ch);
    //返回数据
    return $output;
}
//微信二维码专用
 function get_http_array($url,$post_data) {
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //没有这个会自动输出，不用print_r()也会在后面多个1
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
     $output = curl_exec($ch);
     curl_close($ch);
     $out = json_decode($output);
     return $out;
}
/**
 * @param $url
 * @return mixed
 * curl get
 */
function getCurl( $url, $herder=1 )
{
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, $herder);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
    return $data;
}

/**
 * 获取当前控制器名
 *
 * @return string
 */
 function getCurrentControllerName()
{
    $all=getCurrentAction()['controller'];
    $arr=explode("\\", $all);
    //获取最后一个/后边的字符
    $last=$arr[count($arr)-1];
    return $last;
}

/**
 * 获取当前方法名
 *
 * @return string
 */
 function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}

/**
 * 获取当前控制器与方法
 *
 * @return array
 */
 function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    list($class, $method) = explode('@', $action);

    $arr=explode("\\", $class);
    //获取最后一个/后边的字符
    $class=$arr[count($arr)-1];
    return ['controller' => $class, 'method' => $method];
}

/***
 * 极光账号username
 * @param $userid
 * @param string $pre
 * @return string
 */
function username($userid,$pre="jmessage_"){
     return $pre.$userid;
}

