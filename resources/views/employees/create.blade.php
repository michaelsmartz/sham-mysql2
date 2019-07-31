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
<link href="{{URL::to('/')}}/css/employees.min.css" rel="stylesheet">
<script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>
<script>
    var initializeFileUpload = function() {
        $('#one').fileUploader({
            useFileIcons: true,
            lang: 'en',
            fileMaxSize: {!! $uploader['fileMaxSize'] or '1.7' !!},
            totalMaxSize: {!! $uploader['totalMaxSize'] or '5' !!},
            useLoadingBars: true,
            linkButtonContent: '',
            deleteButtonContent: "<i class='text-danger fa fa-times' data-wenk='Remove file'></i>",
            resultPrefix: "attachment",
            duplicatesWarning: true,
            filenameTest: function(fileName, fileExt, $container) {
                var allowedExts = ["doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "jpg", "jpeg", "png"];
                
                @if(!empty($uploader['acceptedFiles'] && is_array($uploader['acceptedFiles']) && sizeof($uploader['acceptedFiles'])>0))
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
<script src="{{URL::to('/')}}/js/new-employee.min.js"></script>
@endsection