<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenusController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $model = '\App\Models\Menu';

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
     * 处理查询参数配置
     *
     * @param array $params
     * @return array
     */
    public function where($params)
    {
        return [
            'name' => 'like',
            'url' => 'like',
            'status' => 'in',
        ];
    }
}
