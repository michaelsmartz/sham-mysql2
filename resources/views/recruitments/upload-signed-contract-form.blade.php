        {!! Form::hidden('contract_id', $contract_id) !!}
        {!! Form::hidden('recruitment_id', $recruitment_id) !!}
        {!! Form::hidden('candidate_id', $candidate_id) !!}
        {{ csrf_field() }}
        {{ method_field('post') }}

        <div id="date-picker"></div>
        <div class="form-group col-md-12">
            <span class="field">
                <label for="comments">Comments</label>
                {!! Form::textarea('comments', null, ['class'=>'form-control ', 'autocomplete'=>'off', 'placeholder'=>'Reasons', 'id'=>'reasons', 'maxlength' => '50', 'rows'=>3]) !!}
            </span>
        </div>

        <div class="form-group col-md-12">
            <span class="field">
                <label for="contract_signed_on">Signed On</label>
                
                {!! Form::text('contract_signed_on', null, ['class'=>'form-control field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'Signed On', 'required', 'title'=>'Required','id'=>'contract_signed_on']) !!}
            </span>
        </div>

        <div class="form-group col-xs-12 {{ $errors->has('attachment') ? 'has-error' : '' }}">
            @include('partials.uploader',[
                'fieldLabel' => 'Attach Interview Document',
                'desc' => 'Upload documents only',
                'route' => 'recruitment_requests.upload-offer',
                'acceptedFiles' => "['pdf']"
            ])
        </div>

@push('js-stack')
    <script>
        const fp = flatpickr('#contract_signed_on', {dateFormat:'Y-m-d',static:true});
    </script>
@endpush