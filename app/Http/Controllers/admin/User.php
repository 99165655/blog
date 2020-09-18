<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\model\admin\User AS UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Base
{
    /**
     * 用户列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function userList(Request $request)
    {
        $page = $request->input('currentPage', 1);

        $username = trim($request->input('username', ''));

        return UserModel::userData($page, $username);
    }


    /**
     * 因为 新增用户需要对密码进行加密处理 所以这里 进行重写
     */

    public function add(Request $request)
    {

        //获取数据
        $data = $request->post();

        //验证 通过返回模型不通过抛出错误
        $model = self::commonValidator($request,$data,'add');

        //处理密码
        $data['password'] = Hash::make($data['password']);


        return  $model::add($data);
    }
}

