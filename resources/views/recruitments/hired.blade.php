<ul class="people-list">
    <li class="active">
        <div class="img">
        </div>
        <div>
            <strong>Robert Sons</strong>
            <div>IT Manager</div>
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
                <h2>Robert Sons</h2>
                <div>IT Manager</div>
                <br>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="startDate">Start Date</label>
                    <input id="startDate" class='form-control datepicker' type="text" name="startDate" >
                </div>
                <div class="col-md-12">
                    <label for="comments">Comments</label>
                    <textarea
                            id="comments"
                            class='form-control'
                            name="comments">
                    </textarea>
                </div>
                <div class="col-md-12" style="padding-top: 10px;">
                    <button type="button" class="btn btn-success pull-right">Save</button>
                    <button type="button" class="btn btn-success">Import Candidate Data</button>
                </div>
            </div>
            <div id="date-picker"> </div>
        </div>
    </div>
</div>
