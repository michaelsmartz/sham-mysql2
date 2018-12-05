@extends('portal-index')
@section('title', 'Edit Evaluation')
@section('modalTitle', 'Edit Evaluation')

@section('modalFooter')
    @if((isset($data))&& !$data->hasAnyAssessorComplete())
        <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
    @endif
    <a href="{{route('evaluations.index')}}" class="btn pull-right" data-close="Close" data-dismiss="modal">Cancel</a>

@endsection

@section('postModalUrl', route('evaluations.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('evaluations.form', [
                'mode' => 'edit',
                'evaluation' => $data,
            ])
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('evaluations.update', $data->id) }}" id="edit_evaluation_form" name="edit_evaluation_form" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        @yield('modalContent')
        <p>
        <div class="row">
            <div class="col-sm-12 text-right">
                @yield('modalFooter')
            </div>
        </div>
        </p>
    </form>
@endsection