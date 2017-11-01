<?php

namespace App\Http\Controllers\Admin;

/**
 * Class IndexController
 * @package app\Http\Admin
 */
class IndexController
{
    public function index()
    {
        return view('admin.index.index', [
            'username' => 123,
        ]);
    }
}