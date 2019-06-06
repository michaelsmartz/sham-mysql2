@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Upload Signed Document')

@section('modalTitle', 'Upload Signed Document')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('recruitment_requests.upload-offer',  [$recruitment_id]))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('recruitments.upload-signed-offer-form', [
            'recruitment_id' => $recruitment_id,
            'candidate_id' => $candidate_id,
            'offer_id' => $offer_id
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
    <form method="POST" action="{{ route('recruitment_requests.upload-offer', [$recruitment_id]) }}" id="upload_offer_form" name="upload_offer_form" enctype="multipart/form-data" accept-charset="UTF-8" >
        
        <input name="_method" type="hidden" value="POST">
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