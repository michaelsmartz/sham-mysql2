@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Module Assessment')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('module_assessments.store') }}" accept-charset="UTF-8" id="assessmentForm" name="create_module_assessment_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('module_assessments.form', [
                            'moduleAssessment' => null,
                            '_mode' => 'create'
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add" id="btnSaveAssessment">
                    <a href="{{ route('module_assessments.index') }}" class="btn btn-default pull-right" title="Show all Module Assessments">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection