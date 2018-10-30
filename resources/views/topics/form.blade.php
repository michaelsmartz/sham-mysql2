{!! Form::hidden('redirectsTo', URL::previous()) !!}
<div class="row">
    {!! Form::hidden('id',$topic->id, ['id'=>'topicId', 'name'=>'id']) !!}
    {!! Form::hidden('model', 'Topic') !!}
    <div class="form-group col-xs-11 {{ $errors->has('header') ? 'has-error' : '' }}">
        <label for="header">Topic Heading</label>
            <input class="form-control" name="header" type="text" id="heading" value="{{ old('header', optional($topic)->header) }}" minlength="1" maxlength="299" required="true" placeholder="Enter header">
            {!! $errors->first('header', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-11 {{ $errors->has('attachment') ? 'has-error' : '' }}">
        <div class="fileUploader" id="one"></div>
    </div>

    <div class="form-group col-xs-11 {{ $errors->has('data') ? 'has-error' : '' }}">
        <label for="data">Content</label>
        <div id="content-area">
            <div class="contentHolder" id="contentHolder">{!! $topic->data !!}</div>
        </div>
        {!! $errors->first('data', '<p class="help-block">:message</p>') !!}
    </div>

</div>

@section('post-body')
<link href="{{URL::to('/')}}/plugins/fileUploader/fileUploader.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/keditor/1.1.4/css/keditor-1.1.4.min.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/keditor/1.1.4/css/keditor-components-1.1.4.min.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/fine-uploader/fine-uploader-new.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/plugins/alerty/alerty.min.css">

<script src="{{URL::to('/')}}/plugins/fileUploader/fileUploader.js"></script>
<script src="{{URL::to('/')}}/plugins/ckeditor/4.7.3/ckeditor.js"></script>
<script src="{{URL::to('/')}}/plugins/ckeditor/4.7.3//adapters/jquery.js"></script>
<script src="{{URL::to('/')}}/plugins/keditor/1.1.4/js/keditor-1.1.4.js">
    // modified renderSnippets function to render user images within container
</script>
<script src="{{URL::to('/')}}/plugins/keditor/1.1.4/js/keditor-components-1.1.4.js"></script>
<script src="{{url('/')}}/plugins/alerty/alerty.min.js"></script>
<style>
    #keditor-sidebar {
        position: fixed;
        top: 70px;
    }
    #keditor-snippets-type-switcher {
        white-space: nowrap;
    }
    #keditor-sidebar-toggler {
        top: 150px;
        left: -30px;
        width: 30px;
        color: #000;
        background: #fff;
        font-weight: bolder;
    }
    .keditor-content-area {
        min-height: 100px;
        width: auto;
        margin: 0;
        padding: 5px 20px 30px;
    }

    #keditor-snippets-container > .keditor-snippets > .keditor-snippets-filter-wrapper + .keditor-snippets-inner {
        height: calc(100% - 48px);
    }

    .keditor-container > .keditor-toolbar {
        left: -29px;
    }
    .keditor-setting-form > .form-control {
        background: whitesmoke !important;
    }
    div.cke_float[id*="cke_keditor-component-content-"] {
        left: 80px !important;
        margin-top: -24px;
        width: 650px;
        background: transparent;
    }
    .keditor-setting-form #photo-edit {
        pointer-events: none !important;
        display: none !important;
    }
    .keditor-snippet-preview.user {
        width:180px;
        height:120px;
    }
    #keditor-container-snippets-tab .keditor-snippets-filter-wrapper {
        display: none !important;
        pointer-events: none !important;
    }
