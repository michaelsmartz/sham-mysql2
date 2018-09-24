@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add New Law')

@section('content')
    <form method="POST" action="{{ route('laws.store') }}" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        @include('laws.form', [
                            'law' => null,
                        ])
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input class="btn btn-primary pull-right start js_send" type="submit" id="submit" value="Add">
                <a href="{{ route('laws.index') }}" class="btn btn-default pull-right" title="Show all Laws">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </form>
@endsection