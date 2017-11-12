<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $model = 'App\\Models\\Role';

    /**
     * 首页显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * 处理查询参数配置
     *
     * @param $params
     * @return array
     */
    public function where($params)
    {
        return [
            'name' => 'like',
            'display_name' => 'like',
        ];
    }

    /**
     * 创建数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $model = new $this->model;
        $model->name = $request->input('name');
        $model->display_name = $request->input('display_name');
        $model->description = $request->input('description');
        if ($model->save()) {
            $this->handleJson($model, 0);
        } else {
            $this->json['code'] = 1005;
        }

        return $this->returnJson();
    }

    /**
     * 修改事件信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        // 第一步: 验证请求数据
        $id = (int)$request->input('id');
        if (!$id) return $this->error();

        // 第二步: 查询数据是否存在
        /* @var $menu \App\Models\Role */
        $modelName = $this->model;
        $model = $modelName::find($id);
        if (!$model) return $this->error(1002);
  
        // 修改数据
        $model->name = $request->input('name');
        $model->display_name = $request->input('display_name');
        $model->description = $request->input('description');
        if ($model->save()) {
            $this->handleJson($model);
        } else {
            $this->json['code'] = 1007;
        }

        return $this->returnJson();
    }

    /**
     * 删除数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        // 第一步: 验证请求数据
        $id = (int)$request->input('id');
        if (!$id) return $this->error();

        // 第二步: 查询数据是否存在
        $modelName = $this->model;
        $model = $modelName::find($id);
        if (!$model) return $this->error(1002);

        // 删除数据
        if ($model->delete()) {
            $this->handleJson([]);
        } else {
            $this->json['code'] = 1006;
        }

        return $this->returnJson();
    }

    /**
     * 分配权限信息
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function permissions(Request $request, $id)
    {
        // 查询角色
        $model = Role::findOrFail($id);
        if ($request->isMethod('post')) {
            $model->name = $request->input('name');
            $model->display_name = $request->input('display_name');
            $model->description = $request->input('description');
            if ($model->save()) {
                $model->perms()->sync($request->input('permissions'));
                return redirect('/admin/roles/index');
            }
        }

        // 查询全部权限
        $permissions = Permission::all();

        return view('admin.roles.permissions', [
            'model' => $model,
            'permissions' => $permissions,
        ]);
    }
}
