@extends('portal-index')
@section('title','Asset Allocation')
@section('subtitle','Allocate and manage your assets per groups, suppliers or employees')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li  class="active"><a href="{{URL::to('/')}}/asset_groups">Asset Groups</a></li>
        <li><a href="{{URL::to('/')}}/asset_suppliers">Suppliers</a></li>
        <li><a href="{{URL::to('/')}}/assets">Asset List</a></li>
        <li><a href="{{URL::to('/')}}/asset_allocations">Asset Allocation</a></li>
    </ul>
    <div class="flex-wrapper">
        @if($allowedActions->contains('List'))
            <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation">
                <form action="" class="">
                    <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                        <li>
                            <input type="hidden" name="name" class="submitable-column-name" id="submitable-column-name" value="">
                            <div class="table-search-form">
                                <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                                <div class="search-option">
                                    <button type="submit" data-wenk="Do the Search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <a href="{{route('asset_groups.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="table-search-form" style="height:50px">
                                <button type="button" class="search-column-chooser-btn">
                                    <p class="search-small">Search by</p>
                                    <p class="search-large">Name</p>
                                </button>
                            </div>
                            <ul class="search-column-list">
                                <li data-filter-column="name">By Name</li>
                                <li data-filter-column="description">By Description</li>
                            </ul>
                        </li>
                    </ul>
                </form>
            </div>
        @endif
        <div id="table-container">
            @if(count($assetGroups) > 0)
                <div id="toolbar" class="shadow-eff1">
                    <div class="btn-group">
                        @if($allowedActions->contains('List'))
                            <button id="sidebarCollapse" class="btn btn-default" data-toggle="offcanvas">
                                <i class="glyphicon glyphicon-align-left"></i>
                                <span>Filters</span>
                            </button>
                        @endif
                        @if($allowedActions->contains('Create'))
                            <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="right">
                                <i class="glyphicon glyphicon-plus"></i> <strong>Add New</strong>
                            </button>
                        @endif
                    </div>
                </div>
            @endif
            <div class="table-responsive">
            @if(count($assetGroups) == 0)
                <h4 class="text-center">Its a bit empty here.
                    @if($allowedActions->contains('Create'))
                        You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new asset group
                    @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Name</th>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assetGroups as $assetGroup)
                        <tr id="tr{{$assetGroup->id}}">
                            <td>{{ $assetGroup->name }}</td>
                            <td>{{ $assetGroup->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                 @if($allowedActions->contains('Write'))
                                    <a href="#light-modal" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editForm('{{$assetGroup->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                @endif
                                @if($allowedActions->contains('Delete'))
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$assetGroup->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $assetGroups->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'asset_groups.destroy'])
            @endcomponent
        </div>
    </div>
@endsection