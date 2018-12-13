<div class="row">
	<div class="col-xs-12">
		<span>
			<strong>{{$moduleAssessment->description}}</strong> 
			<h5> <strong>Assessment Type:</strong> {{$moduleAssessment->assessmentType->description}}
				|  <strong>Assessment Response Date:</strong> {{$data->date_completed}}
				|  <strong>Passmark:</strong> {{$moduleAssessment->pass_mark}}
			</h5>
		</span>
	</div>
</div>

{!! Form::hidden('is_reviewed', "1") !!}

<ul class="questions">
	@if(count($moduleAssessmentResponses) >0)
	@forelse($moduleAssessmentResponses as $responseDetail)
		<li class="question-container">
			<div class="row">
				<div class="col-xs-9">
					<strong class="text-danger">{{$responseDetail->title}}</strong>
				</div>
				<div class="col-xs-3 text-right">
					@if($responseDetail->module_question_type_id != App\Enums\ModuleQuestionType::OpenText)
						<span class="disabled-score-box">{{$responseDetail->points}}</span>
					@else
						<input type="hidden" name="responseDetail[{{$loop->index}}][id]" value="{{$responseDetail->id}}">
						<input name="responseDetail[{{$loop->index}}][points]" style="width:48px" type="number" min="0" max="{{$responseDetail->question_points}}"
								value="{{$responseDetail->points}}">
					@endif
					<strong class="text-danger">of {{$responseDetail->question_points}} marks</strong>
				</div>
			</div>
			<div class="row" style="padding-top:5px; padding-bottom:5px;">
				<div class="col-xs-12">
					<strong>Candidate&apos;s response: </strong>
				</div>
				<div class="col-xs-12">
					@if($responseDetail->module_question_type_id == App\Enums\ModuleQuestionType::OpenText)
						<div class="col-xs-12">
							<p class="text-justify" style="margin-left:5px;">{{$responseDetail->response}}</p>
						</div>
					@else
						@php
							$responses = explode('|', $responseDetail->response);
						@endphp
						@foreach($responses as $response)
							<div class="col-xs-6 col-md-3">
								{{$response}}
							</div>
						@endforeach
					@endif

				</div>
			</div>
			@if($responseDetail->module_question_type_id != App\Enums\ModuleQuestionType::OpenText)
				<div class="row" style="padding-top:5px; padding-bottom:5px;">
					<div class="col-xs-12">
						<strong>Question choices: </strong>
					</div>
					<div class="col-xs-12">
						@php
							$choices = explode('|', $responseDetail->question_choices);
							$choicePoints = explode('|', $responseDetail->question_choices_points);
						@endphp
						@for($i = 0; $i < sizeof($choices); $i++)
							<div class="col-xs-6 col-md-3">
								<strong>{{$choices[$i]}}</strong>
								@if($choicePoints[$i] > 0)
									<span class="label label-success">Correct</span>
								@else
									<span class="label label-danger">Incorrect</span>
								@endif
							</div>
						@endfor
					</div>
				</div>
			@endif
		</li>
	@empty
	@endforelse
	@endif
</ul>