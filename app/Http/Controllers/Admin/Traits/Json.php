<?php

namespace App\Http\Controllers\Admin\Traits;

/**
 * Class Json 数据返回
 *
 * @package App\Http\Controllers\Admin\Json
 */
trait Json
{
    /**
     * @var array json 数据
     */
    public $json = [
        'code' => 1000,
        'status' => 'fail',
        'message' => '',
        'data' => '',
    ];

    /**
     * 处理返回数据
     *
     * @param mixed $data 相应处理数据
     * @param int $code 错误码 0 => success
     * @param string $message
     */
    public function handleJson($data, $code = 0, $message = '')
    {
        $this->json['data'] = $data;
        $this->json['code'] = $code;
        $this->json['message'] = $message;
    }

    /**
     * 返回 json 数据信息
     * @param array $params 返回数据信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnJson($params = [])
    {
        // 相应数据
        if ($params) $this->json = array_merge($this->json, $params);

        // 处理错误信息
        if (empty($this->json['message'])) {
            $this->json['message'] = trans('error.'.$this->json['code']);
        }

        // 处理成功返回状态
        if (empty($this->json['code'])) $this->json['status'] = 'success';

        return response()->json($this->json, 200, [], 320);
    }
}