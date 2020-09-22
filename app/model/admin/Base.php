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

    /**
     * 新增方法 所有数据库写入操作走一个方法 ，如果有特殊情况，在子类对当前方法进行重写
     * @param $data 写入的数据
     * @return \Illuminate\Http\JsonResponse
     */
    public  function add($data)
    {
        //入库
        $result = self::create($data);

        return add_result($result);
    }


    /**
     * 更改状态 但是只适用于 0 || 1
     * @param $id 数据表主键
     * @param $status 当前状态
     * @return \Illuminate\Http\JsonResponse
     */
    public static function status($id, $status)
    {
        $result = self::where('id', $id)->update(array('status' => !$status));

        return status_result($result, $status);
    }


    /**
     * 软删除 公共删除方法
     * @param $id 数据表主键
     * @return \Illuminate\Http\JsonResponse
     */
    public static function delData($id)
    {

        $result = self::where('id', $id)->delete();

        return delete_result($result);
    }

    /**
     * 更新数据
     * @param $id 数据表主键
     * @param $data 更新的数据
     * @return \Illuminate\Http\JsonResponse
     */
    public static function updateData($id, $data)
    {

        $result = self::where('id', $id)->update($data);

        return update_result($result);
    }


}
