@extends('blank')
@section('content')
<!DOCTYPE html>

<html lang="en">
<head>
   <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <?php include(public_path().'/css/sb-admin-2.css');?>
    </style> -->

    <style>

        #header { margin-left: 20px; top: 10px; right: 0px; height: 80px; text-align: left; }
        #footer { margin-left: 20px; display:inline; }

        .panel {
            /*margin-bottom: 20px;*/
            border: 2px solid;
           /* border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05); */
            display:block;
            margin-bottom: 20px;
        }

        .panel-body {
            padding: 15px;
        }
        .panel-heading {
            padding: 10px 15px;
           /* border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;*/
            background-color: lightblue;
        }
        .panel-heading > .dropdown .dropdown-toggle {
            color: inherit;
        }
        .panel-title {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 16px;
            color: inherit;
        }

        .pull-right {
            position: absolute; right: 10px;
        }
        input {
            display:inline;
            width: 50%;
            margin: 5px;
        }

        .hide {
            display: none;
            /*padding: 20px 10px; */
        }

        .form-group
        {
            padding-bottom: 20px;
        }

        #orgChart table { width : 100%; }

        #orgChart tr.lines td.line {
            width : 1px;
            height : 20px;
        }

        #orgChart tr.lines td.top { border-top : 1px dashed black; }

        #orgChart tr.lines td.left { border-right : 1px dashed black; }

        #orgChart tr.lines td.right { border-left : 0px dashed black; }

        #orgChart tr.lines td.half { width : 40%; }

        #orgChart td {
            text-align : left;
            vertical-align : top;
            padding : 0px 2px;
            width:25%
        }
        #orgChart th {
            text-align : left;
        }

        #orgChart .node {
            cursor : default;
            border : 1px solid #e7e7e7;
            display : inline-block;
            padding : 5px 5px 20px 5px;
            min-width : 96px;
            min-height : 60px;
            background: #ffffff; /* Old browsers */
            line-height : 1.3em;
            border-radius : 4px;
            -moz-border-radius : 4px;
            -webkit-border-radius : 4px;
            position: relative;
            box-shadow: 1px 1px 0px #ddd;
        }

        /* References: http://learn.shayhowe.com/html-css/organizing-data-with-tables/ */
        table {
            border-collapse: separate;
            border-spacing: 0;
            color: #4a4a4d;
            font: 14px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;
            width:100%;
        }
        th,
        td {
            padding: 10px 15px;
            vertical-align: middle;
        }
        thead {
            background: #395870;
            background: linear-gradient(#49708f, #293f50);
            color: #fff;
            font-size: 11px;
           /* text-transform: uppercase; */
        }
        th:first-child {
            border-top-left-radius: 5px;
            text-align: left;
        }
        th:last-child {
            border-top-right-radius: 5px;
        }
        tbody tr:nth-child(even) {
            background: #f0f0f2;
        }
        td {
            border-bottom: 1px solid #cecfd5;
            border-right: 1px solid #cecfd5;
        }
        td:first-child {
            border-left: 1px solid #cecfd5;
        }
        .book-title {
            color: #395870;
            display: block;
        }
        .text-offset {
            color: #7c7c80;
            font-size: 12px;
        }
        .item-stock,
        .item-qty {
            text-align: center;
        }
        .item-price {
            text-align: right;
        }
        .item-multiple {
            display: block;
        }
        tfoot {
            text-align: right;
        }
        tfoot tr:last-child {
            background: #f0f0f2;
            color: #395870;
            font-weight: bold;
        }
        tfoot tr:last-child td:first-child {
            border-bottom-left-radius: 5px;
        }
        tfoot tr:last-child td:last-child {
            border-bottom-right-radius: 5px;
        }

        textarea {
            word-wrap: break-word;
            white-space: pre-wrap;
            resize: auto;
            cursor: auto;
            height:auto;
        }

    </style>

</head>
    <body>
        <div class="row">
            <div id="header">
                <img src="{{public_path()}}/images/logo-gold-header2.png">
            </div>
            <hr/><br/>
        </div>
        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th scope="col" colspan="4">Assessment Details</th>
                    </tr>
                </thead>
                <tr>
                    <td><b>User:</b></td>
                    <td colspan="3">{{ isset($HeaderDetails) && key_exists("user",$HeaderDetails) ? $HeaderDetails['user'] : ' ' }}</td>
                </tr>
                <tr>
                    <td><b>Assessor Name:</b></td>
                    <td>{{$assessorname}}</td>
                    <td><b>Assessment:</b></td>
                    <td>{{ isset($HeaderDetails) && key_exists("assessment",$HeaderDetails) ? $HeaderDetails['assessment'] : ' ' }}</td>
                </tr>
                <tr>
                    <td><b>Department:</b></td>
                    <td>{{ isset($HeaderDetails) && key_exists("department",$HeaderDetails) ? $HeaderDetails['department'] : ' ' }}</td>
                    <td><b>Reference No:</b></td>
                    <td>{{ isset($HeaderDetails) && key_exists("referenceno",$HeaderDetails) ? $HeaderDetails['referenceno'] : ' ' }}</td>
                </tr>
                <tr>
                    <td><b>Reference Source:</b></td>
                    <td>{{ isset($HeaderDetails) && key_exists("referencesource",$HeaderDetails) ? $HeaderDetails['referencesource'] : ' ' }}</td>
                    <td><b>Feedback Date:</b></td>
                    <td>{{ isset($HeaderDetails) && key_exists("feedbackdate",$HeaderDetails) ? $HeaderDetails['feedbackdate'] : ' ' }}</td>
                </tr>
            </table>
        </div>
        <br>
        <div class="row">
            <div id="orgChart">
                @if (!empty($htmlnode) )
                    {!! $htmlnode !!}
                @endif
                @if (!empty($htmlnodescore) )
                    {!! $htmlnodescore !!}
                @endif
            </div>
        </div>
    </body>
</html>

<script>
    document.getElementByName('Comment').innerHTML = 'this is a test';
</script>


@stop
