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
<link href="{{URL::to('/')}}/css/post-bootstrap-admin-reset.css" rel="stylesheet">
<link href="{{URL::to('/')}}/css/employees.min.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
<style>

    .SumoSelect>.optWrapper { z-index: 1000; }
    .bootstrap-select .dropdown-menu, .dropdown.show > .dropdown-menu.show { opacity:1 !important; }
    .bootstrap-select .dropdown-toggle .filter-option {
        background-color: whitesmoke;
    }
    .bootstrap-select > .dropdown-toggle::after {
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: .255em;
        vertical-align: .255em;
        content: "";
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-bottom: 0;
        border-left: .3em solid transparent;
    }
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
    .open > .dropdown-menu { display: block; }
</style>
<script src="{{URL::to('/')}}/js/employees.js"></script>
<script src="{{URL::to('/')}}/plugins/bootstrap-select/bootstrap-select-1.13.2.min.js"></script>
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
        $.fn.selectpicker.Constructor.BootstrapVersion = '4';
        $('.bootstrap-select').selectpicker({  
            template: {
                caret: '<span class="glyphicon glyphicon-chevron-down"></span>'
            }
        }).on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var managerId = $('#job_title_id option:selected').data('employeeId');
            $('#line_manager_id').val(managerId);
        });
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