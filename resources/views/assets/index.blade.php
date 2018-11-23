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
        <div id="table-container">
            @if(count($assets) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    @if($allowedActions->contains('Create'))
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                    @endif
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($assets) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new asset</h4>
            @else
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