<div class="row">

    <div class="form-group col-xs-12 {{ $errors->has('header') ? 'has-error' : '' }}">
        <label for="header">Topic Heading</label>
            <input class="form-control" name="header" type="text" id="header" value="{{ old('header', isset($topic->header) ? $topic->header : null) }}" minlength="1" maxlength="299" required="true" placeholder="Enter header">
            {!! $errors->first('header', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-11 {{ $errors->has('data') ? 'has-error' : '' }}">
        <label for="data">Content</label>
        <div id="content-area">
            <div class="contentHolder" id="contentHolder">{!! $topic->Data !!}</div>
        </div>
        {!! $errors->first('data', '<p class="help-block">:message</p>') !!}
    </div>

</div>

@section('post-body')

<link href="{{URL::to('/')}}/plugins/keditor/1.1.4/css/keditor-1.1.4.min.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/keditor/1.1.4/css/keditor-components-1.1.4.min.css" rel="stylesheet">
<link href="{{URL::to('/')}}/plugins/fine-uploader/fine-uploader-new.min.css" rel="stylesheet">
<script src="{{URL::to('/')}}/plugins/ckeditor/4.7.3/ckeditor.js"></script>
<script src="{{URL::to('/')}}/plugins/ckeditor/4.7.3//adapters/jquery.js"></script>
<script src="{{URL::to('/')}}/plugins/keditor/1.1.4/js/keditor-1.1.4.js">
    // modified renderSnippets function to render user images within container
</script>
<script src="{{URL::to('/')}}/plugins/keditor/1.1.4/js/keditor-components-1.1.4.js"></script>
<script src="{{URL::to('/')}}/plugins/fine-uploader/fine-uploader.js"></script>
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
        $('#content-area').keditor({
            snippetsUrl: "{{URL::to('topics/snippets')}}",
            contentAreasSelector: '#contentHolder'
        });

        //$('#Header').charcounter({placement: 'bottom-d'});

    });
</script>
@endsection
