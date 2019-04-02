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
                            <div v-show="current">
                                <h2>@{{ current.name }}</h2>
                                <div v-if="current.job_title">@{{ current.job_title.description }}</div>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group pull-right" v-show="current">
                                <button id="{{ $step[0]['id'] }}" @click="pipelineSwitchState(1,'Approve the contract',current,current.id, 4)" class="{{ $step[0]['btnclass'] }}">
                                    <i class="{{ $step[0]['class'] }}"></i> {{ $step[0]['label'] }}
                                </button>
                                <button id="{{ $step[1]['id'] }}" class="{{ $step[1]['btnclass'] }}">
                                    <i class="{{ $step[1]['class'] }}"></i> {{ $step[1]['label'] }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <div class="col-md-7">
                                <h4>Original Copy</h4>
                            </div>
                            <div class="col-md-7" style="padding-top: 10px;">
                                <button type="button" class="btn btn-success pull-right">Download</button>
                            </div>
                            <div class="col-md-12">
                                <hr/>
                            </div>
                            <div class="col-md-7" style="padding-top: 0px;">
                                <h4>Signed Copy</h4>
                            </div>
                            <div class="col-md-12" v-if="current.contracts[0].signed_on != null">
                                The offer letter was signed on @{{current.contracts[0].signed_on | formatDate}} 
                            </div>
                            <div class="col-md-7" style="padding-top: 10px;" v-if="current.contracts[0].signed_on == null">
                                <a href="#light-modal" class="btn btn-success pull-right" data-wenk="Upload" @click="uploadSignedContract(current.id)">
                                    <i class="fa fa-upload"></i>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>