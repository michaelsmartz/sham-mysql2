<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Smartz Human Asset Management software (c) Kalija Global">
        <meta name="author" content="Kalija Global">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Smartz Human Asset Management</title>
        <link href="{{URL::to('/')}}/css/public-vacancies.css" rel="stylesheet">

        <script type="text/javascript">
            function RevealHiddenOverflow(d)
            {
                if( d.style.whiteSpace == "nowrap" ) { d.style.whiteSpace = "normal"; }
                else { d.style.whiteSpace = "nowrap"; }
            }
            
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

                if (id) {
                    loadUrl(route + id );
                }
            };
        </script>
    </head>
    <body>
        @include('public.header')
        @if(count($vacancies) > 0)
            <h2 style="margin-left:15px">Are you looking for a job?</h2>
            <p style="margin-left:15px;margin-bottom:10px">We have the following job openings:</p>
        @endif
        <main class="grid">
            @forelse($vacancies as $vacancy)
            <article class="card">
                <header>
                    <h4>{{ $vacancy->job_title }}</h4>
                    <time title="Posted">{{ $vacancy->posted_on }}</time>
                </header>
                <section>
                    <p><strong>Job Description:</strong></p>
                    <div class="text" onclick="RevealHiddenOverflow(this)">
                        {!! $vacancy->description !!}
                    </p>
                    <p>Functional Area: <strong>{{ $vacancy->department->description }}</strong></p>
                    <p>Employment Type: <strong>{{ $vacancy->employeeStatus->description }}</strong></p>
                    @if( !is_null($vacancy->min_salary) && !is_null($vacancy->max_salary))
                        <p>
                            <svg class="icon" width="35" height="35">
                                <use xlink:href="#get-money" />
                            </svg>
                            Salary: <strong>{{ $vacancy->min_salary }} - {{ $vacancy->max_salary }}</strong></p>
                    @else
                        <p>Salary: <strong>Negotiable</strong></p>
                    @endif
                    <p>
                        <svg class="icon" width="35" height="35">
                            <use xlink:href="#skills" />
                        </svg>
                        Qualification(s) Required: <strong>{{ $vacancy->qualification->description }}</strong>
                    </p>
                    <p>
                        <svg class="icon" width="35" height="35">
                            <use xlink:href="#{{$vacancy->rel_calendar_id}}" />
                        </svg>
                        Application Deadline: <strong>{{ $vacancy->end_date }}</strong>
                    </p>
                </section>
                <footer>
                        @if($vacancy->hasApplied)
                            <a class="button" href="#light-modal" onclick="editForm({{$vacancy->id}}, event, 'vacancies/status')">Show More...</a>
                        @else
                            @if($vacancy->dateOk && $vacancy->canApply)
                                <a class="button" href="#">Apply</a>
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
        <footer class="footer">
        Copyright © 2019 Smartz Solutions - Smartz Human Asset Management. All rights reserved.
        </footer>

        @component('partials.light-modal')
        @endcomponent
        
        <script src="{{asset('js/grindstone.min.js')}}"></script>

    </body>
</html>