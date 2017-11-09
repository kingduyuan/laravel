<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\Json;
use App\Http\Requests\DataTable;
use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CalendarsController extends Controller
{
    use Json;

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
     * 数据搜索处理
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        $where = $request->input('where');
        parse_str($where, $array);
        $query = Calendar::where('status', '!=', -1);
        $total = $query->count();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $query->offset($start)->limit($length)->get(),
            'other' => $array,
            'sql' => $query->toSql()
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
        $id = (int)$request->input('id');
        if ($id) {
            $calendar = Calendar::find($id);
            if ($calendar) {
                $array = $request->input();
                unset($array['actionType']);
                if (!empty($array['style'])) $array['style'] = Calendar::style($array['style']);
                $calendar->fill($array);
                if ($calendar->save()) {
                    $this->handleJson($calendar);
                } else {
                    $this->json['code'] = 1007;
                }
            } else {
                $this->json['code'] = 1002;
            }
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
        $id = (int)$request->input('id');
        if ($id) {
            if (Calendar::destroy($id)) {
                $this->handleJson([]);
            } else {
                $this->json['code'] = 1006;
            }
        }

        return $this->returnJson();
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
