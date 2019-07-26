@extends('portal-index')
@section('title','Vacancies')
@section('subtitle','List of internal vacancies')

@section('scripts')
    <link href="{{URL::to('/')}}/css/nice-select.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/vacancies.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/jquery.nice-select.min.js"></script>
    <script>

        if($('#my-vacancies').length){
            $("input[name='_method']").val('POST');
        }

        $('.loader').hide();
        $(document).ready(function(){
            if(document.getElementById("selects")){
                $('select').niceSelect();
            };

            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();
                $('.loader').show();
                let url = $(this).attr('href');
                getVacancies(url);
                window.history.pushState("", "", url);
            });

        });

        //disable button till page is fully loaded
        window.addEventListener("load", function(event) {
            $('.details .btns').removeClass('isDisabled');
            $('.details .btns li a').removeClass('isDisabled');
        });

        function getVacancies(url) {
            $.ajax({
                url : url
            }).done(function (data) {
                $('.vacancies').html(data);
                $('.loader').hide();
                //hide show less on pagination
                show('less');
                $('.details .btns').removeClass('isDisabled');
                $('.details .btns li a').removeClass('isDisabled');
            }).fail(function () {
                alert('Vacancies could not be loaded.');
            });
        }

        function applyVacancy(recruitment_id, job_title, page, event){
            //disable action till page is fully loaded
           if(event.target.className != 'isDisabled') {
                var vm = this;

                alerty.confirm(
                    "Are you sure you want to <strong class='text-danger'> apply </strong> for <strong class='text-danger'>" + job_title + "</strong> position?<br>", {
                        okLabel: '<a class="text-danger" href="#light-modal">Yes</a>',
                        cancelLabel: 'No'
                    },
                    function () {
                        window.loadUrl('my-vacancies/' + recruitment_id + '/salary-expectation/'+ page + '/apply');
                    }
                );
            }
        }

        function loadCandidateStatus(recruitment_id, candidate_id){
            window.loadUrl('my-vacancies/' + recruitment_id + '/status/'+ candidate_id + '/apply');
        }

        $('.more,.view_less').hide();

        function show(mode,id=null)
        {
            if(id) {
                if (mode === 'less') {
                    $('#more-' + id).hide();
                    $('#less-' + id).show();
                    $('#view_more_' + id).show();
                    $('#view_less_' + id).hide();
                } else {
                    $('#more-' + id).show();
                    $('#less-' + id).hide();
                    $('#view_more_' + id).hide();
                    $('#view_less_' + id).show();
                }
            }else{
                if (mode === 'less') {
                    $('.more').hide();
                    $('.less').show();
                    $('.view_more').show();
                    $('.view_less').hide();
                }
            }
        }
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
            <form method="GET" action="{{route('my-vacancies.index')}}" class="search-form-area">
                <div class="row justify-content-center form-wrap">
                    <div class="col-lg-3 form-cols">
                        <input type="text" class="form-control datepicker"
                               value="{{ ($closing_date) ? $closing_date : '' }}"
                               name="closing_date" placeholder="Search Closing Date">
                    </div>
                    <div class="col-lg-4 form-cols">
                            <div class="default-select" id="selects">
                            <select id="qualification" name="qualification">
                                <option value="0">All Qualifications</option>
                                @if(sizeof($jobQualifications) != 0)
                                    @foreach($jobQualifications as $id => $jobQualification)
                                        <option value="{{ $id }}" {{ $qualification == $id ? 'selected' : '' }}>
                                            {{ $jobQualification }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 form-cols">
                        <div class="default-select" id="selects">
                            <select id="department" name="department">
                                <option value="0">All Departments</option>
                                @if(sizeof($jobDepartments) != 0)
                                    @foreach($jobDepartments as $id => $jobDepartment)
                                        <option value="{{ $id }}" {{ $department == $id ? 'selected' : '' }}>
                                            {{ $jobDepartment }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 form-cols">
                        <button type="submit" class="btn btn-info">
                           Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <section id="my-vacancies" class="post-area section-gap">
            <div class="container">
                <div class="row justify-content-center d-flex">
                    <div class="col-lg-12 post-list">
                        <ul class="cat-list">
                            @if(is_array($jobStatuses) && sizeof($jobStatuses) != 0)
                                @foreach($jobStatuses as $jobStatus)
                                    <li>
                                        <a href="{{route('my-vacancies.index')}}?search_employee_status={{ $jobStatus->id }}">{{ $jobStatus->description }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div id="load" style="position: relative;">
                            @if(is_array($vacancies) && sizeof($vacancies) == 0)
                                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 text-success">
                                    There are no vacancies available for the moment
                                </div>
                            @else
                                <section class="vacancies">
                                 @include('selfservice-portal.vacancies.load')
                                </section>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
