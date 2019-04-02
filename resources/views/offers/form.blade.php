<div class="row">
    <div class="form-group col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
        <label for="description">Description</label>
            <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($offer)->description) }}" minlength="1" maxlength="100" required="true" placeholder="Enter description">
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row">
    <div style="border:1px solid #ccc;overflow:hidden;margin:0 15px 20px 15px;background-color:#fff;padding:20px; 0;">
        <div class="col-xs-12"><i class="fa fa-info-circle" data-wenk="The labels below are placeholder text. Click to insert into the text zone below" data-wenk-pos="right"></i></div>
        <div class="col-xs-1">Recruitment</div>
        <div class="col-xs-11">
            <span class="label label-primary" onclick="insertPlaceHolder('[[recruitment Job Title]]')" style="user-drag: none;cursor:pointer;">Job Title</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[recruitment Department]]')" style="user-drag: none;cursor:pointer;">Department</span>
        </div>
        <div class="col-xs-1">Candidate</div>
        <div class="col-xs-11" style="user-drag: none;">
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Title]]')" style="user-drag: none;cursor:pointer;">Title</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Name]]')" style="user-drag: none;cursor:pointer;">Name</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Phone Number]]')" style="user-drag: none;cursor:pointer;">Phone Number</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Address Line 1]]')" style="user-drag: none;cursor:pointer;">Address Line 1</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Address Line 2]]')" style="user-drag: none;cursor:pointer;">Address Line 2</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Address Line 3]]')" style="user-drag: none;cursor:pointer;">Address Line 3</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Address Line 4]]')" style="user-drag: none;cursor:pointer;">Address Line 4</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate City]]')" style="user-drag: none;cursor:pointer;">City</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Province]]')" style="user-drag: none;cursor:pointer;">Province</span>
            <span class="label label-primary" onclick="insertPlaceHolder('[[candidate Zip code]]')" style="user-drag: none;cursor:pointer;">Zip Code</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-xs-12 {{ $errors->has('content') ? 'has-error' : '' }}">
        <label for="content">Content <i class="fa fa-info-circle text-danger" data-wenk="Required"></i></label>
            <textarea class="form-control" name="content" cols="50" rows="5" id="tiny" placeholder="Enter content">{{ old('content', optional($offer)->content) }}</textarea>
            {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@section('post-body')
    <script src="{{URL::to('/')}}/js/tinymce.min.js"></script>
@endsection