@extends("admin.layouts.admin")

@section('header_title', '上传')
@section('header_description', '上传图片和文件')
@section('header_right')
    <button id="addNewUploads" class="btn btn-success btn-sm pull-right"> 上传</button>
@endsection

@section("main-content")
    <form action="{{ url('/admin/file/upload') }}" id="fm_dropzone_main" enctype="multipart/form-data" method="POST"
          class="hide">
        {{ csrf_field() }}
        <a id="closeDZ1"><i class="fa fa-times"></i></a>
        <div class="dz-message">
            <i class="fa fa-cloud-upload"></i>
            <br>{{ trans('admin.dropFileUpload') }}
        </div>
    </form>

    <div class="box box-success">
        <div class="box-header with-border">
            上传文件列表
            <!-- /.user-block -->
            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row" id="image-lists">
                <div class="col-md-3" v-for="item in list" key="item.id">
                    <img class="img-responsive pad" :src="item.url" style="max-height: 300px;min-height: 250px"
                         alt="Photo">
                    <p>@{{ item.name }}</p>
                    <button type="button" class="btn btn-success btn-xs" @click="downloadValue(item)">
                        <i class="fa fa-cloud-download"></i> 下载
                    </button>
                    <button type="button" class="btn btn-info btn-xs" @click="updateValue(item)">
                        <i class="fa fa-pencil-square-o"></i> 修改
                    </button>
                    <button type="button" class="btn btn-danger btn-xs" @click="deleteValue(item)">
                        <i class="fa fa-trash-o"></i> 删除
                    </button>
                    <span class="pull-right text-muted">@{{ item.create_time }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="EditFileModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-times"></i></button>
                    <h4 class="modal-title" id="myModalLabel">File: </h4>
                </div>
                <div class="modal-body p0">
                    <div class="row m0">
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div class="fileObject">

                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <input type="hidden" name="file_id" value="0">
                            <div class="form-group">
                                <label for="filename">File Name</label>
                                <input class="form-control" placeholder="File Name" name="filename" type="text" readonly
                                       value="">
                            </div>
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input class="form-control" placeholder="URL" name="url" type="text" readonly value="">
                            </div>
                            <div class="form-group">
                                <label for="caption">Label</label>
                                <input class="form-control" placeholder="Caption" name="caption" type="text" value=""
                                       readonly>
                            </div>
                            <div class="form-group">
                                <label for="public">Is Public ?</label>
                                <div class="Switch Ajax Round On" style="vertical-align:top;margin-left:10px;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success" id="downFileBtn" href="">Download</a>
                    <button type="button" class="btn btn-danger" id="delFileBtn">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('admin-assets/plugins/dropzone/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vue/vue.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
            }
        });

        $(function () {
            // 显示图片
            var vueImage = new Vue({
                el: "#image-lists",
                data: {
                    list: []
                },
                methods: {
                    downloadValue: function (value) {
                        window.location.href = '{{ url('admin/file/download')  }}?file=' + value.url;
                    },
                    updateValue: function (value) {

                    },
                    deleteValue: function (value) {
                        var self = this;
                        for (var x in this.list) {
                            if (value.id === this.list[x]['id']) {
                                $.ajax({
                                    url: "{{ url('admin/file/delete') }}",
                                    data: value,
                                    type: "post",
                                    dataType: "json"
                                }).done(function(json) {
                                    if (json.code === 0) {
                                        self.list.splice(x, 1);
                                    }
                                }).fail(function(){
                                    alert("服务器繁忙,请稍候再试...")
                                });

                                break
                            }
                        }
                    }
                },

                created: function() {
                    var self = this;
                    $.ajax({
                        url: "{{ url('/admin/file/list')  }}",
                        type: "get",
                        dataType: "json"
                    }).done(function(json){
                        if (json.code === 0) {
                            self.list = json.data;
                        }
                    });
                }
            });

            // 上传图片
            var dropzoneMain = new Dropzone("#fm_dropzone_main", {
                maxFilesize: 2,
                acceptedFiles: "image/*,application/pdf",
                init: function () {
                    this.on("complete", function (file) {
                        this.removeFile(file);
                    });
                    this.on("success", function (file, response) {
                        console.info(response);
                        if (response.code === 0) {
                            vueImage.list.push(response.data);
                        }
                    });
                }
            });

            // 显示和隐藏
            var $dropFrom = $("#fm_dropzone_main");
            $dropFrom.slideUp();
            $("#addNewUploads").on("click", function () {
                $dropFrom.slideDown(1000, function () {
                    $(this).removeClass("hide");
                });
            });
            $("#closeDZ1").on("click", function () {
                $dropFrom.slideUp();
            });
        });
    </script>
@endpush