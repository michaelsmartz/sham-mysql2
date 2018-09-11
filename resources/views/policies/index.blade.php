@extends('portal-index')
@section('title','Compliance')
@section('subtitle', 'Share compliance documents with your employees')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li ><a href="{{URL::to('/')}}/laws">Laws</a></li>
        <li class="active"><a href="#">Policies</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($policies) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($policies) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a to add a new policy</h4>
            @else
                <table id="table" data-toggle="table" data-detail-view="true">
                    <thead>
                        <tr>
                            <th data-sortable="true">Title</th>
                            <th data-sortable="true">Policy Category</th>
                            <th data-sortable="true">Expires On</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($policies as $policy)
                        <tr id="tr{{$policy->id}}" data-id="{{$policy->id}}" data-url="{{url()->current()}}">
                            <td>{{ $policy->title }}</td>
                            <td>{{  isset($policy->policyCategory->description) ? $policy->policyCategory->description : ''  }}</td>
                            <td>{{ $policy->expires_on }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editForm('{{$policy->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$policy->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $policies->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'policies.destroy'])
            @endcomponent
        </div>
    </div>
@endsection