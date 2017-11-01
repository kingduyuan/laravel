@extends("admin.layouts.admin")

@section('header_title', '上传')
@section('header_description', '上传图片和文件')
@section('header_right')
    <button id="addNewUploads" class="btn btn-success btn-sm pull-right"> 上传 </button>
@endsection

@section("main-content")
    <form action="{{ url('/admin/upload') }}" id="fm_dropzone_main" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <a id="closeDZ1"><i class="fa fa-times"></i></a>
        <div class="dz-message">
            <i class="fa fa-cloud-upload"></i>
            <br>{{ trans('admin.dropFileUpload') }}
        </div>
    </form>

    <div class="modal fade" id="EditFileModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
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
                                <input class="form-control" placeholder="File Name" name="filename" type="text"  readonly  value="">
                            </div>
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input class="form-control" placeholder="URL" name="url" type="text" readonly value="">
                            </div>
                            <div class="form-group">
                                <label for="caption">Label</label>
                                <input class="form-control" placeholder="Caption" name="caption" type="text" value=""  readonly>
                            </div>
                            <div class="form-group">
                                <label for="public">Is Public ?</label>
                                <div class="Switch Ajax Round On" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
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

    <div class="modal fade" id="fm" role="dialog" aria-labelledby="fileManagerLabel">
        <input type="hidden" id="image_selecter_origin" value="">
        <input type="hidden" id="image_selecter_origin_type" value="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="fileManagerLabel">Select File</h4>
                </div>
                <div class="modal-body p0">
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="fm_folder_selector">
                                <form action="{{url('admin/upload')}}" id="dropzone" enctype="multipart/form-data" method="POST">
                                    {{ csrf_token() }}
                                    <div class="dz-message">
                                        <i class="fa fa-cloud-upload"></i>
                                        <br>{{ trans('admin.dropFileUpload') }}
                                    </div>

                                    <label class="fm_folder_title">Is Public ?</label>
                                    <input name="public" type="checkbox" value="public">
                                    <div class="Switch Ajax Round On">
                                        <div class="Toggle"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 pl0">
                            <div class="nav">
                                <div class="row">
                                    <div class="col-xs-2 col-sm-7 col-md-7"></div>
                                    <div class="col-xs-10 col-sm-5 col-md-5">
                                        <input type="search" class="form-control pull-right" placeholder="Search file name">
                                    </div>
                                </div>
                            </div>
                            <div class="fm_file_selector">
                                <ul>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript" src="{{ asset('admin-assets/plugins/dropzone/dropzone.js') }}"></script>
    <script>

        $(function () {
            var dropzoneMain = new Dropzone("#dropzone-main", {
                maxFilesize: 2,
                acceptedFiles: "image/*,application/pdf",
                init: function() {
                    this.on("complete", function(file) {
                        this.removeFile(file);
                    });
                    this.on("success", function(file) {
                        loadUploadedFiles();
                    });
                }
            });

            var $dropFrom = $();

            $("#fm_dropzone_main").slideUp();
            $("#AddNewUploads").on("click", function() {
                $("#fm_dropzone_main").slideDown();
            });
            $("#closeDZ1").on("click", function() {
                $("#fm_dropzone_main").slideUp();
            });


            $("body").on("click", "ul.files_container .fm_file_sel", function() {
                var upload = $(this).attr("upload");
                upload = JSON.parse(upload);

                $("#EditFileModal .modal-title").html("File: "+upload.name);
                $(".file-info-form input[name=file_id]").val(upload.id);
                $(".file-info-form input[name=filename]").val(upload.name);
                $(".file-info-form input[name=url]").val(bsurl+'/files/'+upload.hash+'/'+upload.name);
                $(".file-info-form input[name=caption]").val(upload.caption);
                $("#EditFileModal #downFileBtn").attr("href", bsurl+'/files/'+upload.hash+'/'+upload.name+"?download");


                if(upload.public == "1") {
                    $(".file-info-form input[name=public]").attr("checked", !0);
                    $(".file-info-form input[name=public]").next().removeClass("On").addClass("Off");
                } else {
                    $(".file-info-form input[name=public]").attr("checked", !1);
                    $(".file-info-form input[name=public]").next().removeClass("Off").addClass("On");
                }


                $("#EditFileModal .fileObject").empty();
                if($.inArray(upload.extension, ["jpg", "jpeg", "png", "gif", "bmp"]) > -1) {
                    $("#EditFileModal .fileObject").append('<img src="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'">');
                    $("#EditFileModal .fileObject").css("padding", "15px 0px");
                } else {
                    switch (upload.extension) {
                        case "pdf":
                            // TODO: Object PDF
                            $("#EditFileModal .fileObject").append('<object width="100%" height="325" data="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'"></object>');
                            $("#EditFileModal .fileObject").css("padding", "0px");
                            break;
                        default:
                            $("#EditFileModal .fileObject").append('<i class="fa fa-file-text-o"></i>');
                            $("#EditFileModal .fileObject").css("padding", "15px 0px");
                            break;
                    }
                }
                $("#EditFileModal").modal('show');
            });
            $('#EditFileModal .Switch.Ajax').click(function() {
                $.ajax({
                    url: "{{ url(config('laraadmin.adminRoute') . '/uploads_update_public') }}",
                    method: 'POST',
                    data: $("form.file-info-form").serialize(),
                    success: function( data ) {
                        console.log(data);
                        loadUploadedFiles();
                    }
                });

            });

            $(".file-info-form input[name=caption]").on("blur", function() {
                // TODO: Update Caption
                $.ajax({
                    url: "{{ url(config('laraadmin.adminRoute') . '/uploads_update_caption') }}",
                    method: 'POST',
                    data: $("form.file-info-form").serialize(),
                    success: function( data ) {
                        console.log(data);
                        loadUploadedFiles();
                    }
                });
            });

            @if(config('laraadmin.uploads.allow_filename_change') && Module::hasFieldAccess("Uploads", "name", "write"))
            $(".file-info-form input[name=filename]").on("blur", function() {
                // TODO: Change Filename
                $.ajax({
                    url: "{{ url(config('laraadmin.adminRoute') . '/uploads_update_filename') }}",
                    method: 'POST',
                    data: $("form.file-info-form").serialize(),
                    success: function( data ) {
                        console.log(data);
                        loadUploadedFiles();
                    }
                });
            });
            @endif

            $("#EditFileModal #delFileBtn").on("click", function() {
                if(confirm("Delete image "+$(".file-info-form input[name=filename]").val()+" ?")) {
                    $.ajax({
                        url: "{{ url(config('laraadmin.adminRoute') . '/uploads_delete_file') }}",
                        method: 'POST',
                        data: $("form.file-info-form").serialize(),
                        success: function( data ) {
                            console.log(data);
                            loadUploadedFiles();
                            $("#EditFileModal").modal('hide');
                        }
                    });
                }
            });

            loadUploadedFiles();
        });
        function loadUploadedFiles() {
            // load folder files
            $.ajax({
                dataType: 'json',
                url: "{{ url(config('laraadmin.adminRoute') . '/uploaded_files') }}",
                success: function ( json ) {
                    console.log(json);
                    cntFiles = json.uploads;
                    $("ul.files_container").empty();
                    if(cntFiles.length) {
                        for (var index = 0; index < cntFiles.length; index++) {
                            var element = cntFiles[index];
                            var li = formatFile(element);
                            $("ul.files_container").append(li);
                        }
                    } else {
                        $("ul.files_container").html("<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>");
                    }
                }
            });
        }
        function formatFile(upload) {
            var image = '';
            if($.inArray(upload.extension, ["jpg", "jpeg", "png", "gif", "bmp"]) > -1) {
                image = '<img src="'+bsurl+'/files/'+upload.hash+'/'+upload.name+'?s=130">';
            } else {
                switch (upload.extension) {
                    case "pdf":
                        image = '<i class="fa fa-file-pdf-o"></i>';
                        break;
                    default:
                        image = '<i class="fa fa-file-text-o"></i>';
                        break;
                }
            }
            return '<li><a class="fm_file_sel" data-toggle="tooltip" data-placement="top" title="'+upload.name+'" upload=\''+JSON.stringify(upload)+'\'>'+image+'</a></li>';
        }
    </script>
@endpush