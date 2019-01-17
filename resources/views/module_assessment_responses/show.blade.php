@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Reviewed Assessment Response')

@section('modalTitle', 'Reviewed Assessment Response')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('postModalUrl', '')
@section('modalContent')
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
    <ul class="list-group">
    @if(count($moduleAssessmentResponses) >0)
    @forelse($moduleAssessmentResponses as $responseDetail)
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-9">
                    <strong class="text-danger">{{$responseDetail->title}}</strong>
                </div>
                <div class="col-xs-3 text-right">
                    <span class="disabled-score-box">{{$responseDetail->points}}</span>
                    <strong class="text-danger">of {{$responseDetail->question_points}} marks</strong>
                </div>
            </div>
        </li>
	@empty
	@endforelse
    @endif
    </ul>

    @if(count($moduleAssessmentResponsesTrashed) >0)
    <fieldset>
        <legend>History Assessment Responses</legend>
        <ul class="list-group">
            @forelse($moduleAssessmentResponsesTrashed as $responseDetailTrashed)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-9">
                            <strong class="text-danger">{{$responseDetailTrashed->title}}</strong>
                        </div>
                        <div class="col-xs-3 text-right">
                            <span class="disabled-score-box">{{$responseDetailTrashed->points}}</span>
                            <strong class="text-danger">of {{$responseDetailTrashed->question_points}} marks</strong>
                        </div>
                    </div>
                </li>
            @empty
            @endforelse
        </ul>
    </fieldset>
    @endif

    @if(!Request::ajax())
    <div class="box-footer">
        @yield('modalFooter') 
    </div>
    @endif
@endsection