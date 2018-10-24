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
                    |  <strong>Assessment Response Date:</strong> {{$moduleAssessmentResponses[0]->moduleAssessmentResponse->date_completed}}
                    |  <strong>Passmark:</strong> {{$moduleAssessment->pass_mark}}
                </h5>
            </span>
        </div>
    </div>
    <ul class="list-group">
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
</ul>

    @if(!Request::ajax())
    <div class="box-footer">
        @yield('modalFooter') 
    </div>
    @endif
@endsection