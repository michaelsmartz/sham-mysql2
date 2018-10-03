@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'View Survey')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        @include('surveys.form', [
                            'survey' => $data,
                            '_mode'=>'show'
                        ])
                    </div>
                </div>

                @if(!Request::ajax())
                @section('post-body')
                @endif
                <script>$('form').submit( function() {if (!( typeof validator === 'undefined')){ validator.validate(); if (validator.hasErrors()) return; } $(this).find(":button").attr('disabled', 'true'); $(this).find(":submit").attr('disabled', 'true'); $(this).find(":submit").val('Please wait..'); });</script>
                @if(!Request::ajax())
                @endsection
                @endif

                {!! Form::label('FormData','Survey Form:') !!}
                <div id="form">
                    {!!  (isset($form)?$form->getFormHTML():"") !!}
                </div>
                <div class="box-footer">
                    <a href="{{ route('surveys.index') }}" class="btn btn-primary bg-grey b-r4 pull-right" title="Show all Surveys">
                        Close
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection