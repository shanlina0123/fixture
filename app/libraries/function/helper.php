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
    return '/uploads/'.$path;
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