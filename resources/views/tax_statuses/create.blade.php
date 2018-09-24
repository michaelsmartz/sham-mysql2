@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Tax Status')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('tax_statuses.store') }}" accept-charset="UTF-8" id="create_tax_status_form" name="create_tax_status_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('tax_statuses.form', [
                            'taxStatus' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('tax_statuses.index') }}" class="btn btn-default pull-right" title="Show all Tax Statuses">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection