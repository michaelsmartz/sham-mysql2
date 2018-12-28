                <ul class="people-list">
                    <li v-for="person in filteredPeople" v-on:click="setCurrent(person)" :class="{ active: current.name === person.name }">
                        <div class="img">
                        </div>
                        <div>
                            <strong>@{{ person.name }}</strong>
                            <div>@{{ person.jobTitle }}</div>
                        </div>
                    </li>
                </ul>
                <div class="tab-detail" v-if="current !== null">
                    {{--@{{ current }}--}}
                    {{--@{{ lastInterview }}--}}
                    {{--@{{ counter }}--}}
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
                        <div class="col-md-10">
                            <div>
                                <h2>@{{ current.name }}</h2>
                                <div>@{{ current.jobTitle }}</div>
                                <br>
                            </div>
                            <div class="btn-group">
                                <button href="#light-modal" type="button" class="btn btn-primary"
                                        data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event, 'interview')">
                                    <i class="glyphicon glyphicon-plus"></i> Add New Interview
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table id="new-table" data-toggle="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th data-sortable="true">Type</th>
                                        <th data-sortable="true">ScheduledOn</th>
                                        <th data-sortable="true">Status</th>
                                        <th data-sortable="true">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Phone</td>
                                            <td>2018-01-01</td>
                                            <td>Completed</td>

                                            <td data-html2canvas-ignore="true">
                                                <div class="btn-group">
                                                    <button href="#light-modal" class="b-n b-n-r bg-transparent item-view" data-wenk="View Details" onclick="showForm(1,event)">
                                                        <i class="glyphicon glyphicon-eye-open text-primary"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Assessment</td>
                                            <td>2018-01-30</td>
                                            <td>Not Completed</td>

                                            <td data-html2canvas-ignore="true">
                                                <div class="btn-group">
                                                    <div class="btn-group">
                                                        <button href="#light-modal" class="b-n b-n-r bg-transparent item-view" data-wenk="View Details" onclick="showForm(1,event)">
                                                            <i class="glyphicon glyphicon-eye-open text-primary"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <label for="overallComment">Overall Comments</label>
                            <textarea
                                    id="overallComment"
                                    class='form-control'
                                    {{--v-model="overallComment"--}}
                                    name="overallComment">
                                </textarea>
                            <div class="pull-right" style="font-size: 2rem;padding-top: 15px">
                                <button class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                @component('partials.index', [])
                @endcomponent
