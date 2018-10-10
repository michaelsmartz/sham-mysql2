@extends('portal-index')
@section('title','My Surveys')

@section('post-body')
    <script>
        jQuery(document).ready(function($) {

            $('.iframe-container > iframe').load(function() {
                $(this).parent().toggleClass('iframe-container',false);
            })

            $('.item-edit').click(function() {
                var id =  $(this).closest('div.thumbnail').data("id");
                if (id)
                {
                    $('#md-content').empty();
                    $('#md-content').load('{{url()->current()}}/'+id);
                    $('#md').modal('toggle');
                    return;
                }
            });

            //Trigger the modal container view if it is not empty
            if ($('#md-content').text().trim()!='') $('#md').modal('toggle');
        });
    </script>

    <style>
        .thumbnail {
            position: relative;
            padding: 0px;
            margin-bottom: 20px;
        }
        .thumbnail > h4 {
            font-size: 16px;
            padding: 7px 5px 0px;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-left: 5px;
            white-space: nowrap;
        }
        .thumbnail h4 .info {
            position: absolute;
            top:0;
            right:0;
            font-size: 0.6em;
            padding-left: 15px;
            border-top-right-radius: 3px;
            border-bottom-left-radius: 4px;
            border-radius: 0px;
            border-bottom-left-radius: 5px;
        }

        .thumbnail h4 .info > span {
            margin-right: 10px;
        }

        .thumbnail img {
            width: 100%;
        }
        .thumbnail a.btn {
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
        }
        iframe.snippet-preview {
            border: 0 none;
            width: 100%;
            height: 100%;
            margin:auto;
            pointer-events: none;
            display:block;

            -webkit-transform: scale(0.85);
            -moz-transform: scale(0.85);
            -ms-transform: scale(0.85);
            transform: scale(0.85);
            /*-webkit-transform-origin: 0 0;
            -moz-transform-origin: 0 0;
            -ms-transform-origin: 0 0;
            transform-origin: 0 0;*/
        }
    </style>
@stop

@section('content')
    <section id="survey">
        <p></p>
        <div class="row">
            @if( sizeof($surveys) == 0)
                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 text-success">
                    There are no surveys available for the moment
                </div>
            @else
                @foreach($surveys as $survey)
                    <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                        <div class="thumbnail" data-id="{{ $survey->id }}">
                            <h4>
                                <span data-toggle="tooltip" title="{{$survey->title}}">{{$survey->title}}</span>
                                <span class="label label-primary info">
                                    <span data-wenk="From {{\Carbon\Carbon::parse($survey->date_start)->toDateString()}} to {{\Carbon\Carbon::parse($survey->date_end)->toDateString()}}"><i class="glyphicon glyphicon-calendar"></i> </span>
                                </span>
                            </h4>
                            <div class="iframe-container" style="width:100%;height:100%;padding:0;overflow: hidden; float: left;">
                                <iframe id="#survey{{$survey->id}}" rel="nofollow" class="snippet-preview" scrolling="no"
                                        allowtransparency="true" frameborder="0"
                                        src="{{URL::to('/')}}/survey-thumbnail/{{$survey->form_id}}">
                                </iframe>
                            </div>
                            <a class="btn btn-primary col-xs-12 item-edit" role="button">Complete this survey</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@stop
