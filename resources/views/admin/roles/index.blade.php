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

    <!--隐藏的编辑表单-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> 编辑角色信息 </h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="updateForm" class="form-horizontal" name="updateForm" action="update">
                        <input type="hidden" name="id" value=""/>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-name"> 角色名称 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-name" required="true" rangelength="[2, 50]"
                                           name="name" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-url"> 角色说明 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-url" required="true" rangelength="[1, 255]"
                                           name="description" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-icon"> 显示名称 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-icon" required="true" value="fa-cube"
                                           rangelength="[2, 255]"
                                           name="display_name" class="form-control"/>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary btn-image" id="updateFormSubmit">确定</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/css/dataTables.bootstrap.min.css') }}"/>
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/select2/select2.min.js') }}"></script>
    <!-- Page specific script -->
    <script>
        function handleOperator(td, data, rowData, row)
        {
            var html = "<button class='btn btn-info btn-xs table-update' data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"><i class='fa fa-edit'></i></button> ";
            html += "<button class='btn btn-danger btn-xs table-delete' data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"><i class='fa fa-trash'></i></button> ";
            html += "<a class='btn btn-info btn-xs' href=\"{{ url('admin/roles/permissions') }}/" + rowData["id"] + "\" data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"><i class='fa fa-leaf'></i> 分配角色</a> ";
            $(td).html(html);
        }

        $(function () {
            var meTable = $('#example2').DataTable({
                'paging': true,
//                'lengthChange': false,
                "lengthMenu": [15, 30, 50, 100],
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ url('/admin/roles/search') }}",
                    data: function (d) {
                        d.where = $("#searchForm").serialize();
                        return d;
                    }
                },
                language: jqueryDataTableLanguage,
                columns: [
                    {"title": "id", "data": "id"},
                    {"title": "名称", "data": "name", "orderable": false},
                    {"title": "说明", "data": "description", "orderable": false},
                    {"title": "显示名称", "data": "display_name", "name": "display_name", "orderable": false},
                    {"title": "创建时间", "data": "created_at"},
                    {"title": "修改时间", "data": "updated_at"},
                    {
                        "title": "操作", "data": null, "orderable": false,
                        "createdCell": handleOperator
                    }
                ]
            });

            // 表单搜索
            $("#searchForm").submit(function (e) {
                e.preventDefault();
                meTable.ajax.reload();
                return false;
            });

            // 表单编辑
            $(document).on("click", "button.table-update", function(e){
                e.preventDefault();
                var id = $(this).attr("data-index"), row = $(this).attr("data-row");
                initForm("#updateForm", meTable.data()[row]);
                $("#updateForm").prop("action", "{{ url('/admin/roles/update') }}");
                $("#updateModal").modal();
            });

            // 数据删除
            $(document).on("click", "button.table-delete", function(e) {
                e.preventDefault();
                var row = $(this).attr("data-row"), data = meTable.data()[row];
                layer.confirm("您确定需要删除这条数据吗?", {icon: 5, "title": "温馨提醒"}, function() {
                    getLaravelRequest({
                        url: "{{ url('/admin/permissions/delete') }}",
                        data: data,
                        dataType: "json",
                        type: "POST"
                    }).done(function (json) {
                        layer.msg(json.message, {icon: json.code === 0 ? 6 : 5, time: 500});
                        if (json.code === 0) {
                            meTable.ajax.reload();
                        }
                    });
                });
            });

            // 表单新增
            $("#create").click(function(e){
                e.preventDefault();
                initForm("#updateForm", null);
                $("#updateForm").prop("action", "{{ url('/admin/roles/create') }}");
                $("#updateModal").modal();
            });

            // 表单编辑
            $("#updateFormSubmit").click(function(e){
                e.preventDefault();
                var $fm = $("#updateForm");
                if ($fm.validate().form()) {
                    getLaravelRequest({
                        url: $fm.prop("action"),
                        data: $fm.serialize(),
                        dataType: "json",
                        type: "POST"
                    }).done(function(json){
                        layer.msg(json.message, {icon: json.code === 0 ? 6 : 5, time: 500});
                        if (json.code === 0) {
                            $("#updateModal").modal("hide");
                            meTable.ajax.reload();
                        }
                    });
                }

                return false;
            });
        })
    </script>
@endpush