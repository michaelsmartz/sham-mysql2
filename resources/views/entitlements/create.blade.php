@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Create New Entitlement')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('entitlements.store') }}" accept-charset="UTF-8" id="create_entitlement_form" name="create_entitlement_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('entitlements.form', [
                            'entitlement' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('entitlements.index') }}" class="btn btn-default pull-right" title="Show all Entitlements">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection