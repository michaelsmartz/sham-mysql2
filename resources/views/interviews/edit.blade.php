@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Edit Interview')

@section('modalTitle', 'Edit Interview')
@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('recruitment_requests.update-interview',  [$recruitment_id,$interview_id,$candidate_id]))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('interviews.form', [
            'interview'=> $interview,
            'status'=> $status,
            'results'=> $results,
            'interview_id' => $interview_id,
            'recruitment_id' => $recruitment_id,
            'candidate_id' => $candidate_id
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
    <form method="POST" action="{{ route('recruitment_requests.update-interview', [$recruitment_id,$interview_id,$candidate_id]) }}" id="edit_interview_form" name="edit_interview_form" enctype="multipart/form-data" accept-charset="UTF-8" >
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