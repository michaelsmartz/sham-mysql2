@extends('portal-index')
@section('title', "Reports" )
@section('subtitle', "" )

@section('content')
    <style>
        iframe {
            overflow-y: hidden;
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .report-container {
            position: relative;
            height: 0;
            padding-bottom: 56.25%;
            overflow: hidden;
        }

        iframe > #reportico-container > .swMenuForm {
            height: 100% !important;
            border-radius: 0.25rem 0.25rem 0px 0px !important;
            border: 2px solid #f2f2f2 !important;
            margin: auto 0 !important;
        }

        .swMenuForm {
            border-radius: 0.25rem 0.25rem 0px 0px !important;
            border: 2px solid #f2f2f2 !important;
        }

        iframe > body > #reportico-container > .smallbanner {
            display: none !important;
        }

    </style>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 report-container">
            <iframe id="ifrReport" allowtransparency="true" frameborder="0" marginwidth="0"
                    src="{{env('REPORT_BASE_URL')}}{{env('REPORT_LAUNCHER_PAGE')}}?printable_html=true&template=sham&access_mode=ONEPROJECT&initial_execute_mode=MENU&clear_session=1&project=Smartz-Ham&random={{urlencode($str)}}"></iframe>
        </div>
    </div>

@stop
