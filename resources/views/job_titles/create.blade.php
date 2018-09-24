@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Job Title')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('job_titles.store') }}" accept-charset="UTF-8" id="create_job_title_form" name="create_job_title_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('job_titles.form', [
                            'jobTitle' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('job_titles.index') }}" class="btn btn-default pull-right" title="Show all Job Titles">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection