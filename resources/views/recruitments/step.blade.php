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
                        <div class="col-md-2 img"></div>
                        <div class="col-md-6">
                            <div>
                                <h2>@{{ current.name }}</h2>
                                <div>@{{ current.jobTitle }}</div>
                                <br>
                            </div>
                            <div class="tabbable" v-show="current !== null">
                                <ul class="nav">
                                    <li><a href="#pane1" data-toggle="tab">Bibliography</a></li>
                                    <li><a href="#pane2" data-toggle="tab">Documents</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div id="pane1" class="tab-pane">
                                </div>
                                <div id="pane2" class="tab-pane">
                                    <ul class="files-list">
                                        <li v-for="file in current.documents">
                                            <div>
                                                <div>@{{ file.name }}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
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
