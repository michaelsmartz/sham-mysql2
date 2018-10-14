@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Disciplinary Action')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('disciplinaryactions.store') }}" accept-charset="UTF-8" id="create_disciplinary_action_form" name="create_disciplinary_action_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('disciplinary_actions.form', [
                            'disciplinaryAction' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{Session::get('redirectsTo') }}" class="btn btn-default pull-right" title="Show all Disciplinary Actions">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection