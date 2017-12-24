<?php

namespace App\Http\Controllers\Admin;

/**
 * Class PermissionsController 权限信息操作控制器
 *
 * @package App\Http\Controllers\Admin
 */
class PermissionsController extends RolesController
{
    /**
     * @var string 定义使用的model
     */
    public $model = 'App\Models\Permission';

    /**
     * 首页显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.permissions.index');
    }
}
