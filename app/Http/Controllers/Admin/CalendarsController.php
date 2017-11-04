<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\Json;
use App\Models\Calender;
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
        return view('admin.calendars.index');
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

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
            $tmpArray = json_decode($value->style, true);
            if ($tmpArray) {
                foreach ($tmpArray as $key => $val) {
                    $value->$key = $val;
                }
            }

            $value->allDay = true;
        }

        return response()->json($all);
    }
}
