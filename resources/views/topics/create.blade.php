@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Topic')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('topics.store') }}" accept-charset="UTF-8" id="create_topic_form" name="create_topic_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('topics.form', [
                            'topic' => null,
                            'uploader' => $uploader
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('topics.index') }}" class="btn btn-default pull-right" title="Show all Topics">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection