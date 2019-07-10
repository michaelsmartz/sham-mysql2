<div id="load" style="position: relative;">
    <div class="loader">
        <img class="img_loader" src="{{URL::to('/')}}/images/loader.gif" />
    </div>
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
                    <p class="salary"><span class="glyphicon glyphicon-piggy-bank"></span>  {{ $vacancy->min_salary }} - {{ $vacancy->max_salary }}</p>
                @else
                    <p class="salary"><span class="glyphicon glyphicon-piggy-bank"></span>  Not disclosed </p>
                @endif
                <ul class="btns pull-right">
                    <li>
                        <a role="button"
                           {{--id="apply_{{ $vacancy->id }}" --}}
                           {{--v-bind:disabled="apply_{{ $vacancy->id }} !== null"  --}}
                           @click="applyVacancy({{ $vacancy->id }}, '{{ $vacancy->job_title }}')">Apply</a>
                    </li>
                </ul>
            </div>
        </div>
    @endforeach
    @component('partials.index', [])
    @endcomponent
</div>
{{ $vacancies->links() }}
