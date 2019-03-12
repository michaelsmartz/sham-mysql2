@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Interview')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('interviews.store') }}" accept-charset="UTF-8" id="create_interview_form" name="create_interview_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('interviews.form', [
                            'interview' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('interviews.index') }}" class="btn btn-default pull-right" title="Show all Interviews">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection