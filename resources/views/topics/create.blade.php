@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Topic')
@section('modalTitle', 'Edit Topic')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('topics.index') }}" class="btn btn-default pull-right" title="Show all Topics">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('topics.store') }}" accept-charset="UTF-8" id="create_topic_form" name="create_topic_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('topics.form', [
                    'topic' => null,
                ])
            </div>
        </div>
        @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter') 
        </div>
        @endif
    </form>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
                @yield('modalContent') 
        </div>
    </div>
@endsection