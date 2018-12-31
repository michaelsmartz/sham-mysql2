@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Candidate')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" id="candidates" action="{{ route('candidates.store') }}" accept-charset="UTF-8" name="create_candidates_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('candidates.form', [
                            'requests' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('candidates.index') }}" class="btn btn-default pull-right" title="Show all recruitment requests">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>

    <link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>
    <script>
        var initializeFileUpload = function() {
            $('#one').fileUploader({
                lang: 'en',
                useFileIcons: true,
                fileMaxSize: {!! '1.7' !!},
                totalMaxSize: {!! '5' !!},
                useLoadingBars: true,
                linkButtonContent: '',
                deleteButtonContent: "<i class='text-danger fa fa-times' data-wenk='Remove file'></i>",
                resultPrefix: "attachment",
                duplicatesWarning: true,
                filenameTest: function(fileName, fileExt, $container) {
                    var allowedExts = ["doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf", "jpg", "jpeg", "png"];

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
                        intro_msg: "{{ 'Attach CV' }}",
                        dropZone_msg:
                            '<p><strong>Drop</strong>&nbsp;your files here or <strong class="text-primary">click</strong>&nbsp;on this area' +
                            '<br><small class="text-muted">{{ "You can upload any related files" }}.\n' +
                            '   One file can be max 10 MB</small>\n' +
                            '</p>',
                        maxSizeExceeded_msg: 'File too large',
                        totalMaxSizeExceeded_msg: 'Total size exceeded',
                        duplicated_msg: 'File duplicated (skipped)',
                        name_placeHolder: 'name',
                    }
                },
                HTMLTemplate: function() {
                    return [
                        '<p class="introMsg"></p>',
                        '<div>',
                        '    <div class="inputContainer">',
                        '        <input class="fileLoader" type="file" {!! 'multiple' !!} />',
                        '    </div>',
                        '    <div class="dropZone"></div>',
                        '    <div class="filesContainer filesContainerEmpty">',
                        '        <div class="innerFileThumbs"></div>',
                        '        <div style="clear:both;"></div>',
                        '    </div>',
                        '</div>',
                        '<div class="result"></div>'
                    ].join("\n");
                }
            });
        };
        $(function(){
            initializeFileUpload();
        });

    </script>
@endsection