@extends('portal-index')
@section('title','Recruitment')
@section('content')
    <section id="recruitment-request">
        <ul class="nav steps">
            <li class="tab-item orange active">
                <a class="tab-link active show" href="#request" data-toggle="tab">
                    <h2>1</h2>
                    <small>Recruitment Request</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="tab-item orange">
                <a class="tab-link" href="#justification" data-toggle="tab">
                    <h2>2</h2>
                    <small>Justification</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="tab-item blue">
                <a class="tab-link" href="#verification" data-toggle="tab" @click="selectedCategory='interviewing'">
                    <h2>3</h2>
                    <small>HR verification</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="tab-item blue">
                <a class="tab-link" href="#status" data-toggle="tab" @click="selectedCategory='offer'">
                    <h2>4</h2>
                    <small>Recruitment Status</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="tab-item green">
                <a class="tab-link" href="#applicants" data-toggle="tab" @click="selectedCategory='contract'">
                    <h2>5</h2>
                    <small>Applicants</small>
                </a>
                <div class="arrow"></div>
            </li>

            <li class="tab-item green">
                <a class="tab-link" href="#hired" data-toggle="tab" @click="selectedCategory='hired'">
                    <h2>6</h2>
                    <small>Hired</small>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="request">
                <form
                        @submit="checkForm"
                        action=""
                        method="post"
                >
                    <div v-if="errors.length">
                        <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="error in errors">@{{ error }}</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="jobTitle">Job title</label>
                            <input
                                    id="jobTitle"
                                    class='form-control'
                                    v-model="jobTitle"
                                    type="text"
                                    name="jobTitle"
                            >
                        </div>

                        <div class="form-group col-xs-12">
                            <label for="shortDescription">Short description</label>
                            <input
                                    id="shortDescription"
                                    class='form-control'
                                    v-model="shortDescription"
                                    type="text"
                                    name="shortDescription"
                            >
                        </div>

                        <div class="form-group col-xs-12">
                            <label for="description">Description</label>
                            <textarea
                                    id="description"
                                    class='form-control'
                                    v-model="description"
                                    name="description">
                            </textarea>
                        </div>

                        <div class="form-group col-xs-12">
                            <label for="show">Show salary</label>
                            <input type="checkbox" v-model="showSalary">
                        </div>

                        <transition name="fade">
                            <div v-if="showSalary" class="form-group col-xs-12">
                                <label for="salary">Salary</label>
                                <input
                                        id="salary"
                                        class='form-control'
                                        v-model="salary"
                                        name="salary"
                                        type="number"
                                        min="0"
                                >
                            </div>
                        </transition>

                        <div class="form-group col-xs-12">
                            <label for="department">Select department</label>
                            <select v-model="selectedDepartment" class='form-control' @change="selectedDepartmentFunc()">
                                <option disabled value="">Please select one</option>
                                <option v-for="department in departments" :value="department">@{{department}}</option>
                            </select>
                        </div>

                        <div class="form-group col-xs-12">
                            <label for="employmentType">Select employment type</label>
                            <select v-model="selectedEmploymentType" class='form-control' @change="selectedEmploymentTypeFunc()">
                                <option disabled value="">Please select one</option>
                                <option v-for="employmentType in employmentTypes" :value="employmentType">@{{employmentType}}</option>
                            </select>
                        </div>

                        <div class="box-footer">
                            <input class="btn btn-primary pull-right" type="submit" value="Submit">
                            <a href="" class="btn btn-default pull-right" title="Show all Recruitment Request">
                                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="justification"></div>
        </div>
    </section>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/nav-wizard.min.css" rel="stylesheet">
    <link href="{{URL::to('/')}}/css/recruitment-request.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment-request.min.js"></script>
@endsection