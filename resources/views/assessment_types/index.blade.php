@extends('portal-index')
@section('title','E-learning')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Module Assessment Type</a></li>
        {{--<li><a href="{{URL::to('/')}}/learning_material_types">Learning Material Type</a></li>
        <li><a href="{{URL::to('/')}}/training_delivery_methods">Training Delivery Method</a></li>--}}
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($assessmentTypes) > 0)
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
            @if(count($assessmentTypes) == 0)
                <h4 class="text-center">Its a bit empty here.
                    @if($allowedActions->contains('Create'))
                        You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new assessment type
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
                        @foreach($assessmentTypes as $assessmentType)
                        <tr id="tr{{$assessmentType->id}}">
                            <td>{{ $assessmentType->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    @if($allowedActions->contains('Write'))
                                    <a href="#light-modal" data-wenk="Edit" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$assessmentType->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </a>
                                    @endif
                                    @if($allowedActions->contains('Delete'))
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$assessmentType->id}}')">
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
                    {!! $assessmentTypes->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'assessment_types.destroy'])
            @endcomponent
        </div>
    </div>
@endsection