@extends('portal-index')
@section('title', 'Edit Employee')
@section('modalTitle', 'Edit Employee')

@section('modalFooter')
    <a href="{{route('employees.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('employees.form', [
                'employee' => $data,
                'uploader' => $uploader
            ])
        </div>
    </div>
@endsection

@section('post-body')
<link href="{{URL::to('/')}}/css/employees.min.css" rel="stylesheet">
<script src="{{URL::to('/')}}/js/employees.js"></script>
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
    
    // Apply filter to all inputs with data-filter:
    var inputs = document.querySelectorAll('input[data-filter]');

    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        var state = {
            value: input.value,
            start: input.selectionStart,
            end: input.selectionEnd,
            pattern: RegExp('^' + input.dataset.filter + '$')
        };
        
        input.addEventListener('input', function(event) {
            if (state.pattern.test(input.value)) {
                state.value = input.value;
            } else {
                input.value = state.value;
                input.setSelectionRange(state.start, state.end);
            }
        });

        input.addEventListener('keydown', function(event) {
            state.start = input.selectionStart;
            state.end = input.selectionEnd;
        });
    }

</script>
@endsection

@section('content')
    <form method="POST" action="{{ route('employees.update', $data->id) }}" id="edit_employee_form" name="edit_employee_form" data-parsley-validate="" accept-charset="UTF-8"  enctype="multipart/form-data"> 
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        @yield('modalContent')
        <p>
            <div class="row">
                <div class="col-sm-12 text-right"> 
                @yield('modalFooter')
                </div>
            </div>
        </p>
    </form>
@endsection