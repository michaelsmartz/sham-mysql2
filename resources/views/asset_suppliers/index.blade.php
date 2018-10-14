@extends('portal-index')
@section('title','Asset Allocation')
@section('subtitle','Allocate and manage your assets per groups, suppliers or employees')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/asset_groups">Asset Groups</a></li>
        <li class="active"><a href="{{URL::to('/')}}/asset_suppliers">Suppliers</a></li>
        <li><a href="{{URL::to('/')}}/assets">Asset List</a></li>
        <li><a href="{{URL::to('/')}}/asset_allocations">Asset Allocation</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($assetSuppliers) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($assetSuppliers) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new asset supplier</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Name</th>
                            <th data-sortable="true">Telephone</th>
                            <th data-sortable="true">Email Address</th>
                            <th data-sortable="true">Comments</th>
                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assetSuppliers as $assetSupplier)
                        <tr id="tr{{$assetSupplier->id}}">
                            <td>{{ $assetSupplier->name }}</td>
                            <td>{{ $assetSupplier->telephone }}</td>
                            <td>{{ $assetSupplier->email_address }}</td>
                            <td>{{ $assetSupplier->comments }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$assetSupplier->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$assetSupplier->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $assetSuppliers->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'asset_suppliers.destroy'])
            @endcomponent
        </div>
    </div>
@endsection