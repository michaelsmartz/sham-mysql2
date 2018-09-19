@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Assessment Types')
@section('modalTitle', 'Edit Assessment Types')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('assessment_types.index') }}" class="btn btn-default pull-right" title="Show all Assessment Types">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('assessment_types.store') }}" accept-charset="UTF-8" id="create_assessment_types_form" name="create_assessment_types_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('assessment_types.form', [
                    'assessmentTypes' => null,
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