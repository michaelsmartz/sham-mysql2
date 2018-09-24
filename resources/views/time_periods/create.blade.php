@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Time Period')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('time_periods.store') }}" accept-charset="UTF-8" id="create_time_period_form" name="create_time_period_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('time_periods.form', [
                            'timePeriod' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('time_periods.index') }}" class="btn btn-default pull-right" title="Show all Time Periods">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection