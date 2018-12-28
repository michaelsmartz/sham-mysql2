<ul class="people-list">
    <li class="active">
        <div class="img">
        </div>
        <div>
            <strong>Warrens Peters</strong>
            <div>Doctor</div>
        </div>
    </li>
</ul>
<div class="tab-detail">
    <div class="row">
        <div class="col-md-2 img">
            <div class="avatar-upload">
                <div class="avatar-edit">
                    <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" />
                    <label for="imageUpload" title="change profile image"></label>
                </div>
                <div class="avatar-preview">
                    <div id="imagePreview" style="background-image: url('/img/avatar.png');">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <h2>Warrens Peters</h2>
                <div>Doctor</div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="originalCopy">Original Copy</label>
                    <button type="button" class="btn btn-success">Download</button>

                    <label for="originalCopy">Signed Copy</label>
                    <button type="button" class="btn btn-success">Download</button>
                </div>
                <div class="col-md-12">
                    <label for="signedOnContract">Signed On</label>
                    <input id="signedOnContract" class='form-control datepicker' type="text" name="signedOnContract" >
                </div>
                <div class="col-md-12">
                    <label for="comments">Comments</label>
                    <textarea
                            id="comments"
                            class='form-control'
                            {{--v-model="overallComment"--}}
                            name="comments">
                    </textarea>
                </div>
                <div class="col-md-12" style="padding-top: 10px;">
                    <button type="button" class="btn btn-success pull-right">Save</button>
                </div>
                <div id="date-picker"> </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="btn-group">
                <button id="{{ $step[0]['id'] }}" type="button" class="{{ $step[0]['btnclass'] }}">
                    <i class="{{ $step[0]['class'] }}"></i> {{ $step[0]['label'] }}
                </button>
                <button id="{{ $step[1]['id'] }}" type="button" class="{{ $step[1]['btnclass'] }}">
                    <i class="{{ $step[1]['class'] }}"></i> {{ $step[1]['label'] }}
                </button>
            </div>
        </div>
    </div>
</div>
