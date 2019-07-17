<div class="fileUploader" id="one"></div>

@if(!Request::ajax())
@section('post-body')
@endif
<link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
<script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>
<script>
    window.initializeFileUpload = function() {
        $('.fileUploader').fileUploader({
            lang: 'en',
            useFileIcons: true,
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
                    intro_msg: "{{$uploader['fieldLabel']}}",
                    dropZone_msg:
                        '<p><strong>Drop</strong>&nbsp;your files here or <strong class="text-primary">click</strong>&nbsp;on this area' +
                        '<br><small class="text-muted">{{ $uploader["restrictionMsg"] or "You can upload any related files" }}.\n' +
                        '   One file can be max {{ $uploader["fileMaxSize"] }} MB</small>\n' +
                        '<br><b>Allowed File Types: {{ $uploader["acceptedFiles"] }}' +
                        '</b>\n' +
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
                    '        <input class="fileLoader" type="file" {!! $uploader['multiple'] or 'multiple' !!} />',
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
@if(!Request::ajax())
@append
@endif
