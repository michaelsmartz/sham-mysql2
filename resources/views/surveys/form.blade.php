<?php
//This form is reusable using blade include directive
//Some options are available to customize the output:
//By default the usage is for New record
//However, if the following variables are defined, then the  output is changed:
//  $_mode -> 'create','edit','view'

if (!isset($_mode)) $_mode='create';
?>

@if (isset($survey) && ($survey->final == true))
    <h3>This survey form is final and cannot be edited furthermore</h3>
@endif
@if($_mode != 'show')
    {{ Form::hidden('redirects_to', URL::previous()) }}
@endif

<div class="row">
    <div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
        {!! Form::label('title',' Title',['class'=>'control-label required','aria-required'=>'true']) !!}
        {!! Form::text('title',old('title', optional($survey)->title),($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control bg-whitesmoke field-required', 'autocomplete'=>'off', 'minlength'=>"1", 'maxlength'=>"100", "required"=>"true", 'placeholder'=>'Enter title']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('date_start') ? 'has-error' : '' }}">
        {!! Form::label('date_start',' Start',['class'=>'control-label required','aria-required'=>'true']) !!}
        {!! Form::text('date_start',old('title', optional($survey)->date_start),($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control datepicker bg-whitesmoke field-required', 'autocomplete'=>'off', "minlength"=>"1", "required"=>"true", 'placeholder'=>' Enter start date']) !!}
        {!! $errors->first('date_start', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-xs-6 {{ $errors->has('date_end') ? 'has-error' : '' }}">
        {!! Form::label('date_end',' End',['class'=>'control-label required','aria-required'=>'true']) !!}
        {!! Form::text('date_end',old('title', optional($survey)->date_end),($_mode=='show')?['class'=>'form-control','disabled']:['class'=>'form-control datepicker bg-whitesmoke field-required', 'autocomplete'=>'off', "minlength"=>"1", "required"=>"true", 'placeholder'=>' Enter end date']) !!}
        {!! $errors->first('date_end', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="col-xs-12">
        <div class="well">
            <div class="form-group">
                {!! Form::label('Final',' Final: ') !!}
                {!! Form::checkbox('final',1,((isset($survey) && ($survey->final==1))||Request::has('final')),($_mode=='show')?['disabled']:null) !!}
                @if((!isset($survey) || $survey->final!=1))
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
        {!! Form::hidden('FormData',old('FormData', optional($survey)->FormData),['id'=>'FormData']) !!}
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
                to = $( "#date_end" ).datepicker({
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

        $('#date_end').on("change", function() {
            if($(this).val()){
                $(this).closest('div').removeClass('has-error');
                $('#date_end-error').remove();
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

<style>
    .property-builder-canvas{
        z-index: 0!important;
    }
</style>

@if(!Request::ajax())
@endsection
@endif