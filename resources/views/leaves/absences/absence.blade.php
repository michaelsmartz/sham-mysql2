<section>
    <br>
    @include('leaves.absences.filter')
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
                        <td>{{$leave->starts_at}}</td>
                        <td>{{$leave->ends_at}}</td>
                        <td class="center">
                            @switch($leave->status)
                                @case(3)
                                <span class="badge badge-status badge-secondary">Cancelled</span>
                                @break

                                @case(2)
                                <span class="badge badge-status badge-danger">Denied</span>
                                @break

                                @case(1)
                                <span class="badge badge-status badge-success">Approved</span>
                                @break

                                @default
                                <span class="badge badge-status badge-warning">Pending</span>
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

