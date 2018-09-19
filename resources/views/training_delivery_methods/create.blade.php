@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Training Delivery Method')
@section('modalTitle', 'Edit Training Delivery Method')

@section('modalFooter')
    <input class="btn btn-primary pull-right" type="submit" value="Add">
    <a href="{{ route('training_delivery_methods.index') }}" class="btn btn-default pull-right" title="Show all Training Delivery Methods">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
    </a>
@endsection

@section('modalContent')
    <form method="POST" action="{{ route('training_delivery_methods.store') }}" accept-charset="UTF-8" id="create_training_delivery_method_form" name="create_training_delivery_method_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                @include('training_delivery_methods.form', [
                    'trainingDeliveryMethod' => null,
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