<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\Json;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarsController extends Controller
{
    /**
     * @var string 定义使用的model
     */
    public $model = '\App\Models\Calendar';

    /**
     * 处理显示查询参数配置
     *
     * @param array $params
     * @return array
     */
    public function where($params)
    {
        return [
            'desc' => 'like',
            'title' => 'like'
        ];
    }

    /**
     * 首页显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // 默认状态信息
        $status = Calendar::getStatus();
        $timeStatus = Calendar::getTimeStatus();
        $colors = Calendar::$arrColor;

        // 载入视图
        return view('admin.calendars.index', [
            'status' => $status,
            'timeStatus' => $timeStatus,
            'colors' => $colors,
        ]);
    }

    /**
     * 我的日程管理显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function me()
    {
        // 默认状态信息
        $status = Calendar::getStatus();
        $timeStatus = Calendar::getTimeStatus();
        $colors = Calendar::$arrColor;

        // 查询数据
        $all = DB::table('calendars')->where('status', '=', 0)->orderBy('id', 'desc')->get();
        foreach ($all as &$value) {
            Calendar::handleStyle($value);
            $value->allDay = true;
        }

        // 载入视图
        return view('admin.calendars.me', [
            'status' => $status,
            'timeStatus' => $timeStatus,
            'colors' => $colors,
            'calendars' => $all
        ]);
    }

    /**
     * 查找我的日程事件信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function events(Request $request)
    {
        // 查询的时间
        $start = $request->input('start');
        $end = $request->input('end');

        // 查询数据
        $all = DB::table('calendars')->where([
            ['created_id', '=', 1],
            ['start', '>=', $start],
            ['end', '<=', $end . ' 23:59:59']
        ])->get();

        foreach ($all as &$value) {
            Calendar::handleStyle($value);
            $value->allDay = true;
        }

        return response()->json($all);
    }
}
