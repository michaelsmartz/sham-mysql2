@extends('portal-index')
@section('title','Recruitment Pipeline')
@section('content')
    <br>
    <section id="recruitment">
        <ul class="nav steps">
            <li class="tab-item orange">
                <a class="tab-link active show" href="#applied" data-toggle="tab" @click="selectedCategory='applied'">
                    <h2>4</h2>
                    <small>Applied</small>
                </a>
                <div class="arrow"></div>
            </li>
            <li class="tab-item orange">
                <a class="tab-link" href="#review" data-toggle="tab" @click="selectedCategory='review'">
                    <h2>4</h2>
                    <small>Review</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="tab-item blue">
                <a class="tab-link" href="#interviewing" data-toggle="tab" @click="selectedCategory='interviewing'">
                    <h3>3</h3>
                    <small>Interviewing</small>
                </a>
                <div class="arrow"></div>
            </li>
            <li class="tab-item blue">
                <a class="tab-link" href="#offer" data-toggle="tab" @click="selectedCategory='offer'">
                    <h2>2</h2>
                    <small>Offer</small>
                </a>
                <div class="arrow"></div>
            </li>
            <li class="tab-item green">
                <a class="tab-link" href="#contract" data-toggle="tab" @click="selectedCategory='contract'">
                    <h2>1</h2>
                    <small>Contract</small>
                </a>
                <div class="arrow"></div>
            </li>
            <li class="tab-item green">
                <a class="tab-link" href="#hired" data-toggle="tab" @click="selectedCategory='hired'">
                    <h2>1</h2>
                    <small>Hired</small>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane" id="applied">
                <ul class="people-list">
                    <li v-for="person in filteredPeople" v-on:click="setCurrent(person)">
                        <div class="img">
                        </div>
                        <div>
                            <div>@{{ person.name }}</div>
                            <div>@{{ person.jobTitle }}</div>
                        </div>
                    </li>
                </ul>
                <div class="tab-detail" v-show="current !== null">@{{ current.name }}</div>
            </div>
            <div class="tab-pane" id="review">
                <ul class="people-list">
                    <li v-for="person in filteredPeople">
                        <div class="img">
                        </div>
                        <div>
                            <div>@{{ person.name }}</div>
                            <div>@{{ person.jobTitle }}</div>
                        </div>
                    </li>
                </ul>
                <div class="tab-detail"></div>
            </div>
            <div class="tab-pane" id="interviewing">
                <ul class="people-list">
                    <li v-for="person in filteredPeople">
                        <div class="img">
                        </div>
                        <div>
                            <div>@{{ person.name }}</div>
                            <div>@{{ person.jobTitle }}</div>
                        </div>
                    </li>
                </ul>
                <div class="tab-detail"></div>
            </div>
            <div class="tab-pane" id="offer">
                <ul class="people-list">
                    <li v-for="person in filteredPeople">
                        <div class="img">
                        </div>
                        <div>
                            <div>@{{ person.name }}</div>
                            <div>@{{ person.jobTitle }}</div>
                        </div>
                    </li>
                </ul>
                <div class="tab-detail"></div>
            </div>
            <div class="tab-pane" id="contract">
                <ul class="people-list">
                    <li v-for="person in filteredPeople">
                        <div class="img">
                        </div>
                        <div>
                            <div>@{{ person.name }}</div>
                            <div>@{{ person.jobTitle }}</div>
                        </div>
                    </li>
                </ul>
                <div class="tab-detail"></div>
            </div>
            <div class="tab-pane" id="hired">
                <ul class="people-list">
                    <li v-for="person in filteredPeople">
                        <div class="img">
                        </div>
                        <div>
                            <div>@{{ person.name }}</div>
                            <div>@{{ person.jobTitle }}</div>
                        </div>
                    </li>
                </ul>
                <div class="tab-detail"></div>
            </div>
        </div>
    </section>
@endsection
@section('post-body')
<link href="{{URL::to('/')}}/css/nav-wizard.min.css" rel="stylesheet">
<script src="{{URL::to('/')}}/js/recruitment.min.js"></script>
@endsection