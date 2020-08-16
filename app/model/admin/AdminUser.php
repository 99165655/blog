<?php

namespace App\model\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Model
{

    use SoftDeletes;

    //设置可写入字段
    protected $fillable = array('username', 'password', 'email', 'token');

    //创建时间
    const CREATED_AT = 'reg_time';

    //更新时间
    const UPDATED_AT = 'update_time';


    const DELETED_AT = 'delete_time';

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

    public static function adminLogin($data)
    {

        $false = false;


        $field = array('id',  'username', 'password', 'status', 'token');

        //以账号查询数据库
        $user = self::where('username', $data['username'])->select($field)->first();

        //用户不存在则抛出错误
        if (empty($user)) return ret_result($false, self::$name_err);

        //转数组
        $user = $user->toArray();


        //密码比对
        if (!Hash::check($data['password'], $user['password'])) {

            return ret_result($false, self::$pass_err);

        }

        //状态 是否冻结
        if ($user['status'] === 0) {

            return ret_result($false, self::$status_err);

        }

        //调取菜单 在这里暂时给一个假的
        $aside = array(
            array('title' => '用户管理', 'icon' => 'folder-o', 'children' => array(
                array('path' => '/userList', 'title' => '用户列表'),
            )),
            array('title' => '权限管理', 'icon' => 'folder-o', 'children' => array(
                array('path' => '/page1', 'title' => '权限列表'),
            )),
            array('title' => '角色管理', 'icon' => 'folder-o', 'children' => array(
                array('path' => '/page1', 'title' => '角色列表'),
            )),
        );
        $aside = json_encode($aside, JSON_UNESCAPED_UNICODE);
        //赋值 Uid 与token 并返回结果
        unset($user['password']);

        self::$success['aside'] = $aside;

        self::$success = array_merge(self::$success, $user);

        //更新token值
        $result = self::where('id', $user['id'])->update(array('token' => self::getToken($user)));

        //将Token 写入redis
        Redis::setex($user['token'], '3600', $user['id']);

        return ret_result($result, self::$success);
    }

    /**
     * 用户列表
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public static function userData($page, $username)
    {
        $field = array('status', 'id', 'email', 'username', 'id', 'reg_time', 'status AS status_text');

        $where = array();

        $username ? $where[] = array('username', 'LIKE', '%' . $username . '%') : $where[] = array('id', '>', 0);

        $list = self::select($field)->where($where)->orderBy('id', 'desc')->paginate(5, '', '', $page);

        return response()->json(self::setListData($list), '200');
    }

    /**
     * 新增用户
     * @param $data 数据
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addUser(array $data)
    {
        //处理数据
        unset($data['password_confirmation']);

        $data['password'] = hash::make($data['password']);

        //入库
        $result = self::create($data);

        return add_result($result);
    }

    /**
     * 获取Token
     * @param array $data
     * @return string
     */
    public static function getToken(array $data)
    {
        $token = implode(',', $data) . date('Y-m-d H:i:s', time());

        return hash::make($token);
    }

    /**
     * 处理数据
     * @param $list 数据
     * @return array
     */
    public static function setListData($list)
    {
        $status_text = array('0' => '冻结', '1' => '正常');

        $data = $list->toArray();

        foreach ($data['data'] as $k => &$v) {

            $v['status_text'] = $status_text[$v['status']];

        }

        return $data;
    }

    /**
     * 软删除
     */
    public static function deleteUser($id)
    {
        $result = self::where('id', $id)->delete();

        return delete_result(true);
    }

    public static function userStatus($id, $status)
    {
        $result = self::where('id', $id)->update(array('status' => !$status));

        return status_result($result,$status);
    }
}
