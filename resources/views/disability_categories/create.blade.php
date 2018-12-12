@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Disability Category')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('disability_categories.store') }}" accept-charset="UTF-8" id="create_disability_category_form" name="create_disability_category_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('disability_categories.form', [
                            'disabilityCategory' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('disability_categories.index') }}" class="btn btn-default pull-right" title="Show all Disability Categories">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection