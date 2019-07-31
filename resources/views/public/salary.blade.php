@extends('public.layouts.index')
@section('title', 'Please complete information below')
<link href="{{URL::to('/')}}/css/candidate-vacancies.css" rel="stylesheet">
@section('modalTitle', 'Please complete information below')
@section('modalFooter')
    <div class="pull-right">
        <a href="{{ route('candidate.vacancies') }}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
        <button class="btn btn-sham" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Apply</button>
    </div>
@endsection

@section('postModalUrl',route('vacancies.save'))

@section('modalContent')
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                    <span class="field">
                        <label for="salary_expectation">What is your salary expectation?</label>
                        {!! Form::text('salary_expectation', old('salary_expectation', ''), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Salary Expectation', 'title'=>'Required','id'=>'salary_expectation', 'maxlength' => '50',
                        'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$",
                        'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)",
                        'data-parsley-trigger'=>'focusout'])
                        !!}
                    </span>
            </div>

            <input id="recruitment_id" class="" name="recruitment_id" type="hidden" value="{!! isset($recruitmentId) ? $recruitmentId : null !!}" />
        </div>
        <div class="col-sm-9">
            <article class="card">
                <header>
                    <h4>{{ $vacancy->job_title }}</h4>
                    <time title="Posted">{{ $vacancy->posted_on }}</time>
                </header>
                <section>
                    <div class="desc-wrap">
                        <p><strong>Job Description:</strong></p>
                        <div class="text">
                            {!! $vacancy->description !!}
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
            </article>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('vacancies.save') }}" id="apply_interview_form" name="apply_interview_form" enctype="multipart/form-data" accept-charset="UTF-8" >
        <div class="box box-primary">
            <div class="box-body">
                @yield('modalContent')
            </div>
            <div class="box-footer">
                @yield('modalFooter')
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{URL::to('/')}}/js/parsley.js"></script>
@endsection
