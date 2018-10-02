@extends('portal-index')
@section('title', 'Edit Category Question')
@section('modalTitle', 'Edit Category Question')

@section('modalFooter')
    <div class="row text-right">
        <div class="col-sm-12">
            <a href="{{route('category_questions.index')}}" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
            <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Update</button>
        </div>
    </div>
@endsection

@section('postModalUrl', route('category_questions.update', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            @include ('category_questions.form', [
                'categoryQuestion' => $data,
            ])
        </div>
    </div>

@endsection

@section('content')
    <form method="POST" action="{{ route('category_questions.update', $data->id) }}" id="edit_category_question_form" name="edit_category_question_form" accept-charset="UTF-8" >
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