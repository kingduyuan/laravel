@extends("admin.layouts.admin")

@section('header_title', '角色信息')
@section('header_description', '角色列表')
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
                            <form class="form-inline" id="searchForm" name="searchForm">
                                <div class="form-group">
                                    <label for="inputSearchName">角色名称</label>
                                    <input type="text" name="name" class="form-control" id="inputSearchName"
                                           placeholder="名称">
                                </div>
                                <div class="form-group">
                                    <label for="inputSearchUrl">角色说明</label>
                                    <input type="text" name="description" class="form-control" id="inputSearchUrl"
                                           placeholder="说明">
                                </div>
                                <div class="form-group">
                                    <label for="inputSearchPermissionName"> 显示名称</label>
                                    <input type="text" name="display_name" class="form-control"
                                           id="inputSearchPermissionName" placeholder="显示名称">
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
    <script src="{{ asset('admin-assets/plugins/table/table.js') }}"></script>
    <!-- Page specific script -->
    <script>
        function handleOperator(td, data, rowData, row) {
            var attr = "data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"";
            var html = "<button class='btn btn-info btn-xs example2-update' " + attr + " ><i class='fa fa-edit'></i></button> ";
            html += "<button class='btn btn-danger btn-xs example2-delete' " + attr + "><i class='fa fa-trash'></i></button> ";
            html += "<a class=\"btn btn-info btn-xs\" href=\"{{ url('admin/roles/permissions') }}/" + rowData["id"] + "\"><i class='fa fa-leaf'></i> 分配角色</a> ";
            $(td).html(html);
        }

        $(function () {
            var meTable = meTables({
                "sTable": "#example2",
                "table": {
                    dom: "t<'row'<'table-page col-sm-4'li><'col-sm-8'p>>",
                    columns: [
                        {"title": "id", "data": "id", "edit": {"type": "hidden"}, "defaultOrder": "asc"},
                        {
                            "title": "角色名称", "data": "name", "orderable": false, "edit": {
                                "required": true, "rangelength": "[2, 190]"
                            }
                        },
                        {
                            "title": "角色说明", "data": "description", "orderable": false, "edit": {
                                "required": true, "rangelength": "[2, 190]"
                            }
                        },
                        {
                            "title": "显示名称",
                            "data": "display_name",
                            "orderable": false,
                            "edit": {
                                "required": true, "rangelength": "[2, 190]"
                            }
                        },
                        {"title": "创建时间", "data": "created_at"},
                        {"title": "修改时间", "data": "updated_at"},
                        {
                            "title": "操作", "data": null, "orderable": false,
                            "createdCell": handleOperator
                        }
                    ]
                }
            });


            // 表单新增
            $("#create").click(function (e) {
                e.preventDefault();
                meTable.create();
            });
        })
    </script>
@endpush