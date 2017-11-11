<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Admin\Traits\Json;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenusController extends Controller
{
    use Json;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * 首页显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 默认状态信息
        $status = Menu::getStatus();

        // 查询父类等级
        $parents = DB::table('menus')->where([
            ['status', '!=', Menu::STATUS_DELETE], 
            ['parent', '=', 0]
        ])->pluck('name', 'id');

        // 载入视图
        return view('admin.menus.index', [
            'status' => $status,
            'parents' => $parents
        ]);
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
                if (isset($columns[$key])) {
                    $order[$columns[$key]['data']] = $value['dir'];
                }
            }
        }

        // 查询的参数
        $where = $request->input('where');
        parse_str($where, $array);

        $query = DB::table('menus');

        // 处查询条件
        Helper::handleWhere($query, $array, [
            'name' => 'like',
            'url' => 'like',
            'status' => 'in',
        ]);

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
        $array = $request->input();
        if ($calender = Menu::create($array)) {
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
        $id = (int)$request->input('id');
        if (!$id) return $this->error();

        // 第二步: 查询数据是否存在
        /* @var $menu \App\Models\Menu */
        $menu = Menu::find($id);
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
        $id = (int)$request->input('id');
        if (!$id) return $this->error();

        // 第二步：删除数据
        if (Menu::destroy($id)) {
            $this->handleJson([]);
        } else {
            $this->json['code'] = 1006;
        }

        return $this->returnJson();
    }
}
