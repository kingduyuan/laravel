<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;

/**
 * Class AdminsController 后台管理员信息
 *
 * @package App\Http\Controllers\Admin
 */
class AdminsController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $model = 'App\Models\Admin';

    /**
     * 首页显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.admins.index', [
            'status' => Admin::getStatus()
        ]);
    }

    /**
     * 处理显示查询参数配置
     *
     * @param array $params
     * @return array
     */
    public function where($params)
    {
        return [
            'name' => 'like',
            'email' => '='
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
        $array = $request->input();
        if (!empty($array['password'])) {
            $array['password'] = bcrypt($array['password']);
        }

        $model->fill($array);
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
        $modelName = $this->model;
        $model = $modelName::find($id);
        if (!$model) return $this->error(1002);

        // 第三步：修改数据
        $array = $request->input();
        if (!empty($array['password'])) {
            $array['password'] = bcrypt($array['password']);
        } else {
            unset($array['password']);
        }

        $model->fill($array);
        if ($model->save()) {
            $this->handleJson($model);
        } else {
            $this->json['code'] = 1007;
        }

        return $this->returnJson();
    }
}
