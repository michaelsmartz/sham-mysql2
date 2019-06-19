@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'View Absence Type')

@section('modalTitle', 'View Absence Type')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('postModalUrl', '')
@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
        <dl class="dl-horizontal">
            <dt>Description</dt>
            <dd>{{ $absenceType->description }}</dd>
            <dt>Duration Unit</dt>
            <dd>{!! App\Enums\LeaveDurationUnitType::getDescription($absenceType->duration_unit) !!}</dd>
            <dt>Amount Earns</dt>
            <dd>{{ $absenceType->amount_earns }}</dd>
            <dt>Eligibility Begins</dt>
            <dd>{!! App\Enums\LeaveEmployeeGainEligibilityType::getDescription($absenceType->eligibility_begins) !!}</dd>
            <dt>Eligibility Ends</dt>
            <dd>{!! App\Enums\LeaveEmployeeLossEligibilityType::getDescription($absenceType->eligibility_ends) !!}</dd>
            <dt>Accrue Period</dt>
            <dd>{!! App\Enums\LeaveAccruePeriodType::getDescription($absenceType->accrue_period) !!}</dd>
        </dl>
        </div>
    </div>
    @if(!Request::ajax())
    <div class="box-footer">
        @yield('modalFooter') 
    </div>
    @endif
@endsection