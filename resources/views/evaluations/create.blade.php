@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Evaluation')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('evaluations.store') }}" accept-charset="UTF-8" id="create_evaluation_form" name="create_evaluation_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('evaluations.form', [
                            'evaluation' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('evaluations.index') }}" class="btn btn-default pull-right" title="Show all Evaluations">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection