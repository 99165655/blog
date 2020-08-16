<?php


namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\model\admin\AdminUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Base extends Controller
{

    /**
     * 新增
     */
    public function add(Request $request)
    {


        dump($request->route()->getAction());die;

    }

    /**
     * 修改信息
     */
    public function edit()
    {

    }


    /**
     * 修改状态
     */
    public function status()
    {

    }

    /**
     * 删除
     */
    public function delete()
    {

    }

}
