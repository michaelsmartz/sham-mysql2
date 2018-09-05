<div class="demo-upload-container">
    <div class="custom-file-container" data-upload-id="myUploadId">
        <div class="row">
            <label for="attachment">{{ $fieldLabel or 'Upload File' }} <a href="javascript:void(0)" class="custom-file-container__image-clear text-primary" data-wenk="Clear attached file">x</a></label>
            <p class="text-muted">{{ $desc or 'You can upload any related files' }} <br>
                <small>One file can be max {{ config('attachment.max_size', 10485760) }} MB</small>
            </p>
        </div>
        <label class="custom-file-container__custom-file" >
            <input type="file" name={{ $elementId or "myUploadId"}} id={{ $elementId or "myUploadId"}} data-parsley-filemaxmegabytes="2" data-parsley-filemimetypes="image/jpeg, image/png" data-parsley-fileextension={{$acceptedFiles or '.doc,.docx,.pdf'}} class="custom-file-container__custom-file__custom-file-input" accept={{ $acceptedFiles or '*'}} multiple>
            <input type="hidden" name="MAX_FILE_SIZE" value="{{ config('attachment.max_size', 10485760) }}" />
            <span class="custom-file-container__custom-file__custom-file-control"></span>
        </label>
        <div class="custom-file-container__image-preview"></div>
    </div>
</div>

@section('post-body')
<link href="{{URL::to('/')}}/css/dropzone.min.css" rel="stylesheet">
<script src="{{URL::to('/')}}/js/uploader.js"></script>
<script>
    // Initialize Submit Button
    var submitButton = document.querySelector("#submit");
    //First upload
    var firstUpload = new FileUploadWithPreview("myUploadId",true);
    // console.log('First upload:', firstUpload, firstUpload.cachedFileArray);
</script>
@endsection