@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'View Survey')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('my-surveys.store') }}" accept-charset="UTF-8" id="SurveyForm" name="SurveyForm" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <h4 class="modal-title">{{strip_tags(trim($form->title))}}</h4>
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
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Save">
                    <a href="{{ route('my-surveys.index') }}" class="btn btn-default pull-right" title="Show all Sham Users">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection