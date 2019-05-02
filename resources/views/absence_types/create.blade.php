@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Absence Type')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('absence_types.store') }}" accept-charset="UTF-8" id="create_absence_type_form" name="create_absence_type_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('absence_types.form', [
                            'mode' => 'create',
                            'absenceType' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary pull-right" type="submit">Add</button>
                    <a href="{{ route('absence_types.index') }}" class="btn btn-default pull-right" title="Show all Absence Types">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection