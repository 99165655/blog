<?php
/**
 * @param $res 结果
 * @param $success 成功信息
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function ret_result($res, $error = '')
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
        return response()->json(array('code' => '1', 'msg' => '新增成功'));
    } else {
        return response()->json(array('code' => '0', 'msg' => '新增失败'));
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

        return response()->json(array('code' => '1', 'msg' => '编辑成功'));

    } else {

        return response()->json(array('code' => '0', 'msg' => '编辑失败'));

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

        return response()->json(array('code' => '1', 'msg' => '删除成功'));

    } else {

        return response()->json(array('code' => '0', 'msg' => '删除失败'));

    }

}

/**
 * 更新返回结果
 * @param $res 结果
 * @param $success 成功信息
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function status_result($res, $status)
{

    $message = $status == '0' ? '以启用' : '已冻结';

    return response()->json(array('code' => '1', 'msg' => $message, 'status' => $status));

}

function getPath($request)
{
    //获取路由 并将反斜线 全部转为正斜线
    $route = str_replace('\\', '/', $request->route()->getAction()['controller']);

    //获取 @第一次出现位置也就是结束位置
    $end = strlen($route) - strpos($route, '@');

    //取得 正斜线 最后出现的位置
    $start = strrpos($route, '/') + 1;

    //截取字符串返回 控制器名称 并返回
    $class = substr($route, $start, ($end / -1));

    return 'App\model\admin\\' . $class;

}


/**
 * 抛出错误方法
 * @param $error 错误信息
 * @return \Illuminate\Http\JsonResponse
 */
function throwError($error)
{

    return response()->json(array('code' => '0', 'msg' => $error));

}


/**
 * 获取验证规则
 * @param $model 模型
 * @param $type add 新增 、 del 删除 、 status 更新状态 、 edit 编辑
 * @return bool
 */
function getRules($model, $type)
{
    //如果不是对象直接返回
    if (is_object($model) == false) {

        return false;

    }

    $result = array();

    //根据类型 自动返回不同的规则
    switch ($type) {

        case'add':

            $result['rules'] = $model->addRules;
            $result['message'] = $model->addMessage;
            break;
        case'del':

            $result['rules'] = $model->delRules;
            $result['message'] = $model->delMessage;
            break;
        case'status':

            $result['rules'] = $model->statusRules;
            $result['message'] = $model->statusMessage;
            break;
        case'edit':

            $result['rules'] = $model::editRules;
            $result['message'] = $model::editMessage;
            break;

    }

    return $result;

}






