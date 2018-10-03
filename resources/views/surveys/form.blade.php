<div class="row">
    <div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
        <label for="title">Title</label>
            <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($survey)->title) }}" minlength="1" maxlength="100" required="true" placeholder="Enter title">
            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('date_start') ? 'has-error' : '' }}">
        <label for="date_start">Start</label>
            <input class="form-control" name="date_start" type="text" id="date_start" value="{{ old('date_start', optional($survey)->date_start) }}" minlength="1" required="true" placeholder="Enter start date">
            {!! $errors->first('date_start', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('EndDate') ? 'has-error' : '' }}">
        <label for="EndDate">End</label>
            <input class="form-control" name="EndDate" type="text" id="EndDate" value="{{ old('EndDate', optional($survey)->EndDate) }}" minlength="1" required="true" placeholder="Enter end date">
            {!! $errors->first('EndDate', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('notification_recurrence_id') ? 'has-error' : '' }}">
        <label for="notification_recurrence_id">Recurrence</label>
        <select class="form-control" id="notification_recurrence_id" name="notification_recurrence_id" required="true">
            <option value="" style="display: none;" {{ old('notification_recurrence_id', optional($survey)->notification_recurrence_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select recurrence</option>
            @foreach ($notificationRecurrences as $key => $notificationRecurrence)
                <option value="{{ $key }}" {{ old('notification_recurrence_id', optional($survey)->notification_recurrence_id) == $key ? 'selected' : '' }}>
                    {{ $notificationRecurrence }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('announcement_status_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('notification_group_id') ? 'has-error' : '' }}">
        <label for="notification_group_id">Notification Group</label>
        <select class="form-control" id="notification_group_id" name="notification_group_id" required="true">
            <option value="" style="display: none;" {{ old('notification_recurrence_id', optional($survey)->notification_group_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select notification group</option>
            @foreach ($notificationGroups as $key => $notificationGroup)
                <option value="{{ $key }}" {{ old('notification_group_id', optional($survey)->notification_group_id) == $key ? 'selected' : '' }}>
                    {{ $notificationGroup }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('announcement_status_id', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-xs-12">
        <div class="well">
            <div class="form-group">
                {!! Form::label('Final',' Final: ') !!}
                {!! Form::checkbox('final','true',((isset($survey) && ($survey->final=='true'))||Request::has('final'))?['disabled']:null) !!}
                @if((!isset($survey) || $survey->final!='true'))
                    <br>
                    <span class="text-warning">(*) You will not be able to edit the survey furthermore</span>
                @endif

            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
        </div>
        {!! Form::label('FormData','Form builder:') !!}
        <div id="formBuilder"></div>
        {!! Form::hidden('FormData',(Request::has('FormData')?Request::input('FormData'):null),['id'=>'FormData']) !!}

    </div>
</div>

@if(!Request::ajax())
@section('post-body')
@endif

<script src="{{URL::to('/')}}/plugins/alloy-3.0.1/aui/aui-min.js"></script>
<link href="{{URL::to('/')}}/css/jQuery-ui-bootstrap/jquery.ui.theme.css" rel="stylesheet">
<script src="{{URL::to('/')}}/js/aui-formbuilder-base.js"></script>

<script>
    var q = asyncJS();
    q.add("{{URL::to('/')}}/js/sham.js");
    q.whenDone(function(){
        //setDatePickers();
        setTimeout(function(){

            $(document).on("preSubmitValidFormData", function (event) {
                parseFormBuilderData();
                return true;
            });

            let dateFormat = 'yy-mm-dd',
                from = $( "#date_start" )
                    .datepicker({
                        dateFormat:'yy-mm-dd',
                        changeMonth: true,
                        changeYear:true,
                        numberOfMonths: 1
                    })
                    .on( "change", function() {
                        to.datepicker( "option", "minDate", getDate( this ) );
                    }),
                to = $( "#EndDate" ).datepicker({
                    dateFormat:'yy-mm-dd',
                    changeMonth: true,
                    changeYear:true,
                    numberOfMonths: 1
                })
                    .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                    });

            function getDate( element ) {
                let date;
                try {
                    date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                    date = null;
                }

                return date;
            }
        }, 1000);

    });
    $(document).ready(function() {

        $('#date_start').on("change", function() {
            if($(this).val()){
                $(this).closest('div').removeClass('has-error');
                $('#date_start-error').remove();
            }
        });

        $('#EndDate').on("change", function() {
            if($(this).val()){
                $(this).closest('div').removeClass('has-error');
                $('#EndDate-error').remove();
            }
        });
    });

    function parseFormBuilderData(){

        var formDefinition = [];

        var parser = function(fields, container){
            fields.each(function(item, index) {
                var surveyElement = {};
                var properties = item.getProperties();

                properties.forEach(function(property) {
                    var attr = property.attributeName;
                    surveyElement[attr] =  item.get(attr);
                })
                surveyElement.name = item.get('name');

                var children = item.getAttrs()['fields']
                if(children && children.size() > 0){
                    surveyElement.children = [];
                    parser(children, surveyElement.children);
                }

                container.push(surveyElement);
            });
        }

        parser(window.formBuilder.get('fields'), formDefinition);
        //var json = JSON.stringify(formDefinition)

        $('#FormData').val(JSON.stringify(formDefinition));
    }

</script>

@if(!Request::ajax())
@endsection
@endif