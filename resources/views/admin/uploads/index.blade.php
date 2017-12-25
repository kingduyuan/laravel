@extends("admin.layouts.admin")

@section('header_title', trans('admin.upload'))
@section('header_description', trans('admin.dropFileUpload'))
@section('header_right')
    <button id="addNewUploads" class="btn btn-info btn-sm pull-right"> {{ trans('admin.upload') }} </button>
@endsection

@section("main-content")
<div id="vue-app">
    <div class="box box-success">
        <div class="box-header with-border">
            {{ trans('admin.dropFileUploadList') }}
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
                <template v-for="item, k in list">
                    <template v-if="k % 4 === 4 || k % 4 === 0">
                        <div class="col-md-12" >
                    </template>
                    <div class="col-md-3">
                        <img class="img-responsive pad" :src="item.url" style="max-height: 300px;min-height: 250px"
                             alt="Photo">
                        <p>@{{ item.title }}</p>
                        <button type="button" class="btn btn-success btn-xs" @click="downloadValue(item)">
                            <i class="fa fa-cloud-download"></i> {{ trans('admin.download') }}
                        </button>
                        <button type="button" class="btn btn-info btn-xs" @click="updateValue(item, k)">
                            <i class="fa fa-pencil-square-o"></i> {{ trans('admin.update') }}
                        </button>
                        <button type="button" class="btn btn-danger btn-xs" @click="deleteValue(item)">
                            <i class="fa fa-trash-o"></i> {{ trans('admin.delete') }}
                        </button>
                        <span class="pull-right text-muted">@{{ item.create_time }}</span>
                    </div>
                    <template v-if="k%4 === 4 || k%4 === 0">
                        </div>
                    </template>
                </template>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update-upload-modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="model-title">{{ trans('admin.file') }}: @{{ form.title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <form v-show="isUpload" action="{{ url('/admin/uploads/upload') }}" class="dropzone" id="dropzone">
                                {{ csrf_field() }}
                                <div class="dz-message text-center">
                                    <i class="fa fa-cloud-upload"></i>
                                    <br>{{ trans('admin.dropFileUpload') }}
                                </div>
                            </form>
                            <div v-show="!isUpload" class="fileObject">
                                <img :src="form.url" class="img-responsive" id="upload-image" alt="">
                            </div>

                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <form action="{{ url('/admin/uploads/update') }}" id="update-form">
                                <input type="hidden" name="id" :value="form.id">
                                <div class="form-group">
                                    <label for="upload-name"> {{ trans('admin.fileName') }} </label>
                                    <input class="form-control" required="true" rangelength="[2,255]" :value="form.name" type="text" name="name" id="upload-name" placeholder="{{ trans('admin.fileName') }}" >
                                </div>
                                <div class="form-group">
                                    <label for="upload-url">{{ trans('admin.fileUrl') }}</label>
                                    <input class="form-control" type="text" :value="form.url" id="upload-url" placeholder="{{ trans('admin.fileUrl') }}"  readonly>
                                </div>
                                <div class="form-group">
                                    <label for="upload-title">{{ trans('admin.fileTitle') }}</label>
                                    <input class="form-control" required="true" rangelength="[2,255]" type="text" :value="form.title" name="title" id="upload-title" placeholder="{{ trans('admin.fileTitle') }}" >
                                </div>
                                <div class="form-group">
                                    <label>{{ trans('admin.filePublic') }} </label>
                                    <label>
                                        <input type="radio" name="public" value="1" v-model="form.public">
                                        {{ trans('admin.yes') }}
                                    </label>
                                    <label>
                                        <input type="radio" name="public" value="0" v-model="form.public">
                                        {{ trans('admin.no') }}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="update-upload-but">{{ trans('admin.update') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("style")
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/dropzone/dropzone.css') }}"/>
    <style>
        #dropzone {
            border: 2px dashed #0087F7;
            min-height: 100%;
        }
        .dropzone .dz-default.dz-message {
            background-image: none;
        }
    </style>
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="https://unpkg.com/vue"></script>
    <script>
        var defaultValue = {
            id: 0,
            title: "",
            name: "",
            url: "",
            public: 1
        };

        $(function () {
            // 显示图片
            var vueImage = new Vue({
                el: "#vue-app",
                data: {
                    list: [],
                    index: 0,
                    form: defaultValue,
                    isUpload: true
                },
                methods: {
                    downloadValue: function (value) {
                        window.location.href = '{{ url('admin/uploads/download')  }}?file=' + value.url;
                    },
                    updateValue: function (value, key) {
                        this.index = key;
                        this.form = value;
                        vueImage.isUpload = false;
                        $("#update-upload-modal").modal();
                    },
                    deleteValue: function (value) {
                        var self = this;
                        layer.confirm("{{ trans('admin.confirmFileDelete')  }}", {
                            title: "{{ trans('admin.remind')  }}",
                            icon: 0
                        }, function(index) {
                            layer.close(index);
                            for (var x in self.list) {
                                if (value.id === self.list[x]['id']) {
                                    ajax({
                                        url: "{{ url('admin/uploads/delete') }}",
                                        data: value,
                                        type: "post",
                                        dataType: "json"
                                    }).done(function(json) {
                                        if (json.code === 0) {
                                            self.list.splice(x, 1);
                                        }
                                    });

                                    break
                                }
                            }
                        })
                    }
                },

                created: function() {
                    var self = this;
                    ajax({
                        url: "{{ url('/admin/uploads/list')  }}",
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
            var dropzoneMain = new Dropzone("#dropzone", {
                maxFilesize: 1,
                acceptedFiles: "image/*,application/pdf",
                init: function () {
                    // 完成就删除
                    this.on("complete", function (file) {
                        this.removeFile(file);
                    });

                    // 成功处理
                    this.on("success", function (file, response) {
                        if (response.code === 0) {
                            vueImage.isUpload = false;
                            vueImage.form = response.data;
                            vueImage.list.push(response.data);
                            vueImage.index = vueImage.list.length - 1;
                        }
                    });
                }
            });

            // 上传图片
            $("#addNewUploads").on("click", function () {
                vueImage.isUpload = true;
                vueImage.form = defaultValue;
                $("#update-upload-modal").modal()
            });

            // 修改添加
            $("#update-upload-but").click(function(){
                var $fm = $("#update-form");
                if ($fm.validate().form()) {
                    getLaravelRequest({
                        url: "{{ url('/admin/uploads/update') }}",
                        data: $fm.serialize(),
                        dataType: "json",
                        type: "post"
                    }, "{{ trans('error.server') }}").done(function(json){
                        if (json.code === 0) {
                            vueImage.list.splice(vueImage.index, 1, json.data);
                            $("#update-upload-modal").modal("hide")
                        } else {
                            layer.msg(json.message, {icon: 5})
                        }
                    });
                }

                return false;
            })
        });
    </script>
@endpush