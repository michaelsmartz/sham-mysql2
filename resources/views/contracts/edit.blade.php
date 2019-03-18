@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Contract')

@section('content')
    <form method="POST" action="{{ route('contracts.update', $data->id) }}" id="edit_contract_form" name="edit_contract_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-sm-12">
                @include ('contracts.form', [
                    'contract' => $data,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <a href="{{route('contracts.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
                <button class="btn btn-primary" type="submit" id="btnSave" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Save</button>
            </div>
        </div>
    </form>
@endsection