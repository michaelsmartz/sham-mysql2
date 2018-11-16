@extends('portal-index')
@section('title','Import data')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="{{route('import')}}" type="button" class="btn btn-default btn-circle"><i class="fa fa-download"></i></a>
                        <p><small><span>Download the Template</span></small></p>
                    </div>
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-clone"></i></a>
                        <p><small>Map Columns</small></p>
                    </div>
                    <div class="stepwizard-step col-xs-4"> 
                        <a href="#step-3" type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i></a>
                        <p><small>Import Results</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection