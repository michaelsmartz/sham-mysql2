@extends('public.layouts.index')
<link href="{{URL::to('/')}}/css/candidate-vacancies.css" rel="stylesheet">

@section('title','Are you looking for a job?');
@if(count($vacancies) > 0)
    @section('subtitle','We have the following job openings:');
@endif

@section('content')
    <main class="grid">
        @forelse($vacancies as $vacancy)
            <article class="card">
                <header>
                    <h4>{{ $vacancy->job_title }}</h4>
                    <time title="Posted">{{ $vacancy->posted_on }}</time>
                </header>
                <section>
                    <div class="desc-wrap">
                        <p><strong>Job Description:</strong></p>
                        <div class="text">
                            <div id="less-{{$vacancy->id}}" class="less">
                                {{ str_limit(strip_tags($vacancy->description), $limit = 450, $end = '...')}}
                            </div>
                            <div id="view_more_{{$vacancy->id}}" class="view_more" onclick="show('more',{{$vacancy->id}})">Read more</div>
                            <div id="more-{{$vacancy->id}}" class="more">
                                {!! $vacancy->description !!}
                            </div>
                            <div id="view_less_{{$vacancy->id}}" class="view_less" onclick="show('less',{{$vacancy->id}})">Show less</div>
                        </div>
                    </div>

                    <table class="table-responsive table-area">
                        <tr>
                            <td class="td_label">Functional Area</td>
                            <td class="td_content"><strong>{{ $vacancy->department->description }}</strong></td>
                        </tr>
                        <tr>
                            <td>Employment Type</td>
                            <td><strong>{{ $vacancy->employeeStatus->description }}</strong></td>
                        </tr>
                    </table>

                    <br>
                    <table class="table-responsive table-requirement">
                        <tr>
                            <td>
                                <svg class="icon" width="35" height="35">
                                    <use xlink:href="#get-money" />
                                </svg>
                            </td>
                            <td class="desc">
                                Salary
                            </td>
                            <td class="desc">
                                @if( !is_null($vacancy->min_salary) && !is_null($vacancy->max_salary))
                                    <strong>{{ $vacancy->min_salary }} - {{ $vacancy->max_salary }}</strong>
                                @else
                                    <strong>Negotiable</strong>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <svg class="icon" width="35" height="35">
                                    <use xlink:href="#skills" />
                                </svg>
                            </td>
                            <td class="desc">
                                Qualification(s) Required
                            </td>
                            <td class="desc">
                                <strong>{{ $vacancy->qualification->description }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <svg class="icon" width="35" height="35">
                                    <use xlink:href="#{{$vacancy->rel_calendar_id}}" />
                                </svg>
                            </td>
                            <td class="desc">
                                Application Deadline
                            </td>
                            <td class="desc">
                                <strong>{{ $vacancy->end_date }}</strong>
                            </td>
                        </tr>
                    </table>
                </section>
                <footer>
                    @if(!isset(Auth::guard('candidate')->user()->id))
                        <a class="button" href="{{ route('candidate.register') }}">Apply</a>
                    @elseif($vacancy->hasApplied)
                        <a class="button" href="#light-modal" onclick="editForm({{$vacancy->id}}, event, 'vacancies/status')">View Applicant Status...</a>
                    @else
                        @if($vacancy->dateOk && $vacancy->canApply)
                            <a class="button" href="#" onclick="editForm({{$vacancy->id}}, false, 'vacancies/apply')">Apply</a>
                        @endif
                    @endif
                </footer>
            </article>
        @empty
            <article class="card">
                <section>
                    <p>
                        There are no job openings at the moment
                    </p>
                </section>
            </article>
        @endforelse
    </main>
@endsection

@section('scripts')
    <script src="{{asset('js/grindstone.min.js')}}"></script>
    <script type="text/javascript">

        window.loadUrl = function(url) {
            var ret = false;
            $(".light-modal-heading").empty().html('');
            $(".light-modal-footer .buttons").empty().html('');
            $(".light-modal-body").empty().html('Loading...please wait...');
            $('').ajax({ method: 'GET', url: url, dataType: 'json'  }).then(function(data) {
                $(".light-modal-heading").empty().html(data.title);
                $(".light-modal-body").empty().html(data.content);
                $(".light-modal-footer .buttons").empty().html(data.footer);

                ret = true;

            }).catch(function() {
                //alerty.alert("An error has occurred. Please try again!",{okLabel:'Ok'});
            });
            return ret;
        };

        window.editForm = function(id, event, baseUrl) {
            var route;
            if (baseUrl === void 0) {
                route = '{{url()->current()}}/';
            } else {
                route = '{{URL::to('/')}}/' + baseUrl + '/';
            }

            if (event) {
                loadUrl(route + id );
            } else {
                window.location = route + id;
            }
        };

        $('.more,.view_less').hide();

        function show(mode,id)
        {
            if(mode === 'less'){
                $('#more-'+id).hide();
                $('#less-'+id).show();
                $('#view_more_'+id).show();
                $('#view_less_'+id).hide();
            }else{
                $('#more-'+id).show();
                $('#less-'+id).hide();
                $('#view_more_'+id).hide();
                $('#view_less_'+id).show();
            }
        }
    </script>
@endsection
