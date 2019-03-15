@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Offer')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('offers.store') }}" accept-charset="UTF-8" id="create_offer_form" name="create_offer_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('offers.form', [
                            'offer' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('offers.index') }}" class="btn btn-default pull-right" title="Show all Offers">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection