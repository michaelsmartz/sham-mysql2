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
                <div class="tab-detail" v-if="current !== null">
                    {{--@{{ current }}--}}
                    {{--@{{ lastInterview }}--}}
                    {{--@{{ counter }}--}}
                    <button @click='loadInterviewTypes(current)'>Interview</button>
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
                                <br>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <h2>@{{ current.name }}</h2>
                                <div v-if="current.job_title">@{{ current.job_title.description }}</div>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-3 pull-right">
                            <div class="btn-group">
                                <button id="{{ $step[0]['id'] }}" type="button"  @click="pipelineSwitchState(1,'Mark the overall results as Pass',current,1,2)" class="{{ $step[0]['btnclass'] }}">
                                    <i class="{{ $step[0]['class'] }}"></i> {{ $step[0]['label'] }}
                                </button>
                                <button id="{{ $step[1]['id'] }}" type="button" class="{{ $step[1]['btnclass'] }}">
                                    <i class="{{ $step[1]['class'] }}"></i> {{ $step[1]['label'] }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">

                            <div class="table-responsive" v-if="interviews.length">
                                <table id="interview-table" data-toggle="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>ScheduledOn</th>
                                        <th>Status</th>
                                        <th>Reasons(if any)</th>
                                        <th>Results</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="interview in interviews">
                                            <td>@{{interview.description}}</td>
                                            <td>@{{interview.schedule_at}}</td>
                                            <td>@{{interview.status}}</td>
                                            <td>@{{interview.reasons}}</td>
                                            <td>@{{interview.results}}</td>

                                            <td data-html2canvas-ignore="true">
                                                <div class="btn-group">
                                                    <div class="btn-group">
                                                        <a href="#light-modal" class="b-n b-n-r bg-transparent item-view" data-wenk="Edit Interview" @click="editInterviewForm(interview.id, current.id)">
                                                            <i class="glyphicon glyphicon-edit"></i>
                                                        </a>
                                                        <a class="b-n b-n-r bg-transparent item-view" data-wenk="Attach documents" onclick="">
                                                            <i class="glyphicon glyphicon-paperclip"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            
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
                <div id="date-picker"> </div>

                @component('partials.index', [])
                @endcomponent
