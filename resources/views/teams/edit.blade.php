@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Team')

@section('modalTitle', 'Edit Team')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('teams.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('teams.form', [
                'team' => $data,
            ])
        </div>
    </div>
    @if(!Request::ajax())
    <div class="box-footer">
        @yield('modalFooter') 
    </div>
    @endif
@endsection

@section('content')
    <form method="POST" action="{{ route('teams.update', $data->id) }}" id="edit_team_form" name="edit_team_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
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

@section('post-body')
    <script>console.log("{{url('/')}}/plugins/multiple-select/multiple-select.min.js")</script>
    <script src="{{url('/')}}/plugins/multiple-select/multiple-select.min.js"></script>
    <link rel="stylesheet" href="{{url('/')}}/plugins/multiple-select/multiple-select.min.css">
    <script>
        $(function () {
            $('.products').multipleSelect({
                filter: true
            });
        });
    </script>
@endsection