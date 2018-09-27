<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Description</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($timeGroup)->name) }}" minlength="1" maxlength="50" required="true">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

@if($_mode=='edit')
    {{--<div class="days-holder">--}}
            <div class="col-xs-12">
                {!! Form::label('',' Time shift and break(s) per day:') !!}
            </div>

            <div class="col-xs-12">
                <div class="input-group select2-bootstrap-prepend" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('days[1]', 'false') !!}
                    {!! Form::checkbox('days[1]','true',((isset($tgDays[1]))||Request::has('days[1]')),($_mode=='view')?['disabled']:['id'=>'days1']) !!}
                    <strong class="w100">Monday</strong>
                </span>
                    {{ Form::select('tgShifts[1]', $shifts, $tgShifts[1], ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days1',
                    'data-parsley-errors-container'=>'#day1-error-container', 'data-parsley-required-message'=>'Monday time shift is required']) }}
                    <select name="tgBreaks[1][]" id="tgBreaks1" data-selected="[{{implode(',', $tgBreaks[1])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day1-error-container"></div>
            </div>

            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('days[2]', 'false') !!}
                    {!! Form::checkbox('days[2]','true',((isset($tgDays[2]))||Request::has('days[2]')),($_mode=='view')?['disabled']:['id'=>'days2']) !!}
                    <strong class="w100">Tuesday</strong>
                </span>
                    {{ Form::select('tgShifts[2]', $shifts, $tgShifts[2], ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days2',
                    'data-parsley-errors-container'=>'#day2-error-container', 'data-parsley-required-message'=>'Tuesday time shift is required']) }}
                    <select name="tgBreaks[2][]" id="tgBreaks2" data-selected="[{{implode(',', $tgBreaks[2])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day2-error-container"></div>
            </div>

            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('days[3]', 'false') !!}
                    {!! Form::checkbox('days[3]','true',((isset($tgDays[3]))||Request::has('days[3]')),($_mode=='view')?['disabled']:['id'=>'days3']) !!}
                    <strong class="w100">Wednesday</strong>
                </span>
                    {{ Form::select('tgShifts[3]', $shifts, $tgShifts[3], ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days3',
                    'data-parsley-errors-container'=>'#day3-error-container', 'data-parsley-required-message'=>'Wednesday time shift is required']) }}
                    <select name="tgBreaks[3][]" id="tgBreaks3" data-selected="[{{implode(',', $tgBreaks[3])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day3-error-container"></div>
            </div>

            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('days[4]', 'false') !!}
                    {!! Form::checkbox('days[4]','true',((isset($tgDays[4]))||Request::has('days[4]')),($_mode=='view')?['disabled']:['id'=>'days4']) !!}
                    <strong class="w100">Thursday</strong>
                </span>
                    {{ Form::select('tgShifts[4]', $shifts, $tgShifts[4], ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days4',
                    'data-parsley-errors-container'=>'#day4-error-container', 'data-parsley-required-message'=>'Thursday time shift is required']) }}
                    <select name="tgBreaks[4][]" id="tgBreaks4" data-selected="[{{implode(',', $tgBreaks[4])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day4-error-container"></div>
            </div>

            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('days[5]', 'false') !!}
                    {!! Form::checkbox('days[5]','true',((isset($tgDays[5]))||Request::has('days[5]')),($_mode=='view')?['disabled']:['id'=>'days5']) !!}
                    <strong class="w100">Friday</strong>
                </span>
                    {{ Form::select('tgShifts[5]', $shifts, $tgShifts[5], ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days5',
                    'data-parsley-errors-container'=>'#day5-error-container', 'data-parsley-required-message'=>'Friday time shift is required']) }}
                    <select name="tgBreaks[5][]" id="tgBreaks5" data-selected="[{{implode(',', $tgBreaks[5])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day5-error-container"></div>
            </div>

            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('days[6]', 'false') !!}
                    {!! Form::checkbox('days[6]','true',((isset($tgDays[6]))||Request::has('days[6]')),($_mode=='view')?['disabled']:['id'=>'days6']) !!}
                    <strong class="w100">Saturday</strong>
                </span>
                    {{ Form::select('tgShifts[6]', $shifts, $tgShifts[6], ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days6',
                    'data-parsley-errors-container'=>'#day6-error-container', 'data-parsley-required-message'=>'Saturday time shift is required']) }}
                    <select name="tgBreaks[6][]" id="tgBreaks6" data-selected="[{{implode(',', $tgBreaks[6])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day6-error-container"></div>
            </div>

            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('days[7]', 'false') !!}
                    {!! Form::checkbox('days[7]','true',((isset($tgDays[7]))||Request::has('days[7]')),($_mode=='view')?['disabled']:['id'=>'days7']) !!}
                    <strong class="w100">Sunday</strong>
                </span>
                    {{ Form::select('tgShifts[7]', $shifts, $tgShifts[7], ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days7',
                    'data-parsley-errors-container'=>'#day7-error-container', 'data-parsley-required-message'=>'Sunday time shift is required']) }}
                    <select name="tgBreaks[7][]" id="tgBreaks7" data-selected="[{{implode(',', $tgBreaks[7])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day7-error-container"></div>
            </div>
        {{--</div>--}}
@endif

</div>

@if(!Request::ajax())
@section('post-body')
@endif
    <link href="{{URL::to('/')}}/plugins/select2-4.0.3/css/select2.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/plugins/select2-4.0.3/css/select2-bootstrap.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/plugins/select2-4.0.3/js/select2.js"></script>

    <style>
        .js-select2 {
            display: inline-block;
            overflow: auto;
            float:right;
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        .select2-container {
            min-width: 78% !important;
            max-width: 78% !important;
        }
        .select2-container--bootstrap .select2-search__field::-moz-placeholder {
            color: #555;
            opacity: 1;
        }

        /* truncate tags with ellipsis */
        .select2-selection__choice {
            width: 105px !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 90%;
        }
        .select2-selection__rendered{
            word-wrap: break-word !important;
            text-overflow: inherit !important;
            white-space: normal !important;
        }

        .w100 {
            text-indent: 5px;
            text-align: left;
            display: inline-block;
            width: 85px !important;
            max-width: 85px !important;
        }

        .light-modal-content.large-content {
            width: 65vw;!important;
        }

        .select-in-modal+.select2-container {
            width: 100% !important;
            padding: 0;
            z-index:10000;
        }

        .select2-container--open {
            z-index:10000;
        }

        input.parsley-success,
        select.parsley-success,
        textarea.parsley-success {
            color: #468847;
            background-color: #DFF0D8;
            border: 1px solid #D6E9C6;
        }

        input.parsley-error,
        select.parsley-error,
        textarea.parsley-error {
            color: #B94A48 !important;
            background-color: #F2DEDE !important;
            border: 1px solid #EED3D7 !important;
        }
        /*
        .parsley-error,
        .parsley-success {
            color: #333 !important;
        }
        .parsley-error {
            background: #ffdedd !important;
            border-color: #ff5b57 !important;
        }
        .parsley-success {
            background: #cceeee !important;
            border-color: #00acac !important;
        }
        */

        .parsley-error > input[type="radio"] {
            border-radius: 100%;
            border: 1px solid #b4b4b4;
            display: inline-block;
            background-color: #3197EE;
            box-shadow: inset 0 0 0 4px #f4f4f4;
        }

        .parsley-error:focus,
        .parsley-success:focus {
            color: #333 !important;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.3) !important;
            -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.3) !important;
        }

        select.parsley-error + .selectize-control > .selectize-input > input {
            color: #B94A48 !important;
        }

        .parsley-errors-list {
            margin: 3px 0 3px;
            padding: 3px 0;
            list-style-type: none;
            font-size: 1em;
            line-height: 1em;
            opacity: 0;
            color: #B94A48;

            transition: all .3s ease-in;
            -o-transition: all .3s ease-in;
            -moz-transition: all .3s ease-in;
            -webkit-transition: all .3s ease-in;
        }

        .parsley-errors-list.filled {
            opacity: 1;
        }

        .parsley-errors-list li {
            padding-left: 3px;
            font-weight: bold;

            opacity:0;  /* make things invisible upon start */
            -webkit-animation:fadeIn ease-in 1;  /* call our keyframe named fadeIn, use animattion ease-in and repeat it only 1 time */
            -moz-animation:fadeIn ease-in 1;
            animation:fadeIn ease-in 1;

            -webkit-animation-fill-mode:forwards;  /* this makes sure that after animation is done we remain at the last keyframe value (opacity: 1)*/
            -moz-animation-fill-mode:forwards;
            animation-fill-mode:forwards;

            -webkit-animation-duration:1s;
            -moz-animation-duration:1s;
            animation-duration:1s;
        }

        /* make keyframes that tell the start state and the end state of our object */
        @-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    </style>

    <script>
        var FormStuff = {
            init: function() {
                this.applyConditionalRequired();
                this.bindUIActions();
            },
            bindUIActions: function() {
                $("input[type='radio'], input[type='checkbox']").on("change", this.applyConditionalRequired);
            },
            applyConditionalRequired: function() {
                $(".require-if-active").each(function() {
                    var el = $(this);
                    if ($(el.data("require-pair")).is(":checked")) {
                        el.prop("required", true);
                        el.prop("data-parsley-required", true);
                    } else {
                        el.prop("required", false);
                        el.prop("data-parsley-required", false);
                    }
                });
            }
        };

        FormStuff.init();

        $(document).ready(function() {
            var $select = $('.js-select2');

            $select.select2({
                theme: "bootstrap",
                tokenSeparators: [',', ' '],
                createSearchChoice: false,
                minimumResultsForSearch: Infinity, // hide search
                createTag: function(params) {
                    return undefined;
                }
            }); // initialize Select2 and any events

            setTimeout(function() {
                $('.js-select2').each(function(index,element){
                    $(element).val($(element).data('selected')).trigger('change');
                });
            }, 500);
        });
    </script>
@if(!Request::ajax())
@endsection
@endif