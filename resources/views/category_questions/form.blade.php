@if((isset($categoryQuestion))&& $categoryQuestion->isCategoryQuestionInUse())
    <div class="alert alert-danger" style="margin-bottom: 0px;">
        <p>This Category Question is already in use and cannot be edited.</p>
    </div>
    <br>
@endif
<div class="row">
    
<div class="form-group col-xs-12 {{ $errors->has('category_question_type_id') ? 'has-error' : '' }}">
    <label for="category_question_type_id">Question Type</label>
        <select class="form-control" id="category_question_type_id" name="category_question_type_id" required="true">
        	    <option value="" style="display: none;" {{ old('category_question_type_id', optional($categoryQuestion)->category_question_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>Question Type</option>
        	@foreach ($categoryQuestionTypes as $key => $categoryQuestionType)
			    <option value="{{ $key }}" {{ old('category_question_type_id', optional($categoryQuestion)->category_question_type_id) == $key ? 'selected' : '' }}>
			    	{{ $categoryQuestionType }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('category_question_type_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title">Question</label>
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($categoryQuestion)->title) }}" minlength="1" maxlength="1024" required="true" placeholder="Enter title">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description">Description</label>
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($categoryQuestion)->description) }}" maxlength="1024" placeholder="Enter description">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('points') ? 'has-error' : '' }}">
    <label for="points">Points</label>
        <input class="form-control" name="points" type="number" id="points" value="{{ old('points', optional($categoryQuestion)->points) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter points">
        {!! $errors->first('points', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-xs-12 {{ $errors->has('is_zeromark') ? 'has-error' : '' }}">
    <label for="is_zeromark">Auto Fail Question</label>
        <div class="checkbox">
            <label for="is_zeromark_1">
            	<input id="is_zeromark_1" class="" name="is_zeromark" type="checkbox" value="1" {{ old('is_zeromark', optional($categoryQuestion)->is_zeromark) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('is_zeromark', '<p class="help-block">:message</p>') !!}
</div>

</div>

<?php if (isset($categoryquestionchoices)&& count($categoryquestionchoices)>0): ?>
<div class="form-group choicegroup">
    <div class="row">
        <div class="col-xs-12">
            <h4>Choices</h4>
        </div>
    </div>
</div>
@foreach($categoryquestionchoices as $key=>$categoryquestionchoice)
    <div class="form-group choicegroup">
        <div class="row">
            <div class="col-xs-1 hide">
                {!! Form::text('Choices['.$key.'][Id1]',$categoryquestionchoice->id,['class'=>'form-control hide', 'autocomplete'=>'off', 'placeholder'=>'']) !!}
            </div>
            <div class="col-xs-5">
                {!! Form::text('Choices['.$key.'][Choice]',$categoryquestionchoice->choice_text,['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Choice']) !!}
            </div>
            <div class="col-xs-2">
                {!! Form::text('Choices['.$key.'][Point]',$categoryquestionchoice->points,['class'=>'form-control choice_points', 'autocomplete'=>'off', 'placeholder'=>'Points']) !!}
            </div>
            <div class="col-xs-1">
                <button type="button" class="btn btn-default addQualButton"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>

@endforeach
<?php else: ?>
<div class="form-group choicegroup" id="questionChoices">
    <div class="row">
        <div class="col-xs-12">
            <h4>Choices</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-1 hide">
            {!! Form::text('Choices[0][Id1]',(Request::has('Ids[0][Id1]')?Request::input('Ids[0][Id1]'):null),['class'=>'form-control hide', 'autocomplete'=>'off', 'placeholder'=>'']) !!}
        </div>
        <div class="col-xs-5">
            {!! Form::text('Choices[0][Choice]',(Request::has('Choices[0][Choice]')?Request::input('Choices[0][Choice]'):null),['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Choice']) !!}
        </div>
        <div class="col-xs-2">
            {!! Form::text('Choices[0][Point]',(Request::has('Choices[0][point]')?Request::input('Choices[0]Point'):null),['class'=>'form-control choice_points', 'autocomplete'=>'off', 'placeholder'=>'Points']) !!}
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-default addQualButton"><i class="fa fa-plus"></i></button>
        </div>
    </div>
</div>
<?php endif; ?>



<div class="form-group hide choicegroup" id="qualificationTemplate">
    <div class="row">
        <div class="col-xs-1 hide">
            {!! Form::text('Id1',null,['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Points']) !!}
        </div>
        <div class="col-xs-5">
            {!! Form::text('Choice',null,['class'=>'form-control', 'autocomplete'=>'off', 'placeholder'=>'Choice']) !!}
        </div>
        <div class="col-xs-2">
            {!! Form::text('ChoicePoint',null,['class'=>'form-control choice_points', 'autocomplete'=>'off', 'placeholder'=>'Points']) !!}
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-default removeQualButton"><i class="fa fa-minus"></i></button>
        </div>
    </div>
</div>

<div class="form-group hide">
    <div class="row">
        <div class="col-xs-1">
            {!! Form::text('Indicator',null,['class'=>'form-control','disabled']) !!}
        </div>
    </div>
</div>

@section('post-body')
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/plugins/alerty/alerty.min.css">
    <script src="{{url('/')}}/plugins/alerty/alerty.min.js"></script>

    <script>
        $(document).ready(function() {

            // Define function showhide
            $.showhide = function()
            {
                var questiontype = $("#category_question_type_id option:selected").text();

                if($.trim(questiontype) == 'Open Text' || questiontype == 'Question Type')
                {
                    //$('#questionChoices').hide();
                    $('.choicegroup').hide();
                    $('input[name=Indicator]').val("HIDE");
                    $(".choicegroup :input").prop('required',false);
                }
                else
                {

                    //$('#questionChoices').show();
                    $('.choicegroup').show();
                    $('input[name=Indicator]').val("SHOW");
                    $(".choicegroup :input").prop('required',true);
                    $(".hide :input").prop('required',false);
                    if($(".choicegroup :input").hasClass( "hide" )){
                        $(".choicegroup .hide").prop('required',false);
                    }
                }
            };

            // calling function showhide on documentready.
            $.showhide();

            // Attaching function showhide to changeevent of CategoryQuestionTypeId
            $("#category_question_type_id").change($.showhide);
        });



        var qualIndex = {{(isset($employee->Qualifications))?count($employee->Qualifications)-1:0 }} ;;
        qualIndex = {{(isset($categoryquestionchoicesCount))?$categoryquestionchoicesCount:0 }} ;
        var skillIndex = {{(isset($employee->Skills))?count($employee->Skills)-1:0 }} ;

        $('.addQualButton').click(function() {

            qualIndex++;
            var $template = $('#qualificationTemplate'),
                    $clone    = $template
                            .clone()
                            .removeClass('hide')
                            .removeAttr('id')
                            .attr('data-qual-index', qualIndex)
                            .attr('data-qual-index', qualIndex)
                            .insertBefore($template);

            // Update the name attributes
            $clone
                    .find('[name="Choice"]').attr('name', 'Choices[' + qualIndex + '][Choice]').end()
                    .find('[name="ChoicePoint"]').attr('name', 'Choices[' + qualIndex + '][Point]').end()
                    .find('[name="Id1"]').attr('name', 'Choices[' + qualIndex + '][Id1]').end();

            $clone.find('.removeQualButton').click(function(){
                var $row  = $(this).parents('.form-group'),
                        index = $row.attr('data-qual-index');
                $row.remove(); });
        });

        $('.choicegroup input').blur(function()
        {
            if($(this).val()) {
                $(this).prop('required',false);
            }
        });

        function sumPoints(arr){
            var Points = $('#points').val();

            var tot=0;
            for(var i=0;i<arr.length;i++){
                if(parseInt(arr[i].value)) {
                    tot += parseInt(arr[i].value);
                }
            }

            //console.log(tot);
            //console.log(Points);

            if(tot > Points){
                alerty.toasts('Choices points cannot be greater than Category question points!',
                    {bgColor:'#b94a48',time:5000});
                event.preventDefault();
            }

            if( $('.choicegroup input').val() !== '') {
                $(this).prop('required',false);
            }
        }

        $("#edit_category_question_form").submit(function( event ) {
            var arr = $('#edit_category_question_form .choicegroup .choice_points')
            sumPoints(arr);
        });

        $("#create_category_question_form").submit(function( event ) {
            var arr = $('#create_category_question_form .choicegroup .choice_points')
            sumPoints(arr);
        });

    </script>
@endsection