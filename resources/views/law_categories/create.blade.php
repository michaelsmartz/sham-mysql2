@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Law Category')
@section('modalTitle', 'Edit Law Category')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('law_categories.index') }}" class="btn btn-default pull-right" title="Show all Law Categories">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('law_categories.store') }}" accept-charset="UTF-8" id="create_law_category_form" name="create_law_category_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('law_categories.form', [
                    'lawCategory' => null,
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