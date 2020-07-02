<?php
/**
 * @param $res 结果
 * @param $success 成功信息
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function ret_result($res, $error='')
{
    if ($res) {
        return response()->json($error);
    } else {
        return response()->json($error);
    }
}

/**
 * 写入返回结果
 * @param $res 结果
 * @param $success 成功信息
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function add_result($res)
{
    if ($res) {
        return response()->json(array('code'=>'1','msg'=>'新增成功'));
    } else {
        return response()->json(array('code'=>'0','msg'=>'新增失败'));
    }
}

/**
 * 更新返回结果
 * @param $res 结果
 * @param $success 成功信息
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function update_result($res)
{
    if ($res) {
        return response()->json(array('code'=>'1','msg'=>'编辑成功'));
    } else {
        return response()->json(array('code'=>'0','msg'=>'编辑失败'));
    }
}

/**
 * 删除返回结果
 * @param $res 结果
 * @param $success 成功信息
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function delete_result($res)
{
    if ($res) {
        return response()->json(array('code'=>'1','msg'=>'删除成功'));
    } else {
        return response()->json(array('code'=>'0','msg'=>'删除失败'));
    }
}

/**
 * 更新返回结果
 * @param $res 结果
 * @param $success 成功信息
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function status_result($res,$status)
{
    if ($res && $status == 0) {
        return response()->json(array('code'=>'1','msg'=>'以启用'));
    } else {
        return response()->json(array('code'=>'0','msg'=>'以停用'));
    }
}
