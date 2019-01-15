<div class="row">
@if (isset($histories)&& count($histories)>0)
    @foreach($histories as $history)
        <div class="form-group col-xs-12">
            <label for="rg-from">{{$history->EventType}}: {{$history->Description}}</label>
            <div class="form-group">
                <input class="form-control datepicker" name="{{$history->EventTypeKey}}_{{$history->Id}}"
                       type="text" id="{{$history->EventTypeKey}}_{{$history->Id}}"
                       value="{{ old($history->Description, $history->formattedDate) }}"
                       placeholder="Enter history {{$history->EventTypeKey}} date">
            </div>
        </div>
        <div id="date-picker"> </div>
    @endforeach
@else
    <div class="form-group col-xs-12">
         <span>There is no timeline history associated with this employee</span>
    </div>
@endif
</div>