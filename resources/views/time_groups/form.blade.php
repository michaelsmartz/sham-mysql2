<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Description</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($timeGroup)->name) }}" minlength="1" maxlength="50" required="true">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

@if($_mode=='edit')
    <div class="days-holder">

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
                    {{ Form::select('TimeShiftId[1]', $shifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days1',
                    'data-parsley-errors-container'=>'#day1-error-container', 'data-parsley-required-message'=>'Monday time shift is required']) }}
                    <select name="breakId[1][]" id="breakId1" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
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
                    {{ Form::select('TimeShiftId[2]', $shifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days2',
                    'data-parsley-errors-container'=>'#day2-error-container', 'data-parsley-required-message'=>'Tuesday time shift is required']) }}
                    <select name="breakId[2][]" id="breakId2" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
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
                    {{ Form::select('TimeShiftId[3]', $shifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days3',
                    'data-parsley-errors-container'=>'#day3-error-container', 'data-parsley-required-message'=>'Wednesday time shift is required']) }}
                    <select name="breakId[3][]" id="breakId3" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
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
                    {{ Form::select('TimeShiftId[4]', $shifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days4',
                    'data-parsley-errors-container'=>'#day4-error-container', 'data-parsley-required-message'=>'Thursday time shift is required']) }}
                    <select name="breakId[4][]" id="breakId4" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
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
                    {{ Form::select('TimeShiftId[5]', $shifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days5',
                    'data-parsley-errors-container'=>'#day5-error-container', 'data-parsley-required-message'=>'Friday time shift is required']) }}
                    <select name="breakId[5][]" id="breakId5" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
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
                    {{ Form::select('TimeShiftId[6]', $shifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days6',
                    'data-parsley-errors-container'=>'#day6-error-container', 'data-parsley-required-message'=>'Saturday time shift is required']) }}
                    <select name="breakId[6][]" id="breakId6" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
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
                    {{ Form::select('TimeShiftId[7]', $shifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#days7',
                    'data-parsley-errors-container'=>'#day7-error-container', 'data-parsley-required-message'=>'Sunday time shift is required']) }}
                    <select name="breakId[7][]" id="breakId7" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($breaks as $k=>$v)
                            <option title="{{$v['title']}}" value="{{$k}}">{{$v['text']}}
                        @endforeach
                    </select>
                </div>
                <div id="day7-error-container"></div>
            </div>
        </div>

@endif

</div>

@section('post-body')
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

@endSection()