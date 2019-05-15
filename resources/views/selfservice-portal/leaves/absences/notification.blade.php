<legend><i class="glyphicon glyphicon-warning-sign"></i>  Pending requests</legend>
<div>
    @foreach($leaves as $leave)
        <div class="card text-justify">
            <div class="container-fluid card-body bg-danger pending-request">
                <p class="card-text"><b>{{$leave->absence_description}}</b> request from <b>Tom X</b></p>
                <div class="small">From <b>{{$leave->starts_at}}</b> to <b>{{$leave->ends_at}}</b></div>
            </div>
        </div>
    @endforeach


</div>