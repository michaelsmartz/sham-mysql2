    <ul class="people-list">
        <li v-for="person in filteredPeople" v-on:click="setCurrent(person)" :class="{ active: current.name === person.name }">
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
                    <button id="{{ $step[0]['id'] }}" type="button"  @click="pipelineSwitchState(1,'Mark the overall results as Pass',current,current.id,2)" class="{{ $step[0]['btnclass'] }}">
                        <i class="{{ $step[0]['class'] }}"></i> {{ $step[0]['label'] }}
                    </button>
                    <button id="{{ $step[1]['id'] }}" type="button" @click="pipelineSwitchState(1,'Mark the overall results as Fail',current,current.id,-2)" class="{{ $step[1]['btnclass'] }}">
                        <i class="{{ $step[1]['class'] }}"></i> {{ $step[1]['label'] }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" v-if="current.interviews.length" v-show="current">

                <div class="table-responsive">
                    <table id="new-table" data-toggle="table" style="width:100%" data-show-toggle="true" data-detail-view="true">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Type</th>
                            <th>ScheduledOn</th>
                            <th>Status</th>
                            <th>Reasons(if any)</th>
                            <th>Results</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <template v-for="interview in current.interviews">
                                {{--TODO error happening because of accordion parent id="accordion"--}}
                                <div class="panel-group" id="accordion">
                                <tr>
                                    <td>
                                        <a class="detail-icon" data-parent="accordion" data-toggle="collapse" :data-target="'#row'+interview.pivot.id">
                                            <span class="icon_toggle glyphicon glyphicon-plus"></span>
                                        </a>
                                    </td>
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
                                    <div class="collapse collapsed" :id="'row'+interview.pivot.id">
                                        <table class="table table-striped tablesorter" id="new-table" data-toggle="table">
                                            <thead>
                                            <tr class="filters">
                                                <th>File name</th>
                                                <th style="text-align:right;">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="media in interview.media" :data-id='media.id'>
                                                <td>@{{media.filename}}.@{{media.extension}}</td>
                                                <td style="text-align:right;">
                                                    <div>
                                                        <a href="" class="b-n b-n-r bg-transparent item-download" data-wenk="Download">
                                                            <i class="fa fa-download text-primary"></i>
                                                        </a>
                                                        <a href="#!" class="b-n b-n-r bg-transparent item-detach" data-wenk="Remove"
                                                           onclick="">
                                                            <i class="glyphicon glyphicon-remove text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </tr>
                                </div>
                            </template>
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

    @component('partials.index', [])
    @endcomponent
    @push('js-stack')
        <style>
            [data-toggle="collapse"] .icon_toggle:before {
                content:"\2212";
            }

            [data-toggle="collapse"].collapsed .icon_toggle:before {
                content:"\2b";
            }
        </style>
        <script>
            $(function() {
                $('.collapse').collapse('hide');
            });
        </script>
    @endpush