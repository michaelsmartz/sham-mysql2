@extends('portal-index')
@section('title','Import data')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-1" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-download"></i></a>
                        <p><small>Step <span>1</span>: <span>Download the Template</span></small></p>
                    </div>
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-2" type="button" class="btn btn-success btn-circle"><i class="fa fa-clone"></i></a>
                        <p><small>Map Columns</small></p>
                    </div>
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-check"></i></a>
                        <p><small>Import Results</small></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
                <div class="panel panel-primary setup-content">
                    <div class="panel-heading">Map Columns</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('import_process') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

                            <table class="table">
                                @if (isset($csv_header_fields))
                                <tr>
                                    @foreach ($csv_header_fields as $csv_header_field)
                                        <th>{{ $csv_header_field }}</th>
                                    @endforeach
                                </tr>
                                @endif
                                @foreach ($csv_data as $row)
                                    <tr>
                                    @foreach ($row as $key => $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                    </tr>
                                @endforeach
                                 
                                <tr>
                                    @foreach ($csv_data[0] as $key => $value)
                                        <td>
                                            <select name="fields[{{ $key }}]">
                                                @foreach (\App\CsvData::$dbFields as $db_field)
                                                    <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}"
                                                        @if ($key === $db_field) selected @endif>{{ $db_field }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @endforeach
                                </tr>
                                
                            </table>

                            <button type="submit" class="btn btn-primary">
                                Import Data
                            </button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection


@section('scripts')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/css/import_steps.min.css">
@endsection