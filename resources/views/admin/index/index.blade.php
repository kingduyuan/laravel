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

    <div class="modal fade" id="update-upload-modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form action="{{ url('/admin/file/upload') }}" method="post" id="update-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                        <h4 class="modal-title" id="model-title">{{ trans('admin.file') }}: </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="fileObject"></div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <input type="hidden" name="id" id="upload-id" value="">
                                <div class="form-group">
                                    <label for="upload-name"> {{ trans('admin.fileName') }} </label>
                                    <input class="form-control" type="text" name="name" id="upload-name" placeholder="{{ trans('admin.fileName') }}" >
                                </div>
                                <div class="form-group">
                                    <label for="upload-url">{{ trans('admin.fileUrl') }}</label>
                                    <input class="form-control" type="text" id="upload-url" placeholder="{{ trans('admin.fileUrl') }}"  readonly>
                                </div>
                                <div class="form-group">
                                    <label for="upload-title">{{ trans('admin.fileTitle') }}</label>
                                    <input class="form-control" type="text" name="title" id="upload-title" placeholder="{{ trans('admin.fileTitle') }}" >
                                </div>
                                <div class="form-group">
                                    <label for="public"> {{ trans('admin.filePublic') }} </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info" id="update-upload-but">{{ trans('admin.update') }}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('admin-assets/plugins/dropzone/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vue/vue.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
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
                        $("#upload-id").val(value.id);
                        $("#upload-title").val(value.title);
                        $("#upload-name").val(value.name);
                        $("#upload-url").val(value.url);
                        $("#modal-title").val("{{ trans('admin.file') }}: " + value.title);
                        $("#update-upload-modal").modal();
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

            // 修改添加
            $("#update-form").submit(function(){
                var l = layer.load();
                $.ajax({
                    url: "{{ url('/admin/file/update') }}",
                    data: $(this).serialize(),
                    dataType: "json",
                    type: "post"
                }).done(function(json){

                }).fail(function(response){
                    var html = '';
                    if (response.responseJSON) {
                        html += response.responseJSON.message+ " <br/>";
                        for (var i in response.responseJSON.errors) {
                            html += response.responseJSON.errors[i].join(";") + "<br/>";
                        }
                    } else {
                        html = "服务器繁忙,请稍候再试...";
                    }

                    layer.msg(html, {icon: 5})
                }).always(function(){
                    layer.close(l);
                });

                return false;
            })
        });
    </script>
@endpush