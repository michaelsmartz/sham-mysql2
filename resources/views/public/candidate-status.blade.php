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
        </div>
    </div>
    <div class="history-container">
        <ul class="tl">
            @foreach($recruitment->trackCandidateStatus as $cdt)
                @if($cdt->pivot->status == 0)
                    <li>
                        <div class="item-detail">
                            {!! App\Enums\CandidateStatusType::getDescription($cdt->pivot->status) !!}
                        </div>
                    </li>
                @endif
                @if($cdt->pivot->status == 1)
                    @foreach($candidate->interviews as $interview)
                        <li>
                            <div class="timestamp">
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$interview->pivot->schedule_at)->format('jS F Y')}}
                                <br>
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$interview->pivot->schedule_at)->format('\a\t h:i:s A')}}
                            </div>
                            <div class="item-title">{{$interview->description}} interview</div>
                            <div class="item-detail">A <strong>{{$interview->description}}</strong> interview has been scheduled for you</div>
                        </li>
                    @endforeach
                @endif
                @if($cdt->pivot->status == 2)
                    <li>
                        <div class="item-detail">You made it past the interview(s)</div>
                    </li>
                    <li>
                        <div class="item-title">
                            {!! App\Enums\CandidateStatusType::getDescription($cdt->pivot->status) !!}
                        </div>
                        <div class="item-detail">An offer is in the pipeline</div>
                    </li>
                @endif
            @endforeach
        </ul>
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