@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Qualification')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('qualification-recruitments.store') }}" accept-charset="UTF-8" id="create_qualification_recruitment_form" name="create_qualification_recruitment_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('qualification_recruitments.form', [
                            'qualificationRecruitment' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('qualification-recruitments.index') }}" class="btn btn-default pull-right" title="Show all Qualification Recruitments">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection