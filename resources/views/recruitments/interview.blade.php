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
                        <div class="col-md-12">
                            <div>
                                <h2>@{{ current.name }}</h2>
                                <div>@{{ current.jobTitle }}</div>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button v-on:click="increment" id="addInterview" type="button" class="addInterview btn btn-group primary">
                                <i class="addInterview"></i><span class="fa fa-plus"></span>Add Interview
                            </button>
                        </div>
                        <div v-if="counter !== 0">
                            <h2>Interview type @{{ counter }}</h2>
                            <div class="col-md-6">
                                <label for="candidateName">Candidate Name</label>
                                <input
                                        id="candidateName"
                                        class='form-control'
                                        v-model="candidateName"
                                        type="text"
                                        name="candidateName"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="interviewType">Candidate Type</label>
                                <select v-model="interviewType" class='form-control'>
                                    <option disabled value="">Please select one</option>
                                    <option v-for="interviewType in interviewTypes" :value="interviewType">@{{interviewType}}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="from">From</label>
                                <input
                                        id="from"
                                        class='form-control datepicker'
                                        v-model="from"
                                        name="from"
                                        type="text"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="to">To</label>
                                <input
                                        id="to"
                                        class='form-control datepicker'
                                        v-model="to"
                                        name="to"
                                        type="text"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="interviewers">Interviewer(s)</label>
                                <input
                                        id="interviewers"
                                        class='form-control'
                                        v-model="interviewers"
                                        type="text"
                                        name="interviewers"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="location">Location</label>
                                <input
                                        id="location"
                                        class='form-control'
                                        v-model="location"
                                        type="text"
                                        name="location"
                                >
                            </div>
                        </div>
                        <div id="date-picker"> </div>
                    </div>
                </div>
