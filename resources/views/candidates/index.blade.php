@extends('portal-index')
@section('title','Candidates')
@section('content')
    <div class="row">
    <div id="candidates-table" class="flex-wrapper">
        <div id="table-container">

            <div class="btn-group">
                <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                    <i class="glyphicon glyphicon-plus"></i> Add New
                </button>
            </div>
            <br>
            <div>
                <v-client-table :columns="columns" :data="data" :options="options">
                    {{--<div slot="child_row" slot-scope="props">--}}
                        {{--<v-client-table :columns="subColumns" :data="props.row.attachments" :options="subOptions"></v-client-table>--}}
                    {{--</div>--}}
                    <button slot="download" slot-scope="props" data-wenk="download cv" class="b-n b-n-r bg-transparent item-download" v-on:click="download(props.row.id)">
                        <i class="glyphicon glyphicon-download text-primary"></i>
                    </button>
                    <button slot="edit" slot-scope="props" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" v-on:click="edit(props.row.id)">
                        <i class="glyphicon glyphicon-edit text-primary"></i>
                    </button>
                    <button slot="delete" slot-scope="props" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" v-on:click="erase(props.row.id)">
                        <i class="glyphicon glyphicon-remove text-danger"></i>
                    </button>
                </v-client-table>
            </div>
            @component('partials.index', ['routeName'=> 'candidates.destroy'])
            @endcomponent
        </div>
    </div>
    </div>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>
@endsection