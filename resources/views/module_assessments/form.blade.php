{!! Form::hidden('redirectsTo', URL::previous()) !!}
<div class="row">

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($moduleAssessment)->description) }}" minlength="1" maxlength="100" required="true" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-7 {{ $errors->has('module_id') ? 'has-error' : '' }}">
    <label for="module_id">Module</label>
        <select class="form-control" id="module_id" name="module_id" required="true">
        	    <option value="" style="display: none;" {{ old('module_id', optional($moduleAssessment)->module_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select module</option>
        	@foreach ($modules as $key => $module)
			    <option value="{{ $key }}" {{ old('module_id', optional($moduleAssessment)->module_id) == $key ? 'selected' : '' }}>
			    	{{ $module }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('module_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-3 {{ $errors->has('assessment_type_id') ? 'has-error' : '' }}">
    <label for="assessment_type_id">Assessment Type</label>
        <select class="form-control" id="assessment_type_id" name="assessment_type_id" required="true">
        	    <option value="" style="display: none;" {{ old('assessment_type_id', optional($moduleAssessment)->assessment_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select assessment type</option>
        	@foreach ($assessmentTypes as $key => $assessmentType)
			    <option value="{{ $key }}" {{ old('assessment_type_id', optional($moduleAssessment)->assessment_type_id) == $key ? 'selected' : '' }}>
			    	{{ $assessmentType }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('assessment_type_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-2 {{ $errors->has('pass_mark') ? 'has-error' : '' }}">
    <label for="pass_mark">Pass Mark</label>
        <input class="form-control" name="pass_mark" type="number" id="pass_mark" value="{{ old('pass_mark', optional($moduleAssessment)->pass_mark) }}" min="0" max="100" required="true" placeholder="Enter pass mark" pattern="[0-9]*" onkeypress="return validateDigitQty(event)">
        {!! $errors->first('pass_mark', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12">
    <div class="text-info" id="indicateCorrectAnswersAlert">For single/multiple choice type questions; please define the choices and indicate the correct answers</div>
    <div class="text-info" id="totalPointsAlert">The total marks for each question should at least be equal to the assessment passmark</div>
</div>

<div class="form-group col-xs-12 {{ $errors->has('data') ? 'has-error' : '' }}">
    <label for="data">Assessment Questions</label>
        <div class="formbuilder"></div>
        {!! Form::hidden('data',(Request::has('data')?Request::input('data'):null),['id'=>'Data']) !!}
        {!! $errors->first('data', '<p class="help-block">:message</p>') !!}

</div>

</div>


@section('post-body')
<style>
    .frmb-save {
        display:none !important;
    }
</style>
<link href="{{URL::to('/')}}/plugins/Formbuilder/css/formbuilder.css" rel="stylesheet">
<script src="{{URL::to('/')}}/plugins/Formbuilder/js/dustjs-2.7.2/dist/dust-full.min.js"></script>
<script src="{{URL::to('/')}}/plugins/Formbuilder/Formbuilder-settings.js"></script>
<script src="{{URL::to('/')}}/plugins/Formbuilder/js/formbuilder.js"></script>
<script src="{{URL::to('/')}}/plugins/jstepper/jquery.jstepper-1.5.3.min.js"></script>
<script>

    var myForm;
    var PassMark = parseInt($('#pass_mark').val(),10);
    var stepperPointOptions = {allowDecimals:false, minValue:1};
    var parsleyInstance;

    var $preventSingleDoubleQuotes = function(e) {
        var element = e;
        setTimeout(function () {
            element.val(element.val().replace(/['"]/g, ""));
        }, 1);
    };

    // On document ready
    $(function(){

        function loadFromJsonFile() {
            $.getJSON( '{{URL::to('/')}}/plugins/Formbuilder/fake-form-db-vals.json', function(jsonObj){
                var fbOptions = {
                    templateBasePath: '{{URL::to('/')}}/plugins/Formbuilder/templates/assessments/builder',
                    // Provide a dom element the form will be built to
                    // jQuery or simpleDOM elements required
                    targets: $('.formbuilder'),
                    // A callback allowing you to handle saving the form
                    save: function(genFormData){
                        var json_data = JSON.stringify(genFormData);
                        $('#Data').val(json_data);
                    },
                    form_id:  jsonObj.form_id,
                    startingModel: jsonObj.model,

                    // use assessment field types
                    field_types: assessmentFieldTypes
                };

                // Create an instance of form builder
                myForm = new Formbuilder(fbOptions);
            });
        }

        function loadFromDb() {
            var fbOptions = {
                templateBasePath: '{{URL::to('/')}}/plugins/Formbuilder/templates/assessments/builder',
                // Provide a dom element the form will be built to
                // jQuery or simpleDOM elements required
                targets: $('.formbuilder'),
                // A callback allowing you to handle saving the form
                save: function (genFormData) {
                    var json_data = JSON.stringify(genFormData);
                    $('#Data').val(json_data);
                },
                field_types: assessmentFieldTypes
            };

            @if($_mode != 'create')
                var jsonObj = jQuery.parseJSON('{!! optional($moduleAssessment)->data !!}');
                fbOptions.form_id = jsonObj.form_id;
                fbOptions.startingModel = jsonObj.model;
            @else
                fbOptions.startingModel = false;
            @endif

            // Create an instance of form builder
            myForm = new Formbuilder(fbOptions);
            if (PassMark > 0) {
                stepperPointOptions.maxValue = PassMark;
            }

            //parsleyInstance = $('#assessmentForm').parsley();
        }

        $('body').on('keypress', '.question', function() {
            $preventSingleDoubleQuotes($(this));
        }).on('paste', function() {
            $preventSingleDoubleQuotes($(this));
        });
        $('body').on('keypress', '.choicequestion', function() {
            $preventSingleDoubleQuotes($(this));
        }).on('paste', function() {
            $preventSingleDoubleQuotes($(this));
        });

        $('body').on('keyup', '.points', function(e) {
            $(this).jStepper(stepperPointOptions);
            distributeChildrenPoints($(this));
        });

        $('#btnSaveAssessment').click(function(e){
            e.preventDefault();
            $('.frmb-save').trigger('click');

            /*parsleyInstance.validate();
            if (parsleyInstance.isValid()) {
                if (!checkNbCorrectAnswers()) {
                    $('#indicateCorrectAnswersAlert').removeClass('text-info').addClass('text-danger');
                    return false;
                }
                if (PassMark > getTotalQuestionPoints()) {
                    $('#totalPointsAlert').removeClass('text-info').addClass('text-danger');
                    return false;
                }
            }*/
            console.log($('#Data').val());
            $('#assessmentForm').submit();

            return false;
        });

        loadFromDb();

        function getTotalQuestionPoints() {
            var sum = 0;
            $(".points").each(function(){
                sum += +$(this).val();
            });
            return sum;
        }

        function distributeChildrenPoints(el) {
            var curElement = $(el).attr('id');

            var lastUndScorePos = curElement.lastIndexOf('_') + 1;
            var commonNamePart = curElement.substr(0, lastUndScorePos-1);
            var parentPoints = $(el).val();
            var maxAllowablePoints = 0;
            var stepperChoiceOptions = {allowDecimals:false, minValue:0};

            //using common name part, find all checked options
            var selectedChoices = $('input[type="checkbox"][id^="' + commonNamePart +'"][Id*="selected"]:checked');
            var selectedChoicesLen = selectedChoices.length;
            var unselectedChoices = $('input[type="checkbox"][id^="' + commonNamePart +'"][Id*="selected"]:not(:checked)');
            var unselectedChoicesLen = unselectedChoices.length;

            //console.log(curElement, ' ',commonNamePart, ' ', parentPoints, ' ', selectedChoicesLen, ' ', unselectedChoicesLen);
            var $element = $('#' + commonNamePart);
            var choices, correctChoices, correctChoicesLen;
            choices = $($element).find('.choicequestion');
            correctChoices = $($element).find(':checked');
            correctChoicesLen = correctChoices.length;

            //console.log(commonNamePart, ' ', parentPoints, ' ', choices, ' ', correctChoices);

            if (correctChoicesLen > 0) {
                // allow max as calculated divided points
                maxAllowablePoints = parentPoints / correctChoicesLen;
                //console.log('distributed points: ', maxAllowablePoints);
                stepperChoiceOptions.maxValue = maxAllowablePoints;

                correctChoices.each(function(i,o){
                    // if others are checked, they all inherit the same max value
                    var t = $(o).attr('id').replace('selected','Points');
                    var matchingPointsEl = escapeStr(t);
                    $('#'+matchingPointsEl).val(maxAllowablePoints);
                    // trigger change for the plugin to update the model values
                    $('#'+matchingPointsEl).trigger(jQuery.Event('keyup', { keyCode: 13 }));
                    $( "input.choicepoints" ).triggerHandler( "keyup" );
                    $(matchingPointsEl).jStepper(stepperChoiceOptions);
                });
            }

            /*
            if (selectedChoicesLen > 0) {
                // allow max as calculated divided points
                maxAllowablePoints = parentPoints / selectedChoicesLen;

                stepperChoiceOptions.maxValue = maxAllowablePoints;

                //apply for each selected
                selectedChoices.each(function(i,o) {
                    // if others are checked, they all inherit the same max value
                    var t = $(o).attr('id').replace('selected','Points');
                    var matchingPointsEl = escapeStr(t);
                    $('#'+matchingPointsEl).val(maxAllowablePoints);
                    // trigger change for the plugin to update the model values
                    $('#'+matchingPointsEl).trigger(jQuery.Event('keyup', { keyCode: 13 }));
                    $( "input.choicepoints" ).triggerHandler( "keyup" );
                    $(matchingPointsEl).jStepper(stepperChoiceOptions);
                });
            }

            if (unselectedChoicesLen > 0) {
                //apply for each unselected
                unselectedChoices.each(function(i,o) {
                    // if others are checked, they all inherit the same max value
                    var t = $(o).attr('id').replace('selected','Points');
                    var matchingPointsEl = escapeStr(t);
                    // trigger change for the plugin to update the model values
                    $('#'+matchingPointsEl).val(0);
                    $('#'+matchingPointsEl).trigger(jQuery.Event('keyup', { keyCode: 13 }));
                    $( "input.choicepoints" ).triggerHandler( "keyup" );
                    $(matchingPointsEl).jStepper(stepperChoiceOptions);
                });
            }
            */
        }

        function checkNbCorrectAnswers() {
            var res = true;
            var $choiceElements = $('.frmb-form').find('.frmb-choices');
            var nbChoiceQuestions = $choiceElements.length;

            $choiceElements.each(function() {
                var el = $(this);
                var nbUnselected = el.find('.choicecorrect:checked').length;
                if(nbUnselected == 0) {
                    res = false;
                }
            });
            return res;
        }

        /***
         * Escape id or name selectors for jQuery
         * @param str class name to escape for jQuery
         * @returns {*}
         */
        function escapeStr(str) {
            if (str)
                return str.replace(/([ #;?&,.+*~\':"!^$[\]()=>|\/@])/g,'\\$1');

            return str;
        }

    });
</script>

@endsection