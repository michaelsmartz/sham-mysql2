<div id="load" style="position: relative;">
    <div class="loader">
        <img class="img_loader" src="{{URL::to('/')}}/images/loader.gif" />
    </div>
    @foreach($vacancies as $vacancy)
        <div class="single-post d-flex flex-row">
            <div class="thumb">
                <img src="{{URL::to('/')}}/img/job.png" alt="">
                <p class="pull-right">{{ $vacancy->posted_on }}</p>
                <ul class="tags">
                    @if( !is_null($vacancy->skills))
                        @foreach($vacancy->skills as $skill)
                            <li><a>{{ $skill->description }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="details">
                <div class="title d-flex flex-row justify-content-between">
                    <div class="titles">
                        <a href=""><h4>{{ $vacancy->job_title }}</h4></a>
                        <h6>{{ $vacancy->department->description }}</h6>
                    </div>
                </div>
                <div class="text">
                    <div id="less-{{$vacancy->id}}" class="less">
                        {{ str_limit(strip_tags($vacancy->description), $limit = 500, $end = '...')}}
                    </div>
                    <div id="view_more_{{$vacancy->id}}" class="view_more" onclick="show('more',{{$vacancy->id}})">Read more</div>
                    <div id="more-{{$vacancy->id}}" class="more">
                        {!! $vacancy->description !!}
                    </div>
                    <div id="view_less_{{$vacancy->id}}" class="view_less" onclick="show('less',{{$vacancy->id}})">Show less</div>
                </div>
                <h5><span class="glyphicon glyphicon-briefcase"></span> Employment Type: {{ $vacancy->employeeStatus->description }}</h5>
                <h5><span class="glyphicon glyphicon-education"></span> Qualification Required: {{ $vacancy->qualification->description }}</h5>
                <h5><span class="glyphicon glyphicon-time"></span> Closing on: {{ $vacancy->end_date }}</h5>
                @if( !is_null($vacancy->min_salary) && !is_null($vacancy->max_salary))
                    <p class="salary"><span class="glyphicon glyphicon-piggy-bank"></span>  {{ $vacancy->min_salary }} - {{ $vacancy->max_salary }}</p>
                @else
                    <p class="salary"><span class="glyphicon glyphicon-piggy-bank"></span>  Not disclosed </p>
                @endif
                @if(is_null($vacancy->already_apply))
                <ul class="btns pull-right isDisabled">
                    <li>
                        <a role="button" class="isDisabled"
                           onclick="applyVacancy('{{ $vacancy->id }}', '{{ $vacancy->job_title }}', '{{  $vacancies->currentPage() }}', event)">
                           Apply
                        </a>
                    </li>
                </ul>
                @else
                    <ul class="btns pull-right isDisabled">
                        <li>
                            <a role="button" href="#light-modal"
                               onclick="loadCandidateStatus('{{ $vacancy->id }}', '{{!is_null($candidate_id)?$candidate_id:0}}')">
                            View Applicant Status...
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    @endforeach
    @component('partials.index', [])
    @endcomponent
</div>
{{ $vacancies->appends(request()->except('filter'))->links() }}
