<?php
    use \App\Models\Menu;
    $menus = Menu::getPermissionMenus();
    $url = \Illuminate\Support\Facades\Route::current()->uri;
?>
<script>
    var currentUrl = "/{{ $url  }}";
</script>
<ul class="sidebar-menu" id="admin-menus">
    <li @if(in_array($url, ['admin/index', 'admin'])) class="active" @endif>
        <a href="{{ url('/admin/index') }}">
            <i class='fa fa-home'></i>
            <span>{{ trans('admin.home') }}</span>
        </a>
    </li>

    @foreach($menus as $value)
    <li class="@if($value['child']) treeview @endif" data-url="{{ $value['url'] }}" data-id="{{ $value['id'] }}">
        <a href="{{ url($value['url'])  }}">
            <i class="fa {{ $value['icon'] }}"></i>
            <span>{{ $value['name'] }}</span>
            @if($value['child'])
                <i class="fa fa-angle-left pull-right"></i>
            @endif
        </a>

        @if($value['child'])
            <ul class="treeview-menu">
            @foreach($value['child'] as $val)
                    <li data-url="{{ $val['url'] }}" data-id="{{ $val['id'] }}">
                        <a href="{{ url($val['url']) }}">
                            <i class="fa {{ $val['icon'] }}"></i>
                            <span>{{ $val['name'] }}</span>
                        </a>
                    </li>
            @endforeach
            </ul>
        @endif
    </li>
    @endforeach
</ul>