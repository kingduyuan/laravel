@extends("admin.layouts.admin")

@section('header_title', '角色信息')
@section('header_description', '分配权限')
<?php
$breadCrumb = [
    ['label' => '角色列表', 'url' => url('/admin/roles/index')],
    ['label' => '分配权限']
];
?>

@section("main-content")
    <div class="row">
        <form role="form" action="{{ url('/admin/roles/permissions', ['id' => $model->id]) }}" method="post">
            {{ csrf_field() }}
            <div class="col-md-3">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">角色信息</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-name"> 角色名称 </label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $model->name }}" id="input-name" placeholder="角色名称">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="input-description">角色说明</label>
                            <textarea name="description" class="form-control" id="input-description"
                                      placeholder="角色说明">{{ $model->description }}</textarea>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="input-display-name">显示名称</label>
                            <input type="text" name="display_name" class="form-control" id="input-display-name"
                                   value="{{ $model->display_name }}" placeholder="显示名称">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('display_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> 权限信息 </h3>
                    </div>
                    <div class="box-body">
                        @foreach($permissions as $value)
                            <label>
                                <input type="checkbox" name="permissions[]"
                                       @permission($value->name)
                                checked="checked"
                                @endpermission value="{{ $value->id }}">
                                {{ $value->description }} ({{ $value->name  }})
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/iCheck/all.css') }}">
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function(){
            $("input[type=checkbox]").iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        })
    </script>
@endpush