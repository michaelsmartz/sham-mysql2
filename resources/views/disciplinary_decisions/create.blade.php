@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Disciplinary Decision')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('disciplinary_decisions.store') }}" accept-charset="UTF-8" id="create_disciplinary_decision_form" name="create_disciplinary_decision_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('disciplinary_decisions.form', [
                            'disciplinaryDecision' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('disciplinary_decisions.index') }}" class="btn btn-default pull-right" title="Show all Disciplinary Decisions">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection