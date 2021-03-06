<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//后台用户登录
Route::post('/admin/login','admin\Login@userLogin');

//后台登录后的中间件
Route::group(['middleware'=>['api'],'prefix'=>'admin'],function(){

    //管理员列表
    Route::post('userlist','admin\User@userList');

    //新增管理员
    Route::post('user/add','admin\User@add');

    //删除管理员
    Route::post('user/del','admin\User@delData');

    //修改用户状态
    Route::post('user/status','admin\User@status');
});
