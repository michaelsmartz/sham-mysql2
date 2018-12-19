@extends('portal-index')
@section('title','Recruitment Pipeline')
@section('content')
    <br>
    <section id="recruitment">
        <ul class="nav nav-tabs steps">
            <li class="orange nav-item">
                <a class="nav-link active show" href="#applied" role="tab" data-toggle="tab" @click="selectedCategory='applied'">
                    <h2>4</h2>
                    <small>Applied</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="orange nav-item">
                <a class="nav-link" href="#review" role="tab" data-toggle="tab" @click="selectedCategory='review'">
                    <h2>4</h2>
                    <small>Review</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="blue nav-item">
                <a class="nav-link" href="#interviewing" role="tab" data-toggle="tab" @click="selectedCategory='interviewing'">
                    <h2>3</h2>
                    <small>Interviewing</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="blue nav-item">
                <a class="nav-link" href="#offer" role="tab" data-toggle="tab" @click="selectedCategory='offer'">
                    <h2>2</h2>
                    <small>Offer</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="green nav-item">
                <a class="nav-link" href="#contract" role="tab" data-toggle="tab" @click="selectedCategory='contract'">
                    <h2>1</h2>
                    <small>Contract</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="green nav-item">
                <a class="nav-link" href="#hired" role="tab" data-toggle="tab" @click="selectedCategory='hired'">
                    <h2>1</h2>
                    <small>Hired</small>
                </a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="applied">
                @component('recruitments.step', ['step' => [
                    ['id'=>'item-approve','btnclass'=>'btn btn-primary','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Approve for review'],
                    ['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Reject applicant']
                ] ])
                @endcomponent
            </div>
            <div class="tab-pane"  role="tabpanel" id="review">
                @component('recruitments.step', ['step' => [
                    ['id'=>'item-approve','btnclass'=>'btn btn-primary','class'=>'glyphicon glyphicon-thumbs-up','label'=>'Schedule interview'],
                    ['id'=>'item-reject','btnclass'=>'btn btn-link','class'=>'glyphicon glyphicon-thumbs-down','label'=>'Not-approved']
                ] ])
                @endcomponent
            </div>
            <div class="tab-pane"  role="tabpanel" id="interviewing">
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
            <div class="tab-pane"  role="tabpanel" id="offer">
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
            <div class="tab-pane"  role="tabpanel" id="contract">
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
            <div class="tab-pane" role="tabpanel" id="hired">
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