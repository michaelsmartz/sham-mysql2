@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Recruitment Request')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('recruitment_requests.store') }}" accept-charset="UTF-8" id="create_recruitment_requests_form" name="create_recruitment_requests_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('recruitment_requests.form', [
                            'request' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('recruitment_requests.index') }}" class="btn btn-default pull-right" title="Show all recruitment requests">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection