<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 16:36
 */

/***
 * 格式：模块+控制器+方法+错误
 * 00+00+00+000
 * Class StatusCode
 */
class StatusCode
{
    const SUCCESS=1;//成功
    const ERROR=0;//失败
    const CHECK_FORM = 2;//表单验证失败
    const PARAM_ERROR=3;//参数错误
    const DB_ERROR=4;//数据库错误失败
    const EMPTY_ERROR=5;//空数据
    const TOKEN_ERROR=6;//token错误
    const REQUEST_ERROR=7;//非法请求
    const CATCH_ERROR=8;//catch异常
    const EXIST_ERROR=9;//已存在
    const TOKEN_GET_ERROR=10;//token解析失败
    const OUT_ERROR=11;//超出管理员所属
    const NOT_DEFINED=12;//非预定义
    const NOT_EXIST_ERROR=13;//不存在
    const NOT_CHANGE=14;//无变化
    const EXIST_NOT_DELETE=15;//存在不能删除的数据
    const ROLE_ERROR=16;//角色无权限
    const AUTH_ERROR=17;//无权限
    const TOKEN_EMPTY=18;//token为空
    const AUTH_NOT_DEFINED_ERROR=19;//未定义暂未开放
    const ROLE_HIDDEN=20;//角色已禁用
    const TOKEN_OVERDUE=21;//token失效

}