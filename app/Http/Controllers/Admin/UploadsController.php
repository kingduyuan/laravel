<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUpload;
use App\Models\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\Traits\Json;

/**
 * Class UploadsController
 * 文件上传处理
 *
 * @package App\Http\Controllers\Admin
 */
class UploadsController extends Controller
{
    use Json;

    /**
     * 首页显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.uploads.index');
    }

    /**
     * 获取列表信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $array = Upload::all();
        $this->handleJson($array);
        return $this->returnJson();
    }

    /**
     * 文件上传 Upload files via DropZone.js
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('post')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                // 上传文件
                $url = $file->store(date('Ymd'));
                if ($url) {
                    // 新增数据
                    $insert = [
                        'name' => $file->getClientOriginalName(),
                        'url' => Storage::url($url),
                        'path' => $url,
                        'title' => '',
                        'extension' => $file->getClientOriginalExtension(),
                        'public' => 1
                    ];
                    if ($upload = Upload::create($insert)) {
                        $this->handleJson($upload);
                    } else {
                        $this->json['code'] = 1005;
                    }
                } else {
                    $this->json['code'] = 1004;
                }

            } else {
                $this->json['code'] = 1001;
            }
        }

        return $this->returnJson();
    }

    /**
     * 删除图片信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $upload = Upload::find($request->input('id'));
        if ($upload) {
            if ($upload->delete()) {
                Storage::delete($upload->path);
                $this->handleJson($upload);
            } else {
                $this->json['code'] = 1003;
            }
        } else {
            $this->json['code'] = 1002;
        }

        return $this->returnJson();
    }

    /**
     * 修改图片上传信息
     *
     * @param StoreUpload $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpload $request)
    {
        /* @var $upload Upload */
        $upload = Upload::find($request->input('id'));
        if ($upload) {
            $upload->fill($request->input());
            if ($upload->save()) {
                $this->handleJson($upload);
            } else {
                $this->json['code'] = 1003;
            }
        } else {
            $this->json['code'] = 1002;
        }
        return $this->returnJson();
    }

    /**
     * 文件下载
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        return response()->download('.' . trim($request->input('file'), '.'));
    }
}
