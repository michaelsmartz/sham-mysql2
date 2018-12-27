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
                        <div class="col-md-12">
                            <div>
                                <h2>@{{ current.name }}</h2>
                                <div>@{{ current.jobTitle }}</div>
                                <br>
                            </div>
                        </div>
                        <div v-for="(interviewType,index) in current.interviewTypes">
                            <div class="hidden" v-if="counter == current.interviewTypes.length - 1">
                                @{{ lastInterview = true }}
                                @{{ submitInterview = true }}
                            </div>
                            <div v-if="counter === index">
                                <div class="col-md-12">
                                    <h2>@{{ interviewType }}</h2>
                                </div>
                                <div class="col-md-6">
                                    <label for="candidateName">Candidate Name</label>
                                    <input
                                            id="candidateName"
                                            class='form-control'
                                            v-model="current.name"
                                            type="text"
                                            name="candidateName"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="comments">Schedule Comments</label>
                                    <input
                                            id="comments"
                                            class='form-control'
                                            v-model="current.comments"
                                            type="text"
                                            name="comments"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="from">From</label>
                                    <input
                                            id="from"
                                            class='form-control datepicker'
                                            v-model="current.from"
                                            name="from"
                                            type="text"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="to">To</label>
                                    <input
                                            id="to"
                                            class='form-control datepicker'
                                            v-model="current.to"
                                            name="to"
                                            type="text"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="interviewers">Interviewer(s)</label>
                                    <input
                                            id="interviewers"
                                            class='form-control'
                                            v-model="current.interviewers"
                                            type="text"
                                            name="interviewers"
                                            multiple
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="location">Location</label>
                                    <input
                                            id="location"
                                            class='form-control'
                                            v-model="current.location"
                                            type="text"
                                            name="location"
                                    >
                                </div>
                            </div>
                            <div id="date-picker"> </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <div class="btn-group">
                                <button v-if="!lastInterview" v-on:click="increment" id="nextInterview" type="button" class="nextInterview btn btn-group btn-primary">
                                    <i class="nextInterview"></i><span class="fa fa-angle-right"></span> Next Interview
                                </button>
                                <button v-if="lastInterview && submitInterview" id="submitInterview" type="button" class="submitInterview btn btn-group btn-primary">
                                    <i class="submitInterview"></i>Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
