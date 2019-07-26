@extends('public.layouts.index')
@section('title', 'Please complete information below')

@section('modalTitle', 'Please complete information below')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Apply</button>
@endsection

@section('postModalUrl', "{{ route('vacancies.apply') }}")

@section('modalContent')
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                    <span class="field">
                        <label for="salary_expectation">What is your salary expectation?</label>
                        {!! Form::text('salary_expectation', old('salary_expectation', ''), ['class'=>'form-control fix-case field-required', 'required', 'autocomplete'=>'off', 'placeholder'=>'Salary Expectation', 'title'=>'Required','id'=>'salary_expectation', 'maxlength' => '50',
                        'data-parsley-pattern'=>"^[\d\+\-\.\(\)\/\s]*$",
                        'data-filter'=>"([A-Z]{0,3}|[A-Z]{3}[0-9]*)",
                        'data-parsley-trigger'=>'focusout'])
                        !!}
                    </span>
            </div>

            <input id="recruitment_id" class="" name="recruitment_id" type="hidden" value="{!! isset($recruitmentId) ? $recruitmentId : null !!}" />
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('vacancies.apply') }}" id="apply_interview_form" name="apply_interview_form" enctype="multipart/form-data" accept-charset="UTF-8" >
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
