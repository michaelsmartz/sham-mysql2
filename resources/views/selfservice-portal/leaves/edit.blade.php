@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Leave request from '.$leave->employee)
@section('modalTitle', 'Leave request from '.$leave->employee)

@section('modalFooter')
    <a href="/leaves/status/{{$id}}/{{App\Enums\LeaveStatusType::status_denied}}" data-wenk="Deny leave request" class="btn btn-danger">
       Deny
    </a>
    <a href="/leaves/status/{{$id}}/{{App\Enums\LeaveStatusType::status_approved}}" data-wenk="Approve leave request" class="btn btn-success">
       Approve
    </a>
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
