@extends('portal-index')
@section('title','Candidates')
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
                                <a href="{{route('candidates.index')}}" role="button" data-wenk="Reset all Criteria & reload the list">
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
                            <li data-filter-column="first_name">By FirstName</li>
                            <li data-filter-column="surname">By Surname</li>
                            <li data-filter-column="email">By Email</li>
                            <li data-filter-column="phone">By Phone</li>
                            <li data-filter-column="position_applying_for">By Position Applying For</li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($candidates) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($candidates) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new candidate</h4>
            @else
                <table id="table" data-toggle="table" data-detail-view="true">
                    <thead>
                        <tr>
                            <th data-sortable="true">First Name</th>
                            <th data-sortable="true">Surname</th>
                            <th data-sortable="true">Email</th>
                            <th data-sortable="true">Phone</th>
                            <th data-sortable="true">Position Applying For</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                        <tr id="tr{{$candidate->id}}" data-id="{{$candidate->id}}" data-url="{{url()->current()}}">
                            <td>{{ $candidate->first_name }}</td>
                            <td>{{ $candidate->surname }}</td>
                            <td>{{ $candidate->email }}</td>
                            <td>{{ $candidate->phone }}</td>
                            <td>{{ $candidate->position_applying_for }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                        <button type="button" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editFullPage('{{$candidate->id}}', event)">
                                            <i class="glyphicon glyphicon-edit text-primary"></i>
                                        </button>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                        <button type="button" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$candidate->id}}')">
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
                    {!! $candidates->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'candidates.destroy'])
            @endcomponent
        </div>
    </div>
@endsection