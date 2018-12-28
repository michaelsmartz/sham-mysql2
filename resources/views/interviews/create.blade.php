@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Interview')

@section('modalTitle', 'Add Interview')

<form method="POST" action="{{ route('interview.create') }}" id="add_interview_form" name="add_interview_form" accept-charset="UTF-8" >
    {{ csrf_field() }}
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    @include ('interviews.form', [])
                </div>
            </div>
        </div>
        <div class="box-footer">
            <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
            <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Add</button>
        </div>
    </div>
</form>
