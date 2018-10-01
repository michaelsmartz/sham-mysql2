@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Category Question')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('category_questions.store') }}" accept-charset="UTF-8" id="create_category_question_form" name="create_category_question_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('category_questions.form', [
                            'categoryQuestion' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('category_questions.index') }}" class="btn btn-default pull-right" title="Show all Category Questions">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection