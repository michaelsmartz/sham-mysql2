@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'View leave Type')

@section('modalTitle', 'View leave Type')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
@endsection

@section('postModalUrl', '')
@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
        <dl class="dl-horizontal">
            <dt>Description</dt>
            <dd>{{ $data->description }}</dd>
            <dt>Duration Unit</dt>
            <dd>{!! App\Enums\LeaveDurationUnitType::getDescription($data->duration_unit) !!}</dd>
            <dt>Colour Code</dt>
            <dd>
                <div class="pickr">
                    <div class="pcr-button" style="cursor:default;color:{!! optional($data->colour)->code !!};"></div>
                </div>
                
            </dd>
            <dt>Amount Earns</dt>
            <dd>{{ $data->amount_earns }}</dd>
            <dt>Eligibility Begins</dt>
            <dd>{!! App\Enums\LeaveEmployeeGainEligibilityType::getDescription($data->eligibility_begins) !!}</dd>
            <dt>Eligibility Ends</dt>
            <dd>{!! App\Enums\LeaveEmployeeLossEligibilityType::getDescription($data->eligibility_ends) !!}</dd>
            <dt>Accrue Period</dt>
            <dd>{!! App\Enums\LeaveAccruePeriodType::getDescription($data->accrue_period) !!}</dd>
            <dt>Apply To Job Titles</dt>
            <dd>
                @forelse($data->jobTitles as $jobTitle)
                        <span class="badge badge-info">{{ $jobTitle->description }}</span>
                @empty
                        <span class="badge badge-info">All</span>
                @endforelse
            </dd>
            <dt>Includes Non-working Days?</dt>
            <dd>{!! ($data->non_working_days) ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-default">No</span>'  !!}</dd>
        </dl>
        </div>
    </div>
    @if(!Request::ajax())
    <div class="box-footer">
        @yield('modalFooter') 
    </div>
    @endif
@endsection