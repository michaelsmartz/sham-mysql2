@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Product Category')
@section('modalTitle', 'Edit Product Category')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('product_categories.index') }}" class="btn btn-default pull-right" title="Show all Product Categories">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('product_categories.store') }}" accept-charset="UTF-8" id="create_product_category_form" name="create_product_category_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('product_categories.form', [
                    'productCategory' => null,
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