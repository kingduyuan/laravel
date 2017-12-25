@extends("admin.layouts.admin")

@section('header_title', '导航管理')
@section('header_description', '导航栏目列表')
@section('header_right')
    <button id="create" class="btn btn-success btn-sm pull-right"> {{ trans('admin.create') }} </button>
@endsection

@section("main-content")
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12" style="margin-bottom: 20px;">
                        <form class="form-inline" id="search-form" name="searchForm">
                            <div class="form-group">
                                <label class="sr-only" for="inputSearchName">名称</label>
                                <input type="text" name="name" class="form-control" id="inputSearchName"
                                       placeholder="导航名称">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="inputSearchUrl">地址</label>
                                <input type="text" name="url" class="form-control" id="inputSearchUrl"
                                       placeholder="导航地址">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="inputSearchPermissionName">权限名称</label>
                                <input type="text" name="permission_name" class="form-control"
                                       id="inputSearchPermissionName" placeholder="权限名称">
                            </div>
                            <div class="form-group" style="min-width:200px;">
                                <select class="form-control select2 pull-left" name="status[]" multiple="multiple"
                                        id="inputSearchStatus" data-placeholder="选择状态" style="width: 100%;">
                                    @foreach($status as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>搜索</button>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover"></table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin-assets/plugins/select2/select2.min.css') }}"/>
    <style>
        div.table-page div {
            float: left;
        }

        div.dataTables_length {
            margin-right: 5px;
            line-height: 35px;
        }
    </style>
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/table/table.js') }}"></script>
    <!-- Page specific script -->
    <script>
        function handleOperator(td, data, rowData, row)
        {
            var attr = "data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"";
            var html = "<button class='btn btn-success btn-xs example2-detail' " + attr + ">\
            <i class='fa fa-search'></i></button> ";
            html += "<button class='btn btn-info btn-xs example2-update' " + attr + ">\
            <i class='fa fa-edit'></i></button> ";
            html += "<button class='btn btn-danger btn-xs example2-delete' " + attr + ">\
            <i class='fa fa-trash'></i></button> ";
            $(td).html(html);
        }

        $(function () {
            var arrParents = @json($parents, 320),
                arrStatus = @json($status, 320),
                arrColors = {"10": "label-success", "0": "label-warning", "-1": "label-danger"},
                table = meTables({
                    "sTable": "#example2",
                    "title": "导航栏目",
                    "table": {
                        dom: "t<'row'<'table-page col-sm-4'li><'col-sm-8'p>>",
                        columns: [
                            {"title": "id", "data": "id", "edit": {type: "hidden"}, "defaultOrder": "asc"},
                            {
                                "title": "名称", "data": "name", "orderable": false,
                                "edit": {required: "true", rangelength: "[2, 50]"}
                            },
                            {
                                "title": "地址", "data": "url", "orderable": false,
                                "edit": {required:"true", rangelength: "[1, 255]"}
                            },
                            {
                                "title": "图标", "data": "icon", "orderable": false, "render": function (data) {
                                    return data ? "<i class=\"fa " + data + "\"></i>" : data;
                                },
                                "edit": {value: "fa-cube", required:"true", rangelength: "[2, 255]"}
                            },
                            {
                                "title": "父级名称", "data": "parent", "render": function (data) {
                                    return arrParents[data] ? arrParents[data] : "顶级分类";
                                },
                                value: @json($parents, 320),
                                "edit": {"type": "select", "number": true}
                            },
                            {
                                "title": "状态", "data": "status", "render": function (data) {
                                    return '<span class="label ' + getValue(arrColors, data, 'label-info') + '">' + getValue(arrStatus, data, data) + '</span>';
                                },
                                value: @json($status, 320),
                                "edit": {"type": "radio", "number": true, "default": 10, "required": true}
                            },
                            {"title": "排序", "data": "sort", "name": "sort",
                                "edit": {"number": true, value: 100}
                            },
                            {"title": "创建时间", "data": "created_at"},
                            {"title": "修改时间", "data": "updated_at"},
                            {
                                "title": "操作",
                                "data": null,
                                "orderable": false,
                                "createdCell": handleOperator
                            }
                        ]
                    }
                });

            $(".select2").select2();

            $("#create").click(function () {
                table.create();
            });
        })
    </script>
@endpush