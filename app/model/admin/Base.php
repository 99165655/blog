<?php


namespace App\model\admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Base 公用模型
 * @package App\model\admin
 */
class Base extends Model
{

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

    public static $addMessages = [
        'username.required' => '必须填写用户名',
        'username.max' => '用户名不能超过20个字符',
        'username.unique' => '用户名已存在',
        'password.required' => '必须填写密码',
        'password.confirmed' => '两次密码不一致',
        'password_confirmed.required' => '必须填写确认密码',
        'email.required' => '必须填写邮箱',
        'email.sometimes' => '邮箱以存在',
        'email.email' => '邮箱格式错误',
        'email.unique' => '邮箱已存在',
    ];


    public function add($data)
    {
        //入库
        $result = self::create($data);

        return add_result($result);
    }

}