</style>
<script>
    $(function() {

        var initializeFileUpload = function() {
            $('#one').fileUploader({
                useFileIcons: true,
                fileMaxSize: {!! $uploader['fileMaxSize'] or '5' !!},
                totalMaxSize: {!! $uploader['totalMaxSize'] or '15' !!},
                useLoadingBars: false,
                linkButtonContent: '',
                deleteButtonContent: "<i class='text-danger fa fa-times' data-wenk='Remove file'></i>",
                resultPrefix: "attachment",
                duplicatesWarning: true,
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
                },
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
                        intro_msg: "{{$fieldLabel or 'Add attachments...' }}",
                        dropZone_msg: '<p class=text-center><strong>Drop</strong>&nbsp;your files here or <strong class="text-primary">click</strong>&nbsp;on this area' +
                        '<br><small class="text-muted">{{ $uploader["restrictionMsg"] or "You can upload any related files" }}.\n' + 
                        '   One file can be max {{ config("attachment.max_size", 10485760)/1000 }} MB</small>\n' +
                        '</p>',
                        maxSizeExceeded_msg: 'File too large',
                        totalMaxSizeExceeded_msg: 'Total size exceeded',
                        duplicated_msg: 'File duplicated (skipped)',
                        name_placeHolder: 'name',
                    }
                }
            });
        };

        $.keditor.DEFAULTS.snippetsTooltipEnabled = false;
        $.keditor.DEFAULTS.tabTooltipEnabled = false;
        $.keditor.DEFAULTS.tabContainersTitle = '';
        $.keditor.DEFAULTS.tabContainersText = 'Add Page';
        $.keditor.DEFAULTS.tabComponentsTitle = '';
        $.keditor.DEFAULTS.tabComponentsText = 'Add Content';
        $.keditor.DEFAULTS.snippetsFilterEnabled = true;
        $.keditor.DEFAULTS.btnMoveContainerText = '<i class="fa fa-sort" title="Move"></i>';
        $.keditor.DEFAULTS.btnMoveComponentText = '<i class="fa fa-arrows" title="Move"></i>';
        $.keditor.DEFAULTS.btnSettingContainerText = '<i class="fa fa-cog"></i>';
        $.keditor.DEFAULTS.btnSettingComponentText = '<i class="fa fa-cog"></i>';
        $.keditor.DEFAULTS.btnDuplicateContainerText = '<i class="fa fa-files-o" title="Copy"></i>';
        $.keditor.DEFAULTS.btnDuplicateComponentText = '<i class="fa fa-files-o" title="Copy"></i>';
        $.keditor.DEFAULTS.btnDeleteContainerText = '<i class="fa fa-times" title="Remove"></i>';
        $.keditor.DEFAULTS.btnDeleteComponentText = '<i class="fa fa-times" title="Remove"></i>';
        // {{URL::to('/')}}/keditor/snippets/default/snippets.blade.php
        
        initializeFileUpload();

        $('#content-area').keditor({
            snippetsUrl: "{{URL::to('topics', $topic->id)}}/snippets",
            contentAreasSelector: '#contentHolder'
        });
        //$('#Header').charcounter({placement: 'bottom-d'});

        $('#btnSave').click(function(){
            saveHandler(true, $(this));
        });

    });

    function saveHandler(asychronousSave, btnInstance) {

        // asynchronous if argument is omitted
        if (asychronousSave === void 0) {
            asychronousSave = true;
        }

        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
        if (btnInstance.html() !== loadingText) {
            btnInstance.data('original-text', btnInstance.html());
            btnInstance.html(loadingText);
        }

        var id = $('#topicId').val();
        var content = $('#content-area').keditor('getContent');
        var header = $('#heading').val();
        var snippetsLength = $('.keditor-snippets-inner > .keditor-snippet').length;

        var form = document.getElementById("topic_form");
        var fd = new FormData($('#topic_form')[0]);
        fd.append('id', id);
        fd.append('snippetsLength', snippetsLength);
        fd.append('data', content);

        var request = $.ajax({
            url: $('#topic_form').attr('action'),
            type: "POST",
            async: asychronousSave,
            processData: false, contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: fd /*{
                '_method' : 'PATCH', 'id': id, 'header': header, 'data': content
            }*/
        });
        request.done(function (msg) {
            $('#topicId').val(msg.response.id);
            $('#one').html('');
            $('#one').data('fileUploader','');
            $('#one').fileUploader();
            alery.toasts('Changes were saved successfully. Please wait, this page will reload shortly',
            {time: 5000}, function(){
                window.location = '{{URL::to("topics.edit",' + msg.response.id ')}}';
            })
        });
        request.fail(function (jqXHR, textStatus) {
            console.log('fail');
        });

        request.always(function() {
            btnInstance.html(btnInstance.data('original-text'));
        });

        return request;
    }
</script>
@endsection