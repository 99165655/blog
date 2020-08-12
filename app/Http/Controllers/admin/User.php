<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\admin\AdminUser;
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

        return AdminUser::userData($page, $username);
    }

    /**
     * 新增后台用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUser(Request $request)
    {
        //接受数据
        $data = $request->input();

        //验证 规则 如果存在问题则抛出错误
        $validator = Validator::make($data, AdminUser::$addRules, AdminUser::$addMessages);
        $error = $validator->errors()->first();
        if ($error) {
            return response()->json(array('code' => '0', 'msg' => $error));
        }

        //执行写入方法 并返回结果
        return AdminUser::addUser($data);
    }

    /**
     * 软删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request)
    {
        $id = $request->input('id', 0);
        return AdminUser::deleteUser($id);
    }

    /**
     * 修改状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userStatus(Request $request)
    {
        $id = $request->input('id', 0);

        $status = $request->input('status', 0);

        return AdminUser::userStatus($id, $status);
    }
}
