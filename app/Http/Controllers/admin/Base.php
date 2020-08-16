<?php


namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\model\admin\User;
use App\model\admin\Base as BaseModel;

/**
 * Class Base
 * @package App\Http\Controllers\admin
 *
 *   所有后台控制器 增 删 改 都在这个控制器进行
 *   还有验证权限部分
 */
class Base extends Controller
{

    /**
     * 新增
     */
    public function add(Request $request)
    {

        //获取数据
        $data = $request->post();

        $model = getModel($request);

        //验证 规则 如果存在问题则抛出错误
        $validator = Validator::make($data, $model::$addRules, $model::$addMessages);

        $error = $validator->errors()->first();

        if ($error) {

            return response()->json(array('code' => '0', 'msg' => $error));

        }


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
