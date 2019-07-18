@extends('portal-index')
@section('title','My Team')
@section('subtitle', 'View associated team members (Note : Click on team member to change his/her password)')
<link rel="stylesheet" href="{{URL::to('/')}}/css/myteam.min.css">

@section('content')
    <br>
    <div id="team-list" class="container-fluid panel">
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="pull-right">
                    <i class="glyphicon glyphicon-search"></i> Search  <input type="text" id="search-team">
                    <i class="glyphicon glyphicon-refresh" data-wenk="Reset" id="reset-search"></i>
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
            <a class="row">
                @foreach($employees as $employee)
                    <a href="#light-modal" class="my-team" data-team="{{$employee->first_name}} {{$employee->surname}}" onclick="editForm(@if(!empty($employee->user_id)) {{ $employee->user_id }} @else -1 @endif, event,'my-team');">
                        <div class="col-md-3 col-sm-6" >
                            <div class="our-team">
                                <img src="@if(!empty($employee->picture)){{$employee->picture}} @elseif(strtolower($employee->gender) == 'female') {{asset('/img/female.jpeg')}} @else {{asset('/img/male.jpeg')}} @endif">
                                <div class="team-content">
                                    <h3 class="title">{{$employee->first_name}} {{$employee->surname}}</h3>
                                    <span class="post">{{$employee->job_title}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
            @endforeach
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="{{URL::to('/')}}/js/myteam.min.js"></script>
@endsection
