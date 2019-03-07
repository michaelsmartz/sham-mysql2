        <div class="form-group col-md-12">
            <span class="field">
                <label for="schedule_on">Schedule On</label>
                {!! Form::text('schedule_at', old('schedule_at', isset($interview->schedule_at) ? $interview->schedule_at : null), ['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'Schedule On', 'required', 'title'=>'Required','id'=>'schedule_at']) !!}
            </span>
        </div>

        <div class="form-group col-md-12">
                <span class="field">
                <label for="recruitment_type_id">Status</label>
                    {!! Form::select('status', $status, old('status', isset($interview->status) ? $interview->status : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Status..', 'data-field-name'=>'Status', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
        </div>

        <div class="form-group col-md-12">
            <span class="field">
                <label for="reasons">Reasons</label>
                {!! Form::textarea('reasons', old('reasons', isset($interview->reasons) ? $interview->reasons : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Reasons', 'required', 'title'=>'Required','id'=>'reasons', 'maxlength' => '50']) !!}
            </span>
        </div>

        <div class="form-group col-md-12">
                <span class="field">
                <label for="recruitment_type_id">Result</label>
                    {!! Form::select('results', $results, old('results', isset($interview->results) ? $interview->results : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Results..', 'data-field-name'=>'Results', 'required', 'title'=>'Required', 'data-parsley-trigger'=>'focusout']) !!}
                </span>
        </div>

        <div class="form-group col-md-12">
            <span class="field">
                <label for="location">Location</label>
                {!! Form::text('location', old('location', isset($interview->location) ? $interview->location : null), ['class'=>'form-control fix-case field-required', 'autocomplete'=>'off', 'placeholder'=>'Location', 'required', 'title'=>'Required','id'=>'location']) !!}
            </span>
        </div>

        <div class="form-group col-xs-12 {{ $errors->has('is_completed') ? 'has-error' : '' }}">
            <label for="is_completed">Completed</label>
            <div class="checkbox">
                <label for="is_completed">
                    <input id="is_completed" class="" name="is_completed" type="hidden" value="0" />
                    <input id="is_completed" class="" name="is_completed" type="checkbox" value="1" {{ old('is_completed', optional($interview)->is_completed) == '1' ? 'checked' : '' }}>
                    Yes
                </label>
            </div>

            {!! $errors->first('is_completed', '<p class="help-block">:message</p>') !!}
        </div>

        <input id="candidate_id" class="" name="candidate_id" type="hidden" value="{!! isset($candidate_id) ? $candidate_id : null !!}" />
        <input id="interview_id" class="" name="interview_id" type="hidden" value="{!! isset($interview_id) ? $interview_id : null !!}" />
        <input id="recruitment_id" class="" name="recruitment_id" type="hidden" value="{!! isset($recruitment_id) ? $recruitment_id : null !!}" />

        <div id="date-picker"> </div>
