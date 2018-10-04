@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Survey')

@section('content')
    <form method="POST" action="{{ route('surveys.update', $data->id) }}" id="edit_survey_form" name="edit_survey_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        @include ('surveys.form', [
                            'survey' => $data,
                             '_mode'=>'edit'
                        ])
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <a href="{{ route('surveys.index') }}" class="btn btn-primary" title="Show all Surveys">
                        Cancel
                    </a>
                    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection