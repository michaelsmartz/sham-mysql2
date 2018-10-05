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

        <div class="form-group col-xs-12 {{ $errors->has('participants') ? 'has-error' : '' }}">
            <label for="employees[]">Participants</label>
            <div class="flex-wrapper">
                {!! Form::select('employees[]', $employees,isset($participants)?$participants:null, array('name'=>'employees[]', 'multiple' => 'multiple', 'style' => 'width:100%', 'class'=> '', optional($courseTrainingSession)->is_final == '1' ? "disabled=disabled" : "required=>true" )) !!}
                {!! $errors->first('employees[]', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

</div>