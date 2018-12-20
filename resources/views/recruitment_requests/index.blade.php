@extends('portal-index')
@section('title','Recruitment Requests')
@section('content')
    <div id="recruitment-requests-table" class="flex-wrapper">
        <div id="table-container">

            <div class="btn-group">
                <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                    <i class="glyphicon glyphicon-plus"></i> Add New
                </button>
            </div>
            <br>
            <div>
                <v-client-table :columns="columns" :data="data" :options="options">
                    <button slot="edit" slot-scope="props" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" v-on:click="edit(props.row.id)">
                        <i class="glyphicon glyphicon-edit text-primary"></i>
                    </button>
                    <button slot="stages" slot-scope="props" class="b-n b-n-r bg-transparent item-view" data-wenk="View stages" v-on:click="stages(props.row.id)">
                        <i class="glyphicon glyphicon-eye-open text-primary"></i>
                    </button>
                    <button slot="delete" slot-scope="props" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" v-on:click="delete(props.row.id)">
                        <i class="glyphicon glyphicon-remove text-danger"></i>
                    </button>
                </v-client-table>
            </div>
            @component('partials.index', ['routeName'=> 'recruitment_requests.destroy'])
            @endcomponent
        </div>
    </div>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/recruitment-request.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/recruitment-request.min.js"></script>
@endsection