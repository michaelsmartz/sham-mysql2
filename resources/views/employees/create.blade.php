@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add New Employee')

@section('content')
    <form method="POST" action="{{ route('employees.store') }}" accept-charset="UTF-8" id="create_employee_form" name="create_employee_form" data-parsley-validate="" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('employees.form', [
                    'employee' => $employee,
                    '_mode' => 'create',
                    'uploader' => $uploader
                ])
            </div>
        </div>
        <div class="box-footer">
            <input class="btn btn-primary pull-right" type="submit" value="Add">
            <a href="{{ route('employees.index') }}" class="btn btn-default pull-right" title="Show all Employees">
                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
            </a>
        </div>
    </form>
@endsection

@section('post-body')
<link href="{{URL::to('/')}}/css/post-bootstrap-admin-reset.css" rel="stylesheet" xmlns="http://www.w3.org/1999/html">
<link href="{{URL::to('/')}}/css/employees.min.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
<style>

    .SumoSelect>.optWrapper { z-index: 1000; }

    .pic-holder {
        position: absolute;
        text-align: left;
        padding: 0 0 0 -20px;
        margin: 10px 0 20px -10px;
    }

    .pic-holder img {
        padding: 0;
        width: 160px;
        height: 150px;
        border-radius: 50%;
        border: 10px solid #f1f2f7;
        vertical-align: middle;
        transition: opacity .5s ease;
    }

    .pic-holder button {
        position: absolute;
        display: none;
        opacity: 0;
        transition: opacity .5s;
    }

    .pic-holder button.delete-pic {
        top: 0;
        right: 0;
        transition: top 0.4s,
        right 0.4s;
    }

    .pic-holder:hover img {
        opacity: 0.5;
    }

    .pic-holder:hover button {
        display: block;
        opacity: 1;
    }

    .v-spacer{
        display: block
    }
    .v-spacer.h20 {
        height: 20px;
    }

    .v-spacer.h30 {
        height: 30px;
    }
    .v-spacer.h40 {
        height: 40px;
    }
    .v-spacer.h50 {
        height: 55px;
    }
    @keyframes popIn {
        from {
            opacity: 0;
            transform: scale(0.4);
        }
        25% {
            opacity: 0;
            transform: scale(2.25);
        }
        60% {
            opacity: 0;
            transform: scale(0.5);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
<script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>
<script>
    var initializeFileUpload = function() {
        $('#one').fileUploader({
            useFileIcons: true,
            fileMaxSize: {!! $uploader['fileMaxSize'] or '1.7' !!},
            totalMaxSize: {!! $uploader['totalMaxSize'] or '5' !!},
            useLoadingBars: false,
            linkButtonContent: '',
            deleteButtonContent: "<i class='text-danger fa fa-times' data-wenk='Remove file'></i>",
            resultPrefix: "attachment",
            duplicatesWarning: true,
            filenameTest: function(fileName, fileExt, $container) {
                var allowedExts = ["doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "jpg", "jpeg", "png"];
                
                @if(!empty($uploader['acceptedFiles'] && sizeof($uploader['acceptedFiles'])>0))
                allowedExts = {!! $uploader['acceptedFiles'] !!};
                @endif

                var $info = $('<div class="errorLabel center"></div>');
                var proceed = true;
                // length check
                if (fileName.length > 120) {
                    $info.html('Name too long...');
                    proceed = false;
                }
                // replace not allowed characters
                fileName = fileName.replace(" ", "-");
                // extension check
                if (allowedExts.indexOf(fileExt) < 0) {
                    $info.html('Extension not allowed...');
                    proceed = false;
                }
                // show an error message, but only if there is no other error message already there
                if (!proceed && $container.children('.errorLabel').length < 1) {
                    $container.append($info);
                    setTimeout(function() {
                        $info.animate({opacity: 0}, 300, function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
                if (!proceed) {
                    return false;
                }
                return fileName;
            },
            langs: {
                'en': {
                    intro_msg: "{{$uploader['fieldLabel'] or 'Add attachments...' }}",
                    dropZone_msg: 
                        '<p><strong>Drop</strong>&nbsp;your files here or <strong class="text-primary">click</strong>&nbsp;on this area' +
                        '<br><small class="text-muted">{{ $uploader["restrictionMsg"] or "You can upload any related files" }}.\n' + 
                        '   One file can be max {{ $uploader["fileMaxSize"] }} MB</small>\n' +
                        '</p>',
                    maxSizeExceeded_msg: 'File too large',
                    totalMaxSizeExceeded_msg: 'Total size exceeded',
                    duplicated_msg: 'File duplicated (skipped)',
                    name_placeHolder: 'name',
                }
            }
        });
    };
    $(function(){
        initializeFileUpload();
    });

</script>
<script src="{{URL::to('/')}}/js/employees.min.js"></script>
@endsection