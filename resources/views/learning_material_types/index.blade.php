@extends('portal-index')
@section('title','E-learning')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/assessment_types">Module Assessment Type</a></li>
        {{--<li class="active"><a href="#">Learning Material Type</a></li>
        <li><a href="{{URL::to('/')}}/training_delivery_methods">Training Delivery Method</a></li>--}}
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($learningMaterialTypes) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($learningMaterialTypes) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new learning material type</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($learningMaterialTypes as $learningMaterialType)
                        <tr id="tr{{$learningMaterialType->id}}">
                                                        <td>{{ $learningMaterialType->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$learningMaterialType->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$learningMaterialType->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $learningMaterialTypes->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'learning_material_types.destroy'])
            @endcomponent
        </div>
    </div>
@endsection