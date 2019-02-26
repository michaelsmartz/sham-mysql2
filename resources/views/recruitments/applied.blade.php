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
                        <div class="col-md-7">
                            <div>
                                <h2>@{{ current.name }}</h2>
                                <div>@{{ current.jobTitle }}</div>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group pull-right">
                                <button id="{{ $step[0]['id'] }}" @click="pipelineSwitchState(1,'Approve for interview',current,1,2)" class="{{ $step[0]['btnclass'] }}">
                                    <i class="{{ $step[0]['class'] }}"></i> {{ $step[0]['label'] }}
                                </button>
                                <button id="{{ $step[1]['id'] }}" type="button" class="{{ $step[1]['btnclass'] }}">
                                    <i class="{{ $step[1]['class'] }}"></i> {{ $step[1]['label'] }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable" v-show="current !== null">
                                <ul class="nav">
                                    <li><a href="#pane1" data-toggle="tab">Overview</a></li>
                                    <li><a href="#pane2" data-toggle="tab">Documents</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content n-t-m">
                                <div id="pane1" class="tab-pane">
                                    <div class="col-lg-8">
                                        <div>EDUCATION</div>
                                        <hr>
                                        <div v-for="qualification in current.qualifications">
                                            <dd>@{{qualification.institution}}</dd>
                                            <dt>@{{qualification.description}}</dt>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-lg-4 contact-column">
                                        <div>APPLICANT DETAILS</div>
                                        <hr>
                                        <dd>Email address</dd>
                                        <dt>@{{current.email}}</dt>
                                        <dd>Phone number</dd>
                                        <dt>@{{current.phone}}</dt>
                                        <dd>Date of birth</dd>
                                        <dt>@{{current.birth_date}}</dt>
                                    </div>
                                </div>
                                <div id="pane2" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-4" v-for="file in current.documents">
                                            <div class="panel discoverer">
                                                <div class="panel-body text-center">
                                                    <div class="clearfix discover">
                                                        <div class="pull-right">
                                                            <a data-bind="attr: { 'href': DownloadLink}" data-wenk="Download" class="text-muted mr-sm tooltips">
                                                                <em class="fa fa-download fa-fw"></em>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <p>
                                                        <small class="text-dark">@{{ file.name }}</small>
                                                    </p>
                                                    <div class="clearfix m0 text-muted">
                                                        <small class="pull-right">@{{ file.name }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
