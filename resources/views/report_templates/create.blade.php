@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Report Template')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('report_templates.store') }}" accept-charset="UTF-8" id="create_report_template_form" name="create_report_template_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('report_templates.form', [
                            'reportTemplate' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('report_templates.index') }}" class="btn btn-default pull-right" title="Show all Report Templates">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection