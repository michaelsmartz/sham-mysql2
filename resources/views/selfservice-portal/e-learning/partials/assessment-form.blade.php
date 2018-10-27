@extends('index')

@section('post-body')
    <link href="{{URL::to('/')}}/plugins/FormBuilder/css/formbuilder.css" rel="stylesheet">
    <style>
        .checkbox label:after,
        .radio label:after {
            content: '';
            display: table;
            clear: both;
        }

        .checkbox .cr,
        .radio .cr {
            position: relative;
            display: inline-block;
            border: 1px solid #a9a9a9;
            border-radius: .25em;
            width: 1.3em;
            height: 1.3em;
            float: left;
            margin-right: .5em;
        }

        .radio .cr {
            border-radius: 50%;
        }

        .checkbox .cr .cr-icon,
        .radio .cr .cr-icon {
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .radio .cr .cr-icon {
            /*margin-left: 0.04em;*/
        }

        .checkbox label input[type="checkbox"],
        .radio label input[type="radio"] {
            display: none;
        }

        .checkbox label input[type="checkbox"] + .cr > .cr-icon,
        .radio label input[type="radio"] + .cr > .cr-icon {
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
        .radio label input[type="radio"]:checked + .cr > .cr-icon {
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .checkbox label input[type="checkbox"]:disabled + .cr,
        .radio label input[type="radio"]:disabled + .cr {
            opacity: .5;
        }

        textarea {
            border: 1px solid #a9a9a9;
            border-radius: .25em;
        }

        .cr-label {
            font-size: 1.2em;
        }
    </style>

<script src="{{URL::to('/')}}/plugins/Formbuilder/js/dust-full.min.js"></script>
<script src="{{URL::to('/')}}/plugins/Formbuilder/js/formrunner.js"></script>
<script>
    var myForm;
    $(function() {
        function loadFromJsonFile() {

            var assessment = '{!! $Data !!}';
            console.log('in assessment form');
            console.log(assessment);
            var jsonObj = $.parseJSON(assessment);
            var frOptions = {
                templateBasePath: '{{URL::to('/')}}/plugins/Formbuilder/templates/runner',
                targets: $('#form'),
                form_id:  jsonObj.form_id,
                model: jsonObj.model,
                action: './{{$assessmentId}}/post'
            };

            // Create an instance of form builder
            myForm = new Formrunner(frOptions);
        }

        loadFromJsonFile();
        $(window).on('fb-runner-rendered', function() {
            $('<input>').attr({
                type: 'hidden',
                value: '{{ csrf_token() }}',
                name: '_token'
            }).appendTo('.frmb-form');
        });
    });
</script>

@stop

@section('content')
    <section>
        <div style="display:none;visibility: hidden" id="formData">{{$Data}}</div>
        <div class="row">
            <div class="col-xs-12">
                <div id="form"></div>
            </div>
        </div>
    </section>

@stop