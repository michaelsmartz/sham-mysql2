        {!! Form::hidden('offer_id', $offer_id) !!}
        {!! Form::hidden('recruitment_id', $recruitment_id) !!}
        {!! Form::hidden('candidate_id', $candidate_id) !!}
        {{ csrf_field() }}
        {{ method_field('post') }}

        <div class="form-group col-md-12">
            <span class="field">
                <label for="comments">Comments</label>
                {!! Form::textarea('comments', null, ['class'=>'form-control ', 'autocomplete'=>'off', 'placeholder'=>'Comments', 'id'=>'reasons', 'maxlength' => '50', 'rows'=>3]) !!}
            </span>
        </div>

        <div class="form-group col-md-12">
            <span class="field">
                <label for="offer_signed_on">Signed On</label>
                {!! Form::text('offer_signed_on', null, ['class'=>'form-control fix-case field-required datepicker', 'autocomplete'=>'off', 'placeholder'=>'Signed On', 'required', 'title'=>'Required','id'=>'offer_signed_on']) !!}
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