{{-- 
<div class="demo-upload-container">
    <div class="custom-file-container" data-upload-id="myUploadId">
        <div class="row">
            <label for="attachment">{{ $fieldLabel or 'Upload File' }} <a href="javascript:void(0)" class="custom-file-container__image-clear text-primary" data-wenk="Clear attached file">x</a></label>
            <p class="text-muted">{{ $desc or 'You can upload any related files' }} <br>
                <small>One file can be max {{ config('attachment.max_size', 10485760) }} MB</small>
            </p>
        </div>
        <label class="custom-file-container__custom-file" >
            <input type="file" name="attachment" data-parsley-filemaxmegabytes="2" data-parsley-filemimetypes="image/jpeg, image/png" data-parsley-fileextension={{$acceptedFiles or '.doc,.docx,.pdf'}} class="custom-file-container__custom-file__custom-file-input" accept={{ $acceptedFiles or '*'}} multiple>
            <input type="hidden" name="MAX_FILE_SIZE" value="{{ config('attachment.max_size', 10485760) }}" />
            <span class="custom-file-container__custom-file__custom-file-control"></span>
        </label>
        <div class="custom-file-container__image-preview"></div>
    </div>
</div>

<div class="js_fileupload fileupload">
    <div class="dropbox js_dropbox"><span class="msg">Drop file here</span></div>
    <div class="fileinputs js_fileinputs"></div>
    <ul class="list js_list"></ul>
</div>
--}}

<div class="fileUploader" id="one">
    <p class="text-muted">{{ $desc or 'You can upload any related files' }} <br>
        <small>One file can be max {{ config('attachment.max_size', 10485760) }} MB</small>
    </p>
</div>

@section('post-body')
<link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
<script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>
<script>

    var initializeFileUpload = function() {
        $('#one').fileUploader({
            useFileIcons: true,
            fileMaxSize: 1.7,
            totalMaxSize: 2,
            useLoadingBars: false,
            linkButtonContent: '',
            deleteButtonContent: "<i class='text-danger fa fa-times' data-wenk='Remove file'></i>",
            resultPrefix: "attachment",
            duplicatesWarning: true,
            filenameTest: function(fileName, fileExt, $container) {
                var allowedExts = ["doc", "docx", "pdf", "jpg", "jpeg", "png"];
                var $info = $('<div class="errorLabel center"></div>');
                var proceed = true;
                // length check
                if (fileName.length > 80) {
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
                    }, 2000);
                }
                if (!proceed) {
                    return false;
                }
                return fileName;
            },
            langs: {
                'en': {
                    intro_msg: '(Add attachments...)',
                    dropZone_msg: 'Drop your files here or <strong>click</strong> in this area',
                    maxSizeExceeded_msg: 'File too large',
                    totalMaxSizeExceeded_msg: 'Total size exceeded',
                    duplicated_msg: 'File duplicated (skipped)',
                    name_placeHolder: 'name',
                }
            }
        });
    };

    document.addEventListener("DOMContentLoaded", initializeFileUpload);
</script>
@endsection