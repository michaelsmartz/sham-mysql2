@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Topic')

@section('content')
    <form method="POST" action="{{ route('topics.update', $data->id) }}" id="topic_form" name="topic_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-sm-10">
                @include ('topics.form', [
                    'topic' => $data,
                    'fullPageEdit' => 'true'
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-sm-9 text-right">
                <a href="{{route('topics.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
                <button class="btn btn-primary" type="button" id="btnSave" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Save</button>
            </div>
        </div>
    </form>
@endsection