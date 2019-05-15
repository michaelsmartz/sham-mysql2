<section>
    <br>
    @include('selfservice-portal.leaves.absences.filter')
    @if(count($leaves)>0)
        <div class="container-fluid panel">
            <legend><i class="glyphicon glyphicon-list"></i>  History</legend>
            <table class="table table-striped table-bordered" id="table-leaves">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Leave type</th>
                    <th scope="col">Starts on</th>
                    <th scope="col">Ends on</th>
                    <th scope="col">Status</th>
                    <th scope="col">Taken</th>
                    <th scope="col">Balance</th>
                    <th scope="col">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leaves as $leave)
                    <tr class="data-history">
                        <td>{{$leave->absence_description}}</td>
                        <td>{{\Carbon\Carbon::parse($leave->starts_at)->format('Y-m-d H:i')}}</td>
                        <td>{{\Carbon\Carbon::parse($leave->ends_at)->format('Y-m-d H:i')}}</td>
                        <td class="center">
                            @switch($leave->status)
                                @case(App\Enums\LeaveStatusType::status_cancelled)
                                <span class="badge badge-status badge-secondary">
                                    {{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_cancelled)}}
                                </span>
                                @break

                                @case(App\Enums\LeaveStatusType::status_denied)
                                <span class="badge badge-status badge-danger">
                                    {{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_denied)}}
                                </span>
                                @break

                                @case(App\Enums\LeaveStatusType::status_approved)
                                <span class="badge badge-status badge-success">
                                    {{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_approved)}}
                                </span>
                                @break

                                @default
                                <span class="badge badge-status badge-warning">
                                    {{App\Enums\LeaveStatusType::getDescription(App\Enums\LeaveStatusType::status_pending)}}
                                </span>
                            @endswitch
                        </td>
                        <td>{{number_format($leave->taken,1)}}</td>
                        <td>{{number_format($leave->remaining,1)}}</td>
                        <td>
                            <a href="/leaves/status/{{$leave->id}}/3" data-wenk="Cancel leave request" class="btn btn-secondary">
                                Cancel
                            </a>
                            <a href="/leaves/status/{{$leave->id}}/2" data-wenk="Deny leave request" class="btn btn-danger">
                                Denny
                            </a>
                            <a href="/leaves/status/{{$leave->id}}/1" data-wenk="Approve leave request" class="btn btn-success">
                               Approve
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="container-fluid panel">
            <div class="text-success">Currently, there are no leave types allocated to you</div>
        </div>
    @endif
    @component('partials.index')
    @endcomponent
</section>

