@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Product Category')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('product_categories.store') }}" accept-charset="UTF-8" id="create_product_category_form" name="create_product_category_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('product_categories.form', [
                            'productCategory' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('product_categories.index') }}" class="btn btn-default pull-right" title="Show all Product Categories">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection