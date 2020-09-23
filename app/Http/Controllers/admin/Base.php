<?php


namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

        //验证 通过返回模型不通过抛出错误
        $model = self::commonValidator($request, $data, 'add');

        return $model->add($data);
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
    public function status(Request $request)
    {
        //获取数据
        $data = $request->post();

        $id = $request->post('id');

        $status = $request->post('status');

        //验证 通过返回模型不通过抛出错误
        $model = self::commonValidator($request, $data, 'status');

        return $model->status($id, $status);
    }

    /**
     * 删除（软删）
     */
    public function delData(Request $request)
    {

        $data = $request->post();

        //验证 通过返回模型不通过抛出错误
        $model = self::commonValidator($request, $data, 'del');

        return $model::delData($data['id']);
    }

    /**
     * 封装验证部分代码
     * 因为 不管增删改 都需要验证 使用laravel 的验证数据
     * 所以把这一部分封装
     */
    public static function commonValidator($request, $data, $type)
    {

        //获取模型
        $path = getPath($request);

        $model = app($path);

        //获取验证字段
        $rules = getRules($model, $type);

        //验证 规则 如果存在问题则抛出错误
        $validator = Validator::make($data, $rules['rules'], $rules['message']);

        $error = $validator->errors()->first();


        if ($error) {

            throw new \Exception($error, 99999);

        }

        return $model;
    }

}
