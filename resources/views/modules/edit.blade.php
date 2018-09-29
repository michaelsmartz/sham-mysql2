@extends('portal-index')
@section('title', 'Edit Module')
@section('modalTitle', 'Edit Module')

@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
@endsection

@section('postModalUrl', route('modules.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('modules.form', [
                'module' => $data,
            ])
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('modules.update', $data->id) }}" id="edit_module_form" name="edit_module_form" accept-charset="UTF-8" >
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