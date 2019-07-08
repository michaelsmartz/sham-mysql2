@extends('portal-index')
@section('title','Vacancies')
@section('subtitle','List of internal vacancies')

@section('scripts')
    <link href="{{URL::to('/')}}/css/nice-select.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/vacancies.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/jquery.nice-select.min.js"></script>
    <script>
        $(document).ready(function(){
            if(document.getElementById("selects")){
                $('select').niceSelect();
            };
        });
    </script>
@endsection

@section('content')
    @if (!empty($warnings))
        <div class="col-xs-12 alert alert-danger">
            <i class="glyphicon glyphicon-exclamation-sign"></i>
            @foreach($warnings as $index => $warning)
                <div>{{$warning}}</div>
                @if($index<count($warnings)-1))<br>@endif
            @endforeach
        </div>
    @endif
        <div class="banner-content col-lg-12">
            <form action="" class="search-form-area">
                <div class="row justify-content-center form-wrap">
                    <div class="col-lg-3 form-cols">
                        <input type="text" class="form-control datepicker" name="search_closing_date" placeholder="Search Closing Date">
                    </div>
                    <div class="col-lg-4 form-cols">
                            <div class="default-select" id="selects">
                            <select>
                                <option value="0">All Qualifications</option>
                                @if( sizeof($jobQualifications) != 0)
                                    @foreach($jobQualifications as $id => $jobQualification)
                                        <option value="{{ $id }}">{{ $jobQualification }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 form-cols">
                        <div class="default-select" id="selects">
                            <select>
                                <option value="0">All Departments</option>
                                @if( sizeof($jobDepartments) != 0)
                                    @foreach($jobDepartments as $id => $jobDepartment)
                                        <option value="{{ $id }}">{{ $jobDepartment }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 form-cols">
                        <button type="button" class="btn btn-info">
                           Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <section class="post-area section-gap">
            <div class="container">
                <div class="row justify-content-center d-flex">
                    <div class="col-lg-12 post-list">
                        <ul class="cat-list">
                            @if( sizeof($jobStatuses) != 0)
                                @foreach($jobStatuses as $jobStatus)
                                    <li><a href="#">{{ $jobStatus->description }}</a></li>
                                @endforeach
                            @endif
                        </ul>

                        @if( sizeof($vacancies) == 0)
                        <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 text-success">
                            There are no vacancies available for the moment
                        </div>
                        @else
                        @foreach($vacancies as $vacancy)
                            <div class="single-post d-flex flex-row">
                                <div class="thumb">
                                    <img src="{{URL::to('/')}}/img/job.png" alt="">
                                    <ul class="tags">
                                        @if( !is_null($vacancy->skills))
                                            @foreach($vacancy->skills as $skill)
                                                <li><a href="">{{ $skill->description }}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="details">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <p class="pull-right">{{ $vacancy->posted_on }}</p>
                                        <div class="titles">
                                            <a href=""><h4>{{ $vacancy->job_title }}</h4></a>
                                            <h6>{{ $vacancy->department->description }}</h6>
                                        </div>
                                    </div>
                                    <p>
                                        {{ $vacancy->description }}
                                    </p>
                                    <h5><span class="glyphicon glyphicon-briefcase"></span> Employment Type: {{ $vacancy->employeeStatus->description }}</h5>
                                    <h5><span class="glyphicon glyphicon-education"></span> Qualification Required: {{ $vacancy->qualification->description }}</h5>
                                    <h5><span class="glyphicon glyphicon-time"></span> Closing on: {{ $vacancy->start_date }}</h5>
                                    @if( !is_null($vacancy->min_salary) && !is_null($vacancy->max_salary))
                                    <p class="address"><span class="glyphicon glyphicon-piggy-bank"></span>  {{ $vacancy->min_salary }} - {{ $vacancy->max_salary }}</p>
                                    @endif
                                    <ul class="btns pull-right"><li><a href="#">Apply</a></li></ul>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
@endsection
