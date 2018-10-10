@extends(Request::ajax()?'blank':'portal-index')
@section('title', strip_tags(trim($form->title)))

@section('modalTitle', strip_tags(trim($form->title)))
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">save</button>
@endsection

@section('postModalUrl', route('my-surveys.store', $id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            {!! Form::hidden('id',$id) !!}

            <div class="form-group p col-xs-12">
                <h5>Please take a few minutes to complete this survey</h5>
            </div>
            <div class="form-group p col-xs-12">
                <div id="form">
                    {!!  (isset($form)?$form->getFormHTML():"") !!}
                </div>
            </div>
        </div>
    </div>
    @if(!Request::ajax())
        <div class="box-footer">
            @yield('modalFooter')
        </div>
    @endif
@endsection

@section('content')
    <form method="POST" action="{{ route('my-surveys.store', $id) }}" id="SurveyForm" name="SurveyForm" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <div class="box box-primary">
            <div class="box-body">
                @yield('modalContent')
            </div>
            <div class="box-footer">
                @yield('modalFooter')
            </div>
        </div>
    </form>
@endsection