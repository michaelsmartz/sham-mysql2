@extends('portal-index')
@section('title','Candidates')
@section('content')
    <div id="candidates">
        <v-client-table :columns="columns" :data="data" :options="options">
            <a slot="uri" slot-scope="props" target="_blank" :href="props.row.uri" class="glyphicon glyphicon-eye-open"></a>

            <div slot="child_row" slot-scope="props">
                The link to @{{props.row.name}} is <a :href="props.row.uri">@{{props.row.uri}}</a>
            </div>
        </v-client-table>
    </div>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/css/candidates.min.css" rel="stylesheet">
    <script src="{{URL::to('/')}}/js/candidates.min.js"></script>
@endsection