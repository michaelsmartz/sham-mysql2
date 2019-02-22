@extends('portal-index')
@section('title', 'Manage Candidates')
@section('modalTitle', 'Manage Candidates')

@section('modalFooter')
    <a href="#!" class="btn" data-close="Close" data-dismiss="modal">Cancel</a>
    <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Add</button>
@endsection

@section('postModalUrl', route('recruitment_requests.update-candidate', $data->id))

@section('modalContent')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="flex-wrapper">
                        <div class="col-xs-12">
                            {!! Form::select('from[]', $candidates, null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect')) !!}
                        </div>
                    </div>
                    <br>
                </div>

                <div class="col-xs-6 col-xs-offset-3">
                    <div class="col-xs-6">
                        <button type="button" id="multiselect_rightAll" class="btn btn-block" data-wenk="Select All"><i class="fa fa-angle-double-down" style="font-weight:900"></i></button>
                        <button type="button" id="multiselect_rightSelected" class="btn btn-block" data-wenk="Add Selected"><i class="fa fa-angle-down" style="font-weight:900"></i></button>
                    </div>
                    <div class="col-xs-6">
                        <button type="button" id="multiselect_leftSelected" class="btn btn-block" data-wenk="Remove Selected"><i class="fa fa-angle-up" style="font-weight:900"></i></button>
                        <button type="button" id="multiselect_leftAll" class="btn btn-block" data-wenk="Unselect All"><i class="fa fa-angle-double-up" style="font-weight:900"></i></button>
                    </div>
                </div>

                <div class="col-xs-12">
                    <br>
                    <div class="col-xs-12">
                        {!! Form::select('candidates[]', isset($recruitmentCandidates)?$recruitmentCandidates:[], null, array('multiple' => 'multiple', 'size' => '7', 'class'=> 'form-control', 'id'=>'multiselect_to')) !!}
                    </div>
                    {!! $errors->first('candidates[]', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('recruitment_requests.update-candidate', $data->id) }}" id="add_candidate_form" name="add_candidate_form" accept-charset="UTF-8" >
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