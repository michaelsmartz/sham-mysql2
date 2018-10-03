<?php
//This form is reusable using blade include directive
//Some options are available to customize the output:
//By default the usage is for New record
//However, if the following variables are defined, then the  output is changed:
//  $_mode -> 'create','edit','view'

if (!isset($_mode)) $_mode='create';
?>

<div class="row">

    <div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
        {!! Form::label('title',' Title',['class'=>'control-label required','aria-required'=>'true']) !!}
        {!! Form::text('title',(Request::has('title')?Request::input('title'):null),($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke field-required', 'autocomplete'=>'off', 'minlength'=>"1", 'maxlength'=>"100", "required"=>"true", 'placeholder'=>'Enter title']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('date_start') ? 'has-error' : '' }}">
        {!! Form::label('date_start',' Start',['class'=>'control-label required','aria-required'=>'true']) !!}
        {!! Form::text('date_start',(Request::has('date_start')?Request::input('date_start'):null),($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control datepicker bg-whitesmoke field-required', 'autocomplete'=>'off', "minlength"=>"1", "required"=>"true", 'placeholder'=>' Enter start date']) !!}
        {!! $errors->first('date_start', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('EndDate') ? 'has-error' : '' }}">
        {!! Form::label('EndDate',' End',['class'=>'control-label required','aria-required'=>'true']) !!}
        {!! Form::text('EndDate',(Request::has('EndDate')?Request::input('EndDate'):null),($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control datepicker bg-whitesmoke field-required', 'autocomplete'=>'off', "minlength"=>"1", "required"=>"true", 'placeholder'=>' Enter end date']) !!}
        {!! $errors->first('EndDate', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-xs-12">
        <div class="well">
            <div class="form-group">
                {!! Form::label('Final',' Final: ') !!}
                {!! Form::checkbox('final','true',((isset($survey) && ($survey->final=='true'))||Request::has('final')),($_mode=='show')?['disabled']:null) !!}
                @if((!isset($survey) || $survey->final!='true'))
                    <br>
                    <span class="text-warning">(*) You will not be able to edit the survey furthermore</span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group col-xs-12">
        <?php if ($_mode!='show'): ?>
        {!! Form::label('FormData','Form builder:') !!}
        <div id="formBuilder"></div>
        <?php endif; ?>
        {!! Form::hidden('FormData',(Request::has('FormData')?Request::input('FormData'):null),['id'=>'FormData']) !!}
    </div>
</div>

@if(!Request::ajax())
@section('post-body')
@endif

<script src="{{URL::to('/')}}/plugins/alloy-3.0.1/aui/aui-min.js"></script>
<link href="{{URL::to('/')}}/css/jQuery-ui-bootstrap/jquery.ui.theme.css" rel="stylesheet">
<?php if ($_mode!='show'): ?>
<script src="{{URL::to('/')}}/js/aui-formbuilder-base.js"></script>
<?php endif; ?>

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