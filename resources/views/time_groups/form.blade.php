<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name">Description</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($timeGroup)->name) }}" minlength="1" maxlength="50" required="true">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

@if($_mode=='edit')
    <div class="days-holder">
        <div class="row">
            <div class="col-xs-12">
                {!! Form::label('',' Time shift and break(s) per day:') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="input-group select2-bootstrap-prepend" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('DayId[1]', 'false') !!}
                    {!! Form::checkbox('DayId[1]','true',((isset($DayId[1]) && ($DayId[1]=='true'))||Request::has('DayId[1]')),($_mode=='view')?['disabled']:['id'=>'DayId1']) !!}
                    <strong class="w100">Monday</strong>
                </span>
                    {{ Form::select('TimeShiftId[1]', $simpleShifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#DayId1',
                    'data-parsley-errors-container'=>'#day1-error-container', 'data-parsley-required-message'=>'Monday time shift is required']) }}
                    <select name="BreakId[1][]" id="BreakId1" data-selected="[{{implode(',', $timegroup->BreakId[1])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($simpleBreaks as $k=>$v)
                            <option title="{{$v->title}}" value="{{$k}}">{{$v->text}}
                        @endforeach
                    </select>
                </div>
                <div id="day1-error-container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('DayId[2]', 'false') !!}
                    {!! Form::checkbox('DayId[2]','true',((isset($DayId[2]) && ($DayId[2]=='true'))||Request::has('DayId[2]')),($_mode=='view')?['disabled']:['id'=>'DayId2']) !!}
                    <strong class="w100">Tuesday</strong>
                </span>
                    {{ Form::select('TimeShiftId[2]', $simpleShifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#DayId2',
                    'data-parsley-errors-container'=>'#day2-error-container', 'data-parsley-required-message'=>'Tuesday time shift is required']) }}
                    <select name="BreakId[2][]" id="BreakId2" data-selected="[{{implode(',', $timegroup->BreakId[2])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($simpleBreaks as $k=>$v)
                            <option title="{{$v->title}}" value="{{$k}}">{{$v->text}}
                        @endforeach
                    </select>
                </div>
                <div id="day2-error-container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('DayId[3]', 'false') !!}
                    {!! Form::checkbox('DayId[3]','true',((isset($DayId[3]) && ($DayId[3]=='true'))||Request::has('DayId[3]')),($_mode=='view')?['disabled']:['id'=>'DayId3']) !!}
                    <strong class="w100">Wednesday</strong>
                </span>
                    {{ Form::select('TimeShiftId[3]', $simpleShifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#DayId3',
                    'data-parsley-errors-container'=>'#day3-error-container', 'data-parsley-required-message'=>'Wednesday time shift is required']) }}
                    <select name="BreakId[3][]" id="BreakId3" data-selected="[{{implode(',', $timegroup->BreakId[3])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($simpleBreaks as $k=>$v)
                            <option title="{{$v->title}}" value="{{$k}}">{{$v->text}}
                        @endforeach
                    </select>
                </div>
                <div id="day3-error-container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('DayId[4]', 'false') !!}
                    {!! Form::checkbox('DayId[4]','true',((isset($DayId[4]) && ($DayId[4]=='true'))||Request::has('DayId[4]')),($_mode=='view')?['disabled']:['id'=>'DayId4']) !!}
                    <strong class="w100">Thursday</strong>
                </span>
                    {{ Form::select('TimeShiftId[4]', $simpleShifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#DayId4',
                    'data-parsley-errors-container'=>'#day4-error-container', 'data-parsley-required-message'=>'Thursday time shift is required']) }}
                    <select name="BreakId[4][]" id="BreakId4" data-selected="[{{implode(',', $timegroup->BreakId[4])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($simpleBreaks as $k=>$v)
                            <option title="{{$v->title}}" value="{{$k}}">{{$v->text}}
                        @endforeach
                    </select>
                </div>
                <div id="day4-error-container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('DayId[5]', 'false') !!}
                    {!! Form::checkbox('DayId[5]','true',((isset($DayId[5]) && ($DayId[5]=='true'))||Request::has('DayId[5]')),($_mode=='view')?['disabled']:['id'=>'DayId5']) !!}
                    <strong class="w100">Friday</strong>
                </span>
                    {{ Form::select('TimeShiftId[5]', $simpleShifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#DayId5',
                    'data-parsley-errors-container'=>'#day5-error-container', 'data-parsley-required-message'=>'Friday time shift is required']) }}
                    <select name="BreakId[5][]" id="BreakId5" data-selected="[{{implode(',', $timegroup->BreakId[5])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($simpleBreaks as $k=>$v)
                            <option title="{{$v->title}}" value="{{$k}}">{{$v->text}}
                        @endforeach
                    </select>
                </div>
                <div id="day5-error-container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('DayId[6]', 'false') !!}
                    {!! Form::checkbox('DayId[6]','true',((isset($DayId[6]) && ($DayId[6]=='true'))||Request::has('DayId[6]')),($_mode=='view')?['disabled']:['id'=>'DayId6']) !!}
                    <strong class="w100">Saturday</strong>
                </span>
                    {{ Form::select('TimeShiftId[6]', $simpleShifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#DayId6',
                    'data-parsley-errors-container'=>'#day6-error-container', 'data-parsley-required-message'=>'Saturday time shift is required']) }}
                    <select name="BreakId[6][]" id="BreakId6" data-selected="[{{implode(',', $timegroup->BreakId[6])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($simpleBreaks as $k=>$v)
                            <option title="{{$v->title}}" value="{{$k}}">{{$v->text}}
                        @endforeach
                    </select>
                </div>
                <div id="day6-error-container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group" style="margin-top:5px;margin-bottom: 5px;">
                <span class="input-group-addon">
                    {!! Form::hidden('DayId[7]', 'false') !!}
                    {!! Form::checkbox('DayId[7]','true',((isset($DayId[7]) && ($DayId[7]=='true'))||Request::has('DayId[7]')),($_mode=='view')?['disabled']:['id'=>'DayId7']) !!}
                    <strong class="w100">Sunday</strong>
                </span>
                    {{ Form::select('TimeShiftId[7]', $simpleShifts, null, ['class'=>'form-control bg-whitesmoke require-if-active', 'autocomplete'=>'off', 'placeholder'=>'Select time shift', 'style'=>'width:auto', 'data-require-pair'=>'#DayId7',
                    'data-parsley-errors-container'=>'#day7-error-container', 'data-parsley-required-message'=>'Sunday time shift is required']) }}
                    <select name="BreakId[7][]" id="BreakId7" data-selected="[{{implode(',', $timegroup->BreakId[7])}}]" class="js-select2" multiple="multiple" data-tags="true" data-placeholder="Select break(s)" data-allow-clear="true">
                        @foreach($simpleBreaks as $k=>$v)
                            <option title="{{$v->title}}" value="{{$k}}">{{$v->text}}
                        @endforeach
                    </select>
                </div>
                <div id="day7-error-container"></div>
            </div>
        </div>
    </div>
@endif

</div>