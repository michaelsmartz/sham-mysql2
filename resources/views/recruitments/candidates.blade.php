@extends('portal-index')
@section('title','Candidates')
@section('content')
    <div id="jobs">
        <v-client-table :columns="columns" :data="data" :options="options">
            <a slot="applicants" slot-scope="props" data-wenk="show applicants" target="_blank" :href="props.row.applicants" class="glyphicon glyphicon-eye-open"></a>

            <div slot="child_row" slot-scope="props">
                <div id="candidates">
                    <v-client-table :columns="subColumns" :data="props.row.applicants" :options="subOptions"></v-client-table>
                </div>
            </div>
        </v-client-table>
    </div>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>
@endsection