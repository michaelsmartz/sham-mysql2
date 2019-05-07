@extends('portal-index')
@section('title','Entitlements')
@section('content')
    <div class="flex-wrapper">
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
                                <a href="{{route('entitlements.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
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
                            <li data-filter-column="full_name">By Name</li>
                        </ul>
                    </li>
                    <hr>
                    <li>
                        <ul class="nav">
                            <li><p class="menu-label">Quick Filters</p></li>
                            <li><a href="{{route('entitlements.index')}}?is_manually_adjusted=1"><span class="icon circle info"></span>Yes</a></li>
                            <li><a href="{{route('entitlements.index')}}?is_manually_adjusted=0"><span class="icon circle default"></span>No</a></li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($entitlements) > 0)
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
            @if(count($entitlements) == 0)
                <h4 class="text-center">Its a bit empty here.
                    @if($allowedActions->contains('Create'))
                    You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new entitlement
                    @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Employee Name</th>
                            <th data-sortable="true">Leave Policy</th>
                            <th data-sortable="true">Valid From</th>
                            <th data-sortable="true">Valid To</th>
                            <th data-sortable="true">Total</th>
                            <th data-sortable="true">Taken</th>
                            <th data-sortable="true">Adjustable</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entitlements as $entitlement)
                            @foreach($entitlement->absenceTypes as $absenceType)
                            <tr id="tr{{$entitlement->id}}">
                                <td>{{ $entitlement->full_name }}</td>
                                <td>{{ $absenceType->description }}</td>
                                <td>{{ $absenceType->pivot->start_date }}</td>
                                <td>{{ $absenceType->pivot->end_date }}</td>
                                <td>{{ $absenceType->pivot->total }}</td>
                                <td>{{ $absenceType->pivot->taken }}</td>
                                <td>{{ ($absenceType->pivot->is_manually_adjusted) ? 'Yes' : 'No' }}</td>

                                <td data-html2canvas-ignore="true">
                                    <div class="btn-group btn-group-xs" role="group">
                                        @if($allowedActions->contains('Write'))
                                            <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$entitlement->id}}', event)">
                                                <i class="glyphicon glyphicon-edit text-primary"></i>
                                            </a>
                                        @endif
                                        @if($allowedActions->contains('Delete'))
                                            <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$entitlement->id}}')">
                                                <i class="glyphicon glyphicon-remove text-danger"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $entitlements->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'entitlements.destroy'])
            @endcomponent
        </div>
    </div>
@endsection