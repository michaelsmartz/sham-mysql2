@extends('portal-index')
@section('title','Offers')
@section('subtitle','Offers drop-down values for the Recruitment module')
@section('content')
    <br>
    <ul class="nav nav-tabs">
        <li><a href="{{URL::to('/')}}/contracts">Contracts</a></li>
        <li><a href="{{URL::to('/')}}/interviews">Interviews</a></li>
        <li class="active"><a href="#">Offers</a></li>
        <li><a href="{{URL::to('/')}}/qualification-recruitments">Qualifications</a></li>
    </ul>
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($offers) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($offers) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new offer</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Description</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offers as $offer)
                        <tr id="tr{{$offer->id}}">
                                                        <td>{{ $offer->description }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <button type="button" class="b-n b-n-r bg-transparent item-edit" data-wenk="Edit" onclick="editFullPage('{{$offer->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $offers->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'offers.destroy'])
            @endcomponent
        </div>
    </div>
@endsection