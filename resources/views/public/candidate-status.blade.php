@extends('blank')
@section('title', 'Applicant Status')

@section('modalTitle', 'Applicant Status')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            <strong>{{$recruitment->trackCandidateStatus[0]->first_name}}</strong>, keep checking this spot for more updates.
            Below is the progress so far:
        </div>
        <div class="col-sm-12">
            <div class="history-container">
            <ul class="tl">
                @foreach($recruitment->trackCandidateStatus as $candidate)
                    <li><div class="item-detail">{!! App\Enums\CandidateStatusType::getDescription($candidate->pivot->status) !!}</div></li>
                @endforeach
            </ul>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            @yield('modalContent')
        </div>
        <div class="box-footer">
            @yield('modalFooter')
        </div>
    </div>
@endsection