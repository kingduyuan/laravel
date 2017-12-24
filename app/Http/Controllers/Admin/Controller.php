<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Admin\Traits\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class Controller 后台基础控制器
 *
 * @package App\Http\Controllers\Admin
 */
class Controller extends \App\Http\Controllers\Controller
{
    /**
     * 引入json 处理
     */
    use Json;

    /**
     * @var string 定义使用model
     */
    protected $model = '';

    /**
     * 初始化配置使用中间件
     *
     * Controller constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * 处理查询配置信息
     *
     * @param array $params 查询参数
     * @return array
     */
    protected function where($params)
    {
        return [];
    }

    /**
     * 数据搜索处理
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // 查询的分页信息
        $start = $request->input('start');
        $length = $request->input('length');

        $orderBy = $request->input('order');
        $columns = $request->input('columns');

        // 处理排序
        $order = [];
        if ($orderBy) {
            foreach ($orderBy as $value) {
                $key = $value['column'];
                if (!empty($columns[$key]) && !empty($columns[$key]['data'])) {
                    $order[$columns[$key]['data']] = $value['dir'];
                }
            }
        }

        // 查询的参数
        $where = $request->input('where');
        parse_str($where, $array);

        $query = DB::table((new $this->model)->getTable());
        // 处查询条件
        Helper::handleWhere($query, $array, $this->where($array));
        $total = $query->count();

        // 排序
        foreach ($order as $key => $value) {
            $query->orderBy($key, $value);
        }

        // 返回结果
        return $this->returnJson([
            'draw' => $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $query->offset($start)->limit($length)->get(),
            'code' => 0,
            'sql' => $query->toSql()
        ]);
    }

    /**
     * 创建数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $model = $this->model;
        $array = $request->input();
        if ($calender = $model::create($array)) {
            $this->handleJson($calender, 0);
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
        $model = new $this->model;
        $id = $request->input($model->getKeyName());
        if (!$id) return $this->error();

        // 第二步: 查询数据是否存在
        $menu = $model::find($id);
        if (!$menu) return $this->error(1002);

        // 修改数据
        $menu->fill($request->input());
        if ($menu->save()) {
            $this->handleJson($menu);
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
        $model = new $this->model;
        $id = $request->input($model->getKeyName());
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
}