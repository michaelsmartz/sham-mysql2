@extends('portal-index')
@section('title','Asset Suppliers')
@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="cd-filter">
      <form>
        <div class="cd-filter-block">
          <h4>Search</h4>
          <div class="cd-filter-content">
            <input placeholder="Try color-1..." type="search">
          </div>
        </div>
        <div class="cd-filter-block">
          <h4>Check boxes</h4>
          <ul class="cd-filter-content cd-filters list">
            <li>
              <input class="filter" data-filter=".check1" id="checkbox1" type="checkbox">
              <label class="checkbox-label" for="checkbox1">Option 1</label>
            </li>
            <li>
              <input class="filter" data-filter=".check2" id="checkbox2" type="checkbox">
              <label class="checkbox-label" for="checkbox2">Option 2</label>
            </li>
            <li>
              <input class="filter" data-filter=".check3" id="checkbox3" type="checkbox">
              <label class="checkbox-label" for="checkbox3">Option 3</label>
            </li>
          </ul>
        </div>
        <div class="cd-filter-block">
          <h4>Select</h4>
          <div class="cd-filter-content">
            <div class="cd-select cd-filters">
              <select class="filter" name="selectThis" id="selectThis">
                <option value="">Choose an option</option>
                <option value=".option1">Option 1</option>
                <option value=".option2">Option 2</option>
                <option value=".option3">Option 3</option>
                <option value=".option4">Option 4</option>
              </select>
            </div>
          </div>
        </div>
        <div class="cd-filter-block">
          <h4>Radio buttons</h4>
          <ul class="cd-filter-content cd-filters list">
            <li>
              <input class="filter" data-filter="" name="radioButton" id="radio1" checked="" type="radio">
              <label class="radio-label" for="radio1">All</label>
            </li>
            <li>
              <input class="filter" data-filter=".radio2" name="radioButton" id="radio2" type="radio">
              <label class="radio-label" for="radio2">Choice 2</label>
            </li>
            <li>
              <input class="filter" data-filter=".radio3" name="radioButton" id="radio3" type="radio">
              <label class="radio-label" for="radio3">Choice 3</label>
            </li>
          </ul>
        </div>
      </form>
      <a href="#0" class="cd-close">Close</a>
    </div>

    <div id="toolbar">
        <button id="item-create" type="button" class="btn btn-sham tooltips" title="Add new" onclick="addForm(event)">
            <i class="glyphicon glyphicon-plus text-white"></i>
        </button>
        <a href="{{route('assetsuppliers.index')}}?is_active=1" class="nav-link" 
            class="badge badge-default">
            <span class="badge badge-ring badge-success"></span>
            <span>Active</span>
        </a>
        <a href="{{route('assetsuppliers.index')}}?name=VVM" class="nav-link" 
            class="badge badge-default">
            <span class="badge badge-ring badge-purple"></span>
            <span>VVM</span>
        </a>
        <a href="{{route('assetsuppliers.index')}}?name=VVM&is_active=1" class="nav-link" 
            class="badge badge-default">
            <span class="badge badge-ring badge-purple"></span>
            <span>VVM (active)</span>
        </a>        
        <a href="{{route('assetsuppliers.index')}}" class="nav-link" 
            class="badge badge-default">
            <span class="badge badge-ring badge-info"></span>
            <span>Reset</span>
        </a>
    </div

    <div class="">
        
        @if(count($assetSuppliers) == 0)
            <h4 class="text-center">No Asset Suppliers Available!</h4>
        @else

            <table id="new-table" 
                    data-toggle="table" 
                    class="light-table table-no-bordered" 
                    data-classes="light-table table-no-bordered" 
                    data-buttons-class="default"
                    data-toolbar="#toolbar"
                    data-show-columns="true"
                    data-show-export="true" 
                    data-export-options='{"fileName": "Asset Suppliers"}'
                    data-export-types="['excel','csv']" >
                    <thead>
                        <tr>
                            <th data-sortable="true">Name</th>
                            <th data-sortable="true">Telephone</th>
                            <th data-sortable="true">Email Address</th>
                            <th data-visible="false" data-sortable="true">Comments</th>
                            <th data-sortable="true">Is Active</th>
                            <th data-sortable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($assetSuppliers as $assetSupplier)
                        <tr>
                            <td>{{ $assetSupplier->name }}</td>
                            <td>{{ $assetSupplier->telephone }}</td>
                            <td>{{ $assetSupplier->email_address }}</td>
                            <td>{{ $assetSupplier->comments }}</td>
                            <td>{{ ($assetSupplier->is_active) ? 'Yes' : 'No' }}</td>
                            <td>
                              <div class="dropdown">
                                <a href="#" data-toggle="dropdown"><i class="fa fa-ellipsis-v text-grey-light"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#">
                                    <i class="fa fa-fw fa-edit"></i> Edit</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" href="#">
                                    <i class="fa fa-fw fa-trash"></i> Delete</a>
                                </div>
                              </div>
                              <!--
                                <div class="btn-group btn-group-xs pull-right" role="group">
                                    <button title="Edit" type="button" class="b-n b-n-r bg-transparent item-edit tooltips" onclick="editForm($(this).closest('tr').data('id'), event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>

                                    <button type="submit" class="b-n b-n-r bg-transparent item-remove tooltips" title="Remove" onclick="return confirm(&quot;Delete Asset Supplier?&quot;)">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                                -->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
       
        @endif
    </div>

@endsection

@section('scripts')
<style>
    #toolbar {
        display: inline-table;
        box-sizing: border-box;
    }
    #toolbar .search-tools{
        display: table-cell;
        padding-left: 10px;
    }
</style>
    <link rel="stylesheet" href="/css/vendors/search_tools/search_tools.css">
@endsection    