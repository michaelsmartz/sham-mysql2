@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Category Question Type')
@section('modalTitle', 'Edit Category Question Type')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('category_question_types.index') }}" class="btn btn-default pull-right" title="Show all Category Question Types">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('category_question_types.store') }}" accept-charset="UTF-8" id="create_category_question_type_form" name="create_category_question_type_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('category_question_types.form', [
                    'categoryQuestionType' => null,
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