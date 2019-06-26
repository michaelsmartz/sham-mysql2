<section>
    @foreach($eligibility as $eligible)
            <div style="display:none;">{!! $eligible->pending = number_format((float)($eligible->pending/9), 2, '.', '');; !!}</div>
            <div class="dashboard_wid_box  1 emp_total" style="background: {{$eligible->code}}">
                <h4 data-wenk="Remaining : {{$eligible->remaining}} Total: {{$eligible->total}}">
                    <div class="box_count_tol emp_total">{{$eligible->remaining}}</div>{{$eligible->absence_description}} ({{App\Enums\LeaveDurationUnitType::getDescription($eligible->duration_unit)}})
                </h4>
                <a class="cls_redirect">
                    <div class="dashboard_wid_box_inner">Taken<span class="box_count">{{$eligible->taken}}</span></div>
                </a>
                <a class="cls_redirect">
                    <div class="dashboard_wid_box_inner last-child">Pending<span class="box_count">{{$eligible->pending}}</span></div>
                </a>
                <div class="row">
                    <a id="request_leave_{{$eligible->id}}" href="#light-modal" data-wenk="{{$eligible->absence_description}} application form" data-description="{{$eligible->absence_description}}" data-type-id="{{$eligible->id}}" class="btn btn-primary btn-apply" onclick="addFormType(event, '{{$eligible->id }}','{{ $eligible->absence_description }}', '{{ $selected['employee']->id}}', 'leaves')">
                        <i class="glyphicon glyphicon-plane"></i>  Apply
                    </a>
                </div>
            </div>
    @endforeach
</section>




