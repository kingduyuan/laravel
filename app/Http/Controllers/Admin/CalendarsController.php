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
     * 创建数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $array = $request->input();
        unset($array['actionType'], $array['id']);
        if (!empty($array['style'])) $array['style'] = Calendar::style($array['style']);
        $array['created_id'] = $array['updated_id'] = 1;
        if ($calender = Calendar::create($array)) {
            return $this->success($calender);
        } else {
            return $this->error(1005);
        }
    }

    /**
     * 修改事件信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $id = (int)$request->input('id');
        if ($id <= 0) {
            return $this->error();
        }

        $calendar = Calendar::find($id);
        if (empty($calendar)) {
            return $this->error(1002);
        }

        $array = $request->input();
        unset($array['actionType']);
        if (!empty($array['style'])) $array['style'] = Calendar::style($array['style']);
        $calendar->fill($array);
        if ($calendar->save()) {
            return $this->success($calendar);
        } else {
            return $this->error(1007);
        }
    }

    /**
     * 我的日程管理显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function self()
    {
        // 默认状态信息
        $status = Calendar::getStatus();
        $timeStatus = Calendar::getTimeStatus();
        $colors = Calendar::$arrColor;

        // 查询数据
        $all = DB::table('calendars')->where('status', '=', 0)
            ->orderBy('id', 'desc')->get();
        foreach ($all as &$value) {
            Calendar::handleStyle($value);
        }

        // 载入视图
        return view('admin.calendars.self', [
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
//            $value->allDay = true;
        }

        return response()->json($all);
    }
}
