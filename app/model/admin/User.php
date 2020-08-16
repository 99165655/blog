<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Base
{
    use SoftDeletes;

    //设置可写入字段
    protected $fillable = array('username', 'password', 'email', 'token');


    //设定表名
    public $table = 'f_admin_user';

    //返回数据信息定义
    public static $success = array('code' => '1', 'msg' => '登录成功');

    public static $name_err = array('code' => '0', 'msg' => '用户名不存在');

    public static $pass_err = array('code' => '0', 'msg' => '密码错误');

    public static $status_err = array('code' => '0', 'msg' => '账号已冻结');

    public static $empty_data = array('code' => '0', 'msg' => '请填写完整数据');


    //新增用户验证信息以及报错信息
    public static $addRules = [
        'username' => 'required|max:20|unique:f_admin_user,username',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required',
        'email' => 'required|email|unique:f_admin_user,email',
    ];


}
