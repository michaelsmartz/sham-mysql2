                <ul class="people-list">
                    <li v-for="person in filteredPeople" v-on:click="setCurrent(person)" :class="{ active: current.name === person.name }">
                        <div class="img">
                        </div>
                        <div>
                            <strong>@{{ person.name }}</strong>
                            <div v-if="person.job_title">@{{ person.job_title.description }}</div>
                        </div>
                    </li>
                </ul>
<div class="tab-detail" v-if="current">
    <div class="row">
        <div class="col-md-2 img">
            <div class="avatar-upload">
                <div class="avatar-edit">
                    <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg, .jpeg" />
                    <label for="imageUpload" title="change profile image"></label>
                </div>
                <div class="avatar-preview">
                    <div id="imagePreview" :style="getBackground(current.picture)">
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="col-md-7">
            <div>
                <h2>@{{ current.name }}</h2>
                <div v-if="current.job_title">@{{ current.job_title.description }}</div>
                <br>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <div class="col-md-7">
                <label for="employee_no">Employee No.</label>
                <input id="employee_no" class='form-control' type="text" name="employee_no"
                       :value="current.employee_no" v-bind:disabled="current.employee_no !== null">
            </div>
            <div class="col-md-7">
                <label for="hired_comments">Comments</label>
                <textarea
                        id="hired_comments"
                        class='form-control'
                        name="hired_comments"
                        :value="currentComment"
                        v-bind:disabled="current.employee_no !== null"
                >
                </textarea>
            </div>
            <div class="col-md-7" style="padding-top: 10px;">
                <button type="button" v-bind:disabled="current.employee_no !== null" @click="importHired" class="hired btn btn-success pull-right">Import Candidate Data</button>
            </div>
        </div>
    </div>
</div>
