<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\admin\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class Login extends Controller
{

    public function userLogin(Request $request)
    {

        //接收账号密码 如果不存在 默认为空
        $data['username'] = $request->post('username', '');

        $data['password'] = $request->post('password', '');
        //如果数据为空 抛出错误
        if (in_array('', $data)) return response()->json(User::$empty_data);

        //调用模型自定义函数
        $result = User::adminLogin($data);

        //返回结果
        return $result;
    }
}
