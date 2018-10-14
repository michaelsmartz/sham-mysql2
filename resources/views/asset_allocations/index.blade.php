@extends('portal-index')
@section('title','Asset Allocation')
@section('subtitle','Allocate and manage your assets per groups, suppliers or employees')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/asset_groups">Asset Groups</a></li>
        <li><a href="{{URL::to('/')}}/asset_suppliers">Suppliers</a></li>
        <li><a href="{{URL::to('/')}}/assets">Asset List</a></li>
        <li class="active"><a href="{{URL::to('/')}}/asset_allocations">Asset Allocation</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($assetEmployees) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($assetEmployees) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new asset employee</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Asset</th>
                            <th data-sortable="true">Tag</th>
                            <th data-sortable="true">Employee</th>
                            <th data-sortable="true">Date Out</th>
                            <th data-sortable="true">Date In</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assetEmployees as $assetEmployee)
                        <tr id="tr{{$assetEmployee->id}}">
                            <td>{{ optional($assetEmployee->asset)->name }}</td>
                            <td><span class="badge badge-info">{{ optional($assetEmployee->asset)->tag }}</span></td>
                            <td>{{ optional($assetEmployee->employee)->full_name }}</td>
                            <td>{{ $assetEmployee->date_out }}</td>
                            <td>{{ $assetEmployee->date_in }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$assetEmployee->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $assetEmployees->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'asset_allocations.destroy'])
            @endcomponent
        </div>
    </div>
@endsection