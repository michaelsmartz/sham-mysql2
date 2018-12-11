{!! Form::hidden('redirectsTo', URL::previous()) !!}
<div class="row">
    {!! optional($courseTrainingSession)->id ? Form::hidden('id', $courseTrainingSession->id) : '' !!}
    <div class="form-group col-xs-12 {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name">Name</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($courseTrainingSession)->name) }}" minlength="1" maxlength="100" required="true" placeholder="Enter name">
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="bg-warning">
        <div class="form-group col-xs-12 {{ $errors->has('is_final') ? 'has-error' : '' }}">
            <label for="is_final">Is Final</label>
            <div class="checkbox">
                <label for="is_final_1">
                    <input id="is_final_1" class="" name="is_final" type="checkbox" value="1" {{ old('is_final', optional($courseTrainingSession)->is_final) == '1' ? 'checked' : '' }}>
                    Yes
                    <p class="text-danger">The list of participants <strong>will be finalised and no further changes</strong> to this training session will be possible later</p>
                </label>
            </div>

            {!! $errors->first('is_final', '<p class="help-block">:message</p>') !!}
        </div>
        
        <div class="form-group col-xs-12 {{ $errors->has('course_id') ? 'has-error' : '' }}">
            <label for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id" {!! optional($courseTrainingSession)->is_final == '1' ? 'disabled'  : 'required' !!} >
                        <option value="" style="display: none;" {{ old('course_id', optional($courseTrainingSession)->course_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select course</option>
                    @foreach ($courses as $key => $course)
                        <option value="{{ $key }}" {{ old('course_id', optional($courseTrainingSession)->course_id) == $key ? 'selected' : '' }}>
                            {{ $course }}
                        </option>
                    @endforeach
                </select>
                
                {!! $errors->first('course_id', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group col-xs-12 {{ $errors->has('modules[]') ? 'has-error' : '' }}">
            <label for="from[]">Participants <i class="fa fa-question-circle" data-wenk="Link existing participants" data-wenk-pos="right"></i></label>
        </div>

        <div class="col-xs-12">
            <div class="flex-wrapper">
                <div class="col-xs-12">
                    {!! Form::select('from[]', $employees, null, array('multiple' => 'multiple', 'size' => '10', 'class'=> 'form-control multipleSelect', 'id'=>'multiselect', optional($courseTrainingSession)->is_final == '1' ? "disabled=disabled" : "")) !!}
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
            <div class="flex-wrapper">
                <div class="col-xs-12">
                    {!! Form::select('employees[]', isset($selectedParticipants)?$selectedParticipants:[],null, array('name'=>'employees[]', 'multiple' => 'multiple', 'size' => '10', 'class'=> 'form-control', 'id'=>'multiselect_to', optional($courseTrainingSession)->is_final == '1' ? "disabled=disabled" : "")) !!}
                </div>
                {!! $errors->first('employees[]', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

</div>