@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Document Category')
@section('modalTitle', 'Edit Document Category')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('document_categories.index') }}" class="btn btn-default pull-right" title="Show all Document Categories">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('document_categories.store') }}" accept-charset="UTF-8" id="create_document_category_form" name="create_document_category_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('document_categories.form', [
                    'documentCategory' => null,
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