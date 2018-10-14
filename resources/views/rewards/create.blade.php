@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Reward')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('rewards.store') }}" accept-charset="UTF-8" id="create_reward_form" name="create_reward_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('rewards.form', [
                            'reward' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{Session::get('redirectsTo') }}" class="btn btn-default pull-right" title="Show all Rewards">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection