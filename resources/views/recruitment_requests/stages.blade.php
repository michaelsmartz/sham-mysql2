@extends('portal-index')
@section('title',"Recruitment for $data->job_title")
@section('subtitle',"$data->quantity position(s)")
@section('right-title')
    <a href="{{route('recruitment_requests.index') }}" class="btn btn-default pull-right" title="Show all Recruitment Requests">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection
@section('content')
    <br>
    <section id="recruitment">
        <ul class="nav nav-tabs steps">
            <li class="orange nav-item">
                <a class="nav-link active show" href="#applied" role="tab" data-toggle="tab" @click="selectedCategory=0">
                    <h2 :text-content.prop="people | applied">&nbsp;</h2>
                    <small>Applied</small>
                </a>
                <div class="arrow"></div>
            </li>

            {{--<li class="orange nav-item">--}}
                {{--<a class="nav-link" href="#review" role="tab" data-toggle="tab" @click="selectedCategory='review'">--}}
                    {{--<h2>4</h2>--}}
                    {{--<small>Review</small>--}}
                {{--</a>--}}
                {{--<div class="arrow"></div>--}}
            {{--</li>--}}

            <li class="blue nav-item">
                <a class="nav-link" href="#interviewing" role="tab" data-toggle="tab" @click="selectedCategory=1">
                    <h2 :text-content.prop="people|interviewing">&nbsp;</h2>
                    <small>Interviewing</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="blue nav-item">
                <a class="nav-link" href="#offer" role="tab" data-toggle="tab" @click="selectedCategory=2">
                    <h2 :text-content.prop="people|offer">&nbsp;</h2>
                    <small>Offer</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="green nav-item">
                <a class="nav-link" href="#contract" role="tab" data-toggle="tab" @click="selectedCategory=3">
                    <h2 :text-content.prop="people|contract">&nbsp;</h2>
                    <small>Contract</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="green nav-item">
                <a class="nav-link" href="#hired" role="tab" data-toggle="tab" @click="selectedCategory=4">
                    <h2 :text-content.prop="people|hired">&nbsp;</h2>
                    <small>Hired</small>
                </a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="applied">
                @component('recruitments.applied', ['step' => [
                    ['id'=>'item-approve','btnclass'=>'btn btn-sham','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Approve for interview'],
                    ['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Reject applicant']
                ]])
                @endcomponent
            </div>
            {{--<div class="tab-pane"  role="tabpanel" id="review">--}}
                {{--@component('recruitments.step', ['step' => [--}}
                    {{--['id'=>'item-approve','btnclass'=>'btn btn-primary','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Schedule interview'],--}}
                    {{--['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Not-approved']--}}
                {{--] ])--}}
                {{--@endcomponent--}}
            {{--</div>--}}
            <div class="tab-pane"  role="tabpanel" id="interviewing">
                @component('interviews.index', ['step' => [
                   ['id'=>'item-approve','btnclass'=>'btn btn-primary','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Overall Pass'],
                   ['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Overall Fail']
               ]])
                @endcomponent
            </div>
            <div class="tab-pane"  role="tabpanel" id="offer">
                    @component('recruitments.offer', ['step' => [
                     ['id'=>'item-approve','btnclass'=>'btn btn-primary','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Approve offer'],
                     ['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Not-approved']
                        ] ])
                    @endcomponent

            </div>
            <div class="tab-pane"  role="tabpanel" id="contract">
                    @component('recruitments.contract', ['step' => [
                     ['id'=>'item-approve','btnclass'=>'btn btn-success','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Approve contract'],
                     ['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Not-approved']
                        ] ])
                    @endcomponent
            </div>
            <div class="tab-pane" role="tabpanel" id="hired">
                @component('recruitments.hired', ['step' => [
                 ['id'=>'item-approve','btnclass'=>'btn btn-primary','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Schedule interview'],
                 ['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Not-approved']
                    ] ])
                @endcomponent

            </div>
        </div>
        <modal v-if="showModal" @close="showModal=false">

        </modal>
    </section>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/nav-wizard.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment.min.js"></script>

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

    <style>
        .avatar-upload .avatar-edit input + label {
            display: none; !important;
        }
    </style>
@endsection