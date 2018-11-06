@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Topic')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('topics.store') }}" accept-charset="UTF-8" id="topic_form" name="topic_form" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('topics.form', [
                            'topic' => null,
                            'uploader' => $uploader
                        ])
                    </div>
                </div>
                <div class="box-footer pull-right">
                    <a href="{{ route('topics.index') }}" class="btn btn-default" title="Show all Topics">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                    <button class="btn btn-primary" type="button" id="btnSave" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Save</button>

                </div>
            </form>
        </div>
    </div>
@endsection