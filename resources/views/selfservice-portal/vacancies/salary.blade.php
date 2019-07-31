@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Please complete information below')

@section('modalTitle', 'Please complete information below')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Add</button>
@endsection

@section('postModalUrl', route('my-vacancies.apply-interview')))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group col-xs-12">
                    <span class="field">
                        <label for="salary_expectation">What is your salary expectation?</label>
                        <input class="form-control" name="salary_expectation" type="number" id="salary_expectation" min="0" max="999999999" placeholder="Enter salary Expectation Here...">
                    </span>
            </div>

            <input id="recruitment_id" class="" name="recruitment_id" type="hidden" value="{!! isset($recruitment_id) ? $recruitment_id : null !!}" />
            <input id="page" class="" name="page" type="hidden" value="{!! isset($page) ? $page : null !!}" />
        </div>
    </div>
    @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter')
        </div>
    @endif
@endsection

@section('content')
    <form method="POST" action="{{ route('my-vacancies.apply-interview') }}" id="apply_interview_form" name="apply_interview_form" enctype="multipart/form-data" accept-charset="UTF-8" >
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
