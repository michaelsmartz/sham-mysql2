@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Recruitment Request')

@section('content')
    <div class="box box-primary">

            <form method="POST" id="recruitment-requests" action="{{ route('recruitment_requests.store') }}" accept-charset="UTF-8" name="create_recruitment_requests_form" data-parsley-validate="" class="form-horizontal">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="col-sm-12">
                                <div class="panel-body">
                                    @include('recruitment_requests.form', [
                                        'request' => $request,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input class="btn btn-primary pull-right" type="submit" value="Add">
                        <a href="{{ route('recruitment_requests.index') }}" class="btn btn-default pull-right" title="Show all recruitment requests">
                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </form>

    </div>
@endsection