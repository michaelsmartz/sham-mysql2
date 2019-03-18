@extends('portal-index')
@section('title','Contracts')
@section('subtitle','Contract drop-down values for the Recruitment module')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">Contracts</a></li>
        <li><a href="{{URL::to('/')}}/interviews">Interviews</a></li>
        <li><a href="{{URL::to('/')}}/offers">Offers</a></li>
        <li><a href="{{URL::to('/')}}/qualification-recruitments">Qualifications</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($contracts) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($contracts) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new contract</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contracts as $contract)
                        <tr id="tr{{$contract->id}}">
                                                        <td>{{ $contract->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <button type="button" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editFullPage('{{$contract->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                    <button class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$contract->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $contracts->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'contracts.destroy'])
            @endcomponent
        </div>
    </div>
@endsection