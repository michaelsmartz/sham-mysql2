@extends('portal-index')
@section('title','Topics')
@section('content')
    <div class="flex-wrapper">
        <div id="table-container">
            @if(count($topics) > 0)
            <div id="toolbar" class="shadow-eff1">
                <div class="btn-group">
                    <button id="item-create" type="button" class="btn btn-sham" data-wenk="Add new" data-wenk-pos="bottom" onclick="addForm(event)">
                        <i class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
            </div>
            @endif
            <div class="table-responsive">
            @if(count($topics) == 0)
                <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a to add a new topic</h4>
            @else
                <table id="new-table" data-toggle="table">
                    <thead>
                        <tr>
                                                        <th data-sortable="true">Topic Heading</th>

                            <th data-sortable="false" data-tableexport-display="none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topics as $topic)
                        <tr id="tr{{$topic->id}}">
                                                        <td>{{ $topic->header }}</td>

                            <td data-html2canvas-ignore="true">
                                <div class="btn-group btn-group-xs" role="group">
                                    <button data-wenk="Edit" type="button" class="b-n b-n-r bg-transparent item-edit" onclick="editForm('{{$topic->id}}', event)">
                                        <i class="glyphicon glyphicon-edit text-primary"></i>
                                    </button>
                                    <button type="submit" class="b-n b-n-r bg-transparent item-remove" data-wenk="Remove" onclick="deleteForm('{{$topic->id}}')">
                                        <i class="glyphicon glyphicon-remove text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav>
                    {!! $topics->render() !!}
                </nav>
            @endif
            </div>
            @component('partials.index', ['routeName'=> 'topics.destroy'])
            @endcomponent
        </div>
    </div>
@endsection