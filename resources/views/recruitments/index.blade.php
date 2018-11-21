@extends('portal-index')
@section('title','Recruitment Pipeline')
@section('content')
    <br>
    <ul class="nav steps">
        <li class="orange">
            <a href="#applied" data-toggle="tab"><h3>4</h3><small>Applied</small></a>
        </li>
        <li class="orange">
            <a href="#review" data-toggle="tab"><h3>3</h3><small>Review</small></a>
        </li>
        <li>
            <a href="#interviewing" data-toggle="tab"><h3>3</h3><small>Interviewing</small></a>
        </li>
        <li>
            <a href="#offer" data-toggle="tab"><h3>2</h3><small>Offer</small></a>
        </li>
        <li>
            <a href="#contract" data-toggle="tab"><h3>1</h3><small>Contract</small></a>
        </li>
        <li>
            <a href="#hired" data-toggle="tab"><h3>1</h3><small>Hired</small></a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane" id="applied">
            <h1>contents of step 1</h1>
        </div>
        <div class="tab-pane" id="review">contents of step 2</div>
        <div class="tab-pane" id="interviewing">contents of step 3</div>
        <div class="tab-pane" id="offer">contents of step 4</div>
        <div class="tab-pane" id="contract">contents of step 5</div>
        <div class="tab-pane" id="hired">contents of step 6</div>
    </div>
@endsection
@section('post-body')
<link href="{{URL::to('/')}}/css/nav-wizard.min.css" rel="stylesheet">
@endsection