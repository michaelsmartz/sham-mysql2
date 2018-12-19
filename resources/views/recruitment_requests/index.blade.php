@extends('portal-index')
@section('title','Recruitment Requests')
@section('content')
    <div  id="jobs" class="flex-wrapper">
        <div id="table-container">
            {{--@if(count($requests) > 0)--}}
                <div id="toolbar" class="shadow-eff1">
                    <div class="btn-group">
                        {{--@if($allowedActions->contains('Create'))--}}
                            <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                                <i class="glyphicon glyphicon-plus"></i> Add New
                            </button>
                        {{--@endif--}}
                    </div>
                </div>
            {{--@endif--}}
            <div>
                {{--@if(count($requests) == 0)--}}
                    {{--<h4 class="text-center">Its a bit empty here.--}}
                        {{--@if($allowedActions->contains('Create'))--}}
                            {{--You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new Recruitment Request--}}
                        {{--@endif--}}
                    {{--</h4>--}}
                {{--@elseif($allowedActions->contains('List'))--}}

                    <v-client-table :columns="columns" :data="data" :options="options">
                        {{--@if($allowedActions->contains('Write'))--}}
                            <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm(1, event)">
                                <i class="glyphicon glyphicon-edit text-primary"></i>
                            </a>
                        {{--@endif--}}
                        {{--@if($allowedActions->contains('Delete'))--}}
                            <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm(1)">
                                <i class="glyphicon glyphicon-remove text-danger"></i>
                            </button>
                        {{--@endif--}}
                    </v-client-table>
                    @component('partials.index', ['routeName'=> 'recruitment_requests.destroy'])
                    @endcomponent

                    <nav>
                        {{--{!! $requests->render() !!}--}}
                    </nav>
                {{--@endif--}}
            </div>
            @component('partials.index', ['routeName'=> 'branches.destroy'])
            @endcomponent
        </div>
    </div>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/recruitment-request.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment-request.min.js"></script>
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>
@endsection