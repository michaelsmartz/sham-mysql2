@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Offer')

@section('content')
    <form method="POST" action="{{ route('offers.update', $data->id) }}" id="edit_offer_form" name="edit_offer_form" accept-charset="UTF-8" >
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-sm-12">
                @include ('offers.form', [
                    'offer' => $data,
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <a href="{{route('offers.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
                <button class="btn btn-primary" type="submit" id="btnSave" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Save</button>
            </div>
        </div>
    </form>
@endsection