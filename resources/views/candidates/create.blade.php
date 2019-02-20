@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Candidate')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" id="candidates" action="{{ route('candidates.store') }}" accept-charset="UTF-8" name="create_candidates_form" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="col-sm-12">
                            <div class="panel-body">
                                @include('candidates.form', [
                                    'candidate' => $candidate,
                                     'uploader' => $uploader
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            <div class="box-footer">
                <input class="btn btn-primary pull-right" type="submit" value="Submit">
                <a href="{{ route('candidates.index') }}" class="btn btn-default pull-right" title="Show all recruitment requests">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                </a>
            </div>
            </form>
        </div>
    </div>
@endsection