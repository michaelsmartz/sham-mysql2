@extends('portal-index')

@if(!empty($title))
    @section('title', $title)
@endif

@section('css')

@stop

@section('content')
    @if (!empty($warnings))
        <div class="row">
            <div class="col-md-12 ">
                <div class="box warning" >
                    <div class="iconArea"><p><i class="material-icons md-36 md-light glyphicon glyphicon-exclamation-sign"></i></p></div>
                    @foreach($warnings as $index => $warning)
                        <div class="copyArea"><p>{{$warning}}</p></div>
                        @if($index<count($warnings)-1))<br>@endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@stop

@section('post-body')
    <style>
        .container {
            margin: 0;
        }
        .box {
            padding: 0px 10px;
            overflow: hidden;
            margin: 20px 0;
            position: relative;
        }
        .iconArea {
            width:50px;
            float: left;
            display: inline-block;
            position: relative;
            top: 7px;
        }
        .copyArea {
            max-width: 850px;
            float: none;
            display:block;
            overflow: hidden;
            position: absolute;
            top: -5px;
            left: 55px;
        }
        .copyArea p {
            margin-top: 20px;
        }
        .closeArea {
            width: 30px;
            float: right;
        }
        .closeArea i {
            cursor: pointer;
        }

        .material-icons.md-36 { font-size: 36px; }
        .material-icons.md-light { color: rgba(255, 255, 255, .6); }

        .warning {
            background:salmon;
            border-radius: 3px;
        }

    </style>
@endsection