<legend><i class="glyphicon glyphicon-warning-sign"></i>  Pending requests</legend>
<div>
    @foreach($pending_request as $request)
        <div class="card text-justify">
            <div class="container-fluid card-body bg-danger pending-request">
                <p class="card-text"><b>{{$request->absence_description}}</b> request from <b>{{$request->employee}}</b></p>
                <div class="small">From <b>{{$request->starts_at}}</b> to <b>{{$request->ends_at}}</b></div>
            </div>
        </div>
    @endforeach


</div>