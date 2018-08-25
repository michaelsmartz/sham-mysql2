@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Create New Law')
@section('modalTitle', 'Edit Law')

@section('modalHeader')
    <form method="POST" action="{{ route('laws.store') }}" accept-charset="UTF-8" id="create_law_form" name="create_law_form" class="form-horizontal">
        {{ csrf_field() }}
@endsection

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('laws.index') }}" class="btn btn-default pull-right" title="Show all Laws">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
</form>
@endsection

@section('modalContent')
        <div class="row">
            <div class="col-sm-12">
                @include('laws.form', [
                    'law' => null,
                ])
            </div>
        </div>
        @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter') 
        </div>
        @endif
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-body">
                @yield('modalContent') 
        </div>
    </div>
@endsection