@extends('portal-index')
@section('title','Assets')
@section('subtitle','Allocate and manage your assets per groups, suppliers or employees')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/asset_groups">Asset Groups</a></li>
        <li><a href="{{URL::to('/')}}/asset_suppliers">Suppliers</a></li>
        <li class="active"><a href="{{URL::to('/')}}/assets">Asset List</a></li>
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
                                    <a href="{{route('assets.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
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
                                <li data-filter-column="tag">By Tag</li>
                                <li data-filter-column="serial_no">By Serial No</li>
                                <li data-filter-column="purchase_price">By Purchase Price</li>
                                <li data-filter-column="po_number">By PO Number</li>
                                <li data-filter-column="warranty_expiry_date">By Warranty Expiry Date</li>
                                <li data-filter-column="comments">By Comment</li>
                            </ul>
                            <hr>
                            <li>
                                <ul class="nav">
                                    <li><p class="menu-label">Quick Filters</p></li>
                                    <li><a href="{{route('assets.index')}}?is_available=1"><span class="icon circle info"></span>Available</a></li>
                                    <li><a href="{{route('assets.index')}}?is_available=0"><span class="icon circle default"></span>Not Available</a></li>
                                </ul>
                            </li>
                        </li>
                    </ul>
                </form>
            </div>
        @endif
        <div id="table-container">
            @if(count($assets) > 0)
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
            @if(count($assets) == 0)
                <h4 class="text-center">Its a bit empty here.
                    @if($allowedActions->contains('Create'))
                        You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new asset
                    @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Name</th>
                            <th data-sortable="true">Asset Group</th>
                            <th data-sortable="true">Asset Supplier</th>
                            <th data-sortable="true">Tag</th>
                            <th data-sortable="true">Serial No</th>
                            <th data-sortable="true">Is Available</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                        <tr id="tr{{$asset->id}}">
                            <td>{{ $asset->name }}</td>
                            <td>{{ optional($asset->assetGroup)->name }}</td>
                            <td>{{ optional($asset->assetSupplier)->name }}</td>
                            <td>{{ $asset->tag }}</td>
                            <td>{{ $asset->serial_no }}</td>
                            <td>{!! ($asset->is_available) ? '<span class="badge badge-info">Yes</span>' : '<span class="badge badge-default">No</span>' !!}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                 @if($allowedActions->contains('Write'))
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$asset->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                @endif
                                @if($allowedActions->contains('Delete'))
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$asset->id}}')">
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
                    {!! $assets->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'assets.destroy'])
            @endcomponent
        </div>
    </div>
@endsection