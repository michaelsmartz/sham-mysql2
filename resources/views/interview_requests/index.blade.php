    <ul class="people-list">
        <li v-for="person in filteredPeople" v-on:click="loadInterviewTypes(person,current)" :class="{ active: current.name === person.name }">
            <div class="img">
            </div>
            <div>
                <strong>@{{ person.name }}</strong>
                <div v-if="person.job_title">@{{ person.job_title.description }}</div>
            </div>
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
                <div v-show="current">
                    <h2>@{{ current.name }}</h2>
                    <div v-if="current.job_title">@{{ current.job_title.description }}</div>
                    <br>
                </div>
            </div>
            <div class="col-md-3">
                <div class="btn-group pull-right" v-show="current">
                    <button id="{{ $step[0]['id'] }}" type="button"  @click="pipelineSwitchState(1,'Mark the overall results as Pass',current,current.id,1)" class="{{ $step[0]['btnclass'] }}">
                        <i class="{{ $step[0]['class'] }}"></i> {{ $step[0]['label'] }}
                    </button>
                    <button id="{{ $step[1]['id'] }}" type="button" @click="pipelineSwitchState(1,'Mark the overall results as Fail',current,current.id,-1)" class="{{ $step[1]['btnclass'] }}">
                        <i class="{{ $step[1]['class'] }}"></i> {{ $step[1]['label'] }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" v-if="interviews.length">

                <div class="table-responsive">
                    <table id="new-table" data-toggle="table" style="width:100%" data-detail-view="true">
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
                            <tr v-for="interview in interviews" :interview='interview'>
                                <td>@{{interview.description}}</td>
                                <td>@{{interview.pivot.schedule_at}}</td>
                                {{--<td>!{$interviewStatus = @{{interview.pivot.status}} }!</td>--}}
                                {{--<td>{!! App\Enums\InterviewStatusType::getDescription($interviewStatus= @{{ interview.pivot.status }}) !!}</td>--}}
                                {{--<td v-bind:interview="{{ Auth::user()->id }}">@{{interview.pivot.status}}</td>--}}
                                <td>@{{interview.pivot.status}}</td>
                                <td>@{{interview.pivot.reasons}}</td>
                                <td>@{{interview.pivot.results}}</td>

                                <td data-html2canvas-ignore="true">
                                    <div class="btn-group">
                                        <div class="btn-group">
                                            <a href="#light-modal" class="b-n b-n-r bg-transparent item-view" data-wenk="Edit Interview" @click="editInterviewForm(interview.id, current.id)">
                                                <i class="glyphicon glyphicon-edit"></i>
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
