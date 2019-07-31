@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Leave request from '.$leave->employee)
@section('modalTitle', 'Leave request from '.$leave->employee)

@section('modalFooter')
    @if((date($leave->starts_at) >= date("Y-m-d H:i")) && ($leave->status == App\Enums\LeaveStatusType::status_pending || $leave->status == App\Enums\LeaveStatusType::status_approved))
        <a href="/my-leaves/status/{{$leave->id}}/{{App\Enums\LeaveStatusType::status_cancelled}}" data-wenk="Cancel leave request" class="btn btn-cancel">
            Cancel
        </a>
    @endif
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Close</a>
@endsection


@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            <div class="row container-fluid">
                <legend><i class="glyphicon glyphicon-stats"></i> {{$leave->absence_description}}</legend>
                <div class="form-group col-sm-4">
                    <label class="control-label">Total</label>
                    <div class="">
                        <span class="field">{{$leave->total}}</span>
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label class="control-label">Taken</label>
                    <div class="">
                        <span class="field">{{$leave->taken}}</span>
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label class="control-label">Remaining</label>
                    <div class="">
                        <span class="field">{{$leave->remaining}}</span>
                    </div>
                </div>
            </div>
            <div class="row container-fluid">
                <legend><i class="glyphicon glyphicon-calendar"></i> Date</legend>
                <div class="form-group col-sm-4">
                    <label class="control-label">From</label>
                    <div class="">
                        <span class="field">{{\Carbon\Carbon::parse($leave->starts_at)->format('l Y-m-d H:i')}}</span>
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label class="control-label">To</label>
                    <div class="">
                        <span class="field">{{\Carbon\Carbon::parse($leave->ends_at)->format('l Y-m-d H:i')}}</span>
                    </div>
                </div>
            </div>
            @if(!empty($leave->comments))
                <div class="row container-fluid">
                    <legend><i class="glyphicon glyphicon-pencil"></i> Comments</legend>
                    <div class="form-group col-sm-12">
                        {!! $leave->comments !!}
                    </div>
                </div>
            @endif
            @if(!empty($leave->download_link))
                <div class="row container-fluid">
                    <legend><i class="glyphicon glyphicon-file"></i> Attachment</legend>
                    <div class="form-group col-sm-12">
                        <a href="{{$leave->download_link}}" download>
                            <i class="fa fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endif
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
