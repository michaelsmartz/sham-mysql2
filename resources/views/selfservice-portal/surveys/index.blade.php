@extends('portal-index')
@section('title','My Surveys')

@section('content')
    <section id="survey">
        <p></p>
        <div class="row">
            @if( sizeof($surveys) == 0)
                <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 text-success">
                    There are no surveys available for the moment
                </div>
            @else
                @foreach($surveys as $survey)
                    <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
                        <div class="thumbnail">
                            <h4>
                                <span data-toggle="tooltip" title="{{$survey->title}}">{{$survey->title}}</span>
                                <span class="label label-primary info pull-right">
                                    <span data-wenk="From {{\Carbon\Carbon::parse($survey->date_start)->toDateString()}} to {{\Carbon\Carbon::parse($survey->date_end)->toDateString()}}"><i class="glyphicon glyphicon-calendar"></i> </span>
                                </span>
                            </h4>
                            <a href="#light-modal" class="btn btn-primary col-xs-12 item-edit" onclick="showForm('{{ $survey->id }}', event)" role="button">Complete this survey</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        @component('partials.index', ['routeName'=> 'my-surveys.destroy'])
        @endcomponent
    </section>
@endsection
