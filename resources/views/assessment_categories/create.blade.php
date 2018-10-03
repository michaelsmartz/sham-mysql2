@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Assessment Category')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('assessment_categories.store') }}" accept-charset="UTF-8" id="create_assessment_category_form" name="create_assessment_category_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('assessment_categories.form', [
                            'assessmentCategory' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('assessment_categories.index') }}" class="btn btn-default pull-right" title="Show all Assessment Categories">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection