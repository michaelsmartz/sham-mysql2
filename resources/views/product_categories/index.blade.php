@extends('portal-index')
@section('title','Quality Assurance')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li ><a href="{{URL::to('/')}}/category_question_types">Category Question Type</a></li>
        <li class="active"><a href="#">Product Categories</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($productCategories) > 0)
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
            @if(count($productCategories) == 0)
                <h4 class="text-center">Its a bit empty here.
                    @if($allowedActions->contains('Create'))
                        You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new product category
                    @endif
                </h4>
            @elseif($allowedActions->contains('List'))
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productCategories as $productCategory)
                        <tr id="tr{{$productCategory->id}}">
                            <td>{{ $productCategory->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$productCategory->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$productCategory->id}}')">
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
                    {!! $productCategories->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'product_categories.destroy'])
            @endcomponent
        </div>
    </div>
@endsection