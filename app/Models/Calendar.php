<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    // 状态信息
    const STATUS_PENDING = 0;  // 待处理
    const STATUS_DELEGATE = 1;  // 委派处理
    const STATUS_COMPLETE = 2;  // 处理完成
    const STATUS_DEFER = 3;  // 延期处理

    // 时间状态
    const TIME_STATUS_SLOW = 0; // 缓慢
    const TIME_STATUS_NORMAL = 1; // 正常
    const TIME_STATUS_URGENT = 2; // 紧急

    /**
     * @var array 定义显示背景信息
     */
    public static $arrColor = [
        'rgb(72, 176, 247)',
        'rgb(57, 204, 204)',
        'rgb(243, 156, 18)',
        'rgb(255, 133, 27)',
        'rgb(16, 207, 189)',
        'rgb(1, 255, 112)',
        'rgb(245, 87, 83)',
        'rgb(96, 92, 168)',
        'rgb(240, 18, 190)',
        'rgb(119, 119, 119)',
        'rgb(0, 31, 63)',
    ];

    /**
     * @var string 定义表名字
     */
    protected $table = 'calendars';

    /**
     * @var array 批量赋值的黑名单
     */
    protected $guarded = [];

    /**
     * getStatus() 获取状态信息
     * @param null $intStatus 状态值
     * @return array|mixed
     */
    public static function getStatus($intStatus = null)
    {
        $arrReturn = [
            self::STATUS_DELEGATE => '委派处理',
            self::STATUS_PENDING => '待处理',
            self::STATUS_COMPLETE => '处理完成',
            self::STATUS_DEFER => '延期处理'
        ];

        if ($intStatus != null && isset($arrReturn[$intStatus])) {
            $arrReturn = $arrReturn[$intStatus];
        }

        return $arrReturn;
    }

    /**
     * getTimeStatus() 获取时间状态信息
     * @param null $intStatus 状态值
     * @return array|mixed
     */
    public static function getTimeStatus($intStatus = null)
    {
        $arrReturn = [
            self::TIME_STATUS_SLOW => '缓慢',
            self::TIME_STATUS_NORMAL => '正常',
            self::TIME_STATUS_URGENT => '紧急',
        ];

        if ($intStatus != null && isset($arrReturn[$intStatus])) {
            $arrReturn = $arrReturn[$intStatus];
        }

        return $arrReturn;
    }

    /**
     * 样式处理
     *
     * @param string $style 样式
     * @return string
     */
    public static function style($style)
    {
        return json_encode([
            'backgroundColor' => $style,
            'borderColor' => $style,
        ], 320);
    }

    /**
     * 处理style
     *
     * @param $object
     */
    public static function handleStyle($object)
    {
        $style = json_decode($object->style, true);
        if ($style) {
            foreach ($style as $k => $v) {
                $object->$k = $v;
            }
        }
    }
}
