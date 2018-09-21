@extends('portal-index')
@section('title','Organisation Charts')
@section('subtitle', 'View, edit and download your organizational chart')
@section('content')
    <p></p>
    {!! Form::open(array('name' => 'DynamicOrgCharForm', 'id' => 'DynamicOrgCharForm','url' => 'organisationcharts','method'=>'GET','class'=>'form-inline', 'files'=>true)) !!}

    <div class="form-group col-md-4">
        <label class="" for="exampleInputEmail2">Line Manager: </label>
        {{ Form::groupSelect('ManagerEmployeeId', $managers, 'employees', 'description', 'full_name', 'id', null, ['class'=>'form-control', 'autocomplete'=>'off',  'placeholder'=>'Select Line Manager']) }}

    </div>
            {!! Form::submit('Generate Chart',['class'=>'btn btn-primary']) !!}
        <a class="btn btn-primary" id="imgId" style="display:none">Download</a>
    {!! Form::close() !!}

    <hr>
    <div class="row">
        <div class="col-md-12">
            <div id="chart-container">
                <header id="chart-header" style="display:none;margin-bottom:25px;color:black;font-size: 18px;"><strong>Organisation&nbsp;chart</strong></header>
                <div id="chart-body"></div>
                <footer id="chart-footer" style="display:none;margin-top:20px;color:#777777;font-size: 14px;text-align: center;"><strong>Copyright &copy; {{ date('Y') }} Kalija Global - Smartz Human Asset Management. All rights reserved.</strong></footer>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <canvas id="canvas" width="1400" height="200" hidden></canvas>
        </div>
    </div>
@endsection

@section('post-body')
    <link href="{{URL::to('/')}}/plugins/treant/treant.css" media="all" rel="stylesheet" type="text/css" />
    <style>
        #chart-container {
            background-color: #fff;
            display: inline-block;
            position: relative;
        }

        #chart-container > svg {
            color: #333 !important;
            stroke: #333 !important;
        }

        .Treant > p { font-family: inherit; font-weight: bold; font-size: 12px; }
        .node-name { font-weight: bold;}

        .nodeExample1 {
            padding: 10px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            background-color: #262626;
            border: 1px solid #000;
            width: 180px;
            font-size: 12px;
            color: #ffffff;
        }
    </style>
    <!-- version 3.5.x -->
    <script src="{{URL::to('/')}}/js/d3/d3.v3-3.5.17.min.js"></script>
    <script src="{{URL::to('/')}}/js/underscore-1.9.1min.js"></script>

    <script src="{{URL::to('/')}}/js/dom-to-image.min.js"></script>
    <script src="{{URL::to('/')}}/js/raphael.min.js"></script>
    <script src="{{URL::to('/')}}/plugins/treant/treant.js"></script>

    <script>
        $(function() {

            var laravelJsonData = {!! $data !!};
            var detectedRoots = {!! $detectedRoots !!};

            function dataToTree(data) {
                // create a name: node map
                var dataMap = data.reduce(function(map, node) {
                    node.text.name = node.name;
                    map[node.name] = node;
                    return map;
                }, {});

                // create the tree array
                var treeData = [];
                data.forEach(function(node) {
                    // add to parent
                    var parent = dataMap[node.parent];
                    if (parent) {
                        // create child array if it doesn't exist
                        (parent.children || (parent.children = []))
                        // add node to child array
                                .push(node);
                    } else {
                        // parent is null or missing
                        treeData.push(node);
                    }
                });

                return treeData;
            }

            var transformedData = dataToTree(laravelJsonData);

            var chart_config = {
                chart: {
                    container: "#chart-body",
                    hideRootNode: false,
                    rootOrientation:  'NORTH',
                    connectors: {
                        type: 'step'
                    },
                    node: {
                        HTMLclass: 'nodeExample1'
                    }
                },
                nodeStructure: {}
            };

            if (detectedRoots == 1) {
                chart_config.nodeStructure = transformedData[0];
            } else if (detectedRoots > 1) {
                var root = {
                    text: {
                        name: 'Smartz-HAM',
                        title: ''
                    },
                    children: [],
                    stackChildren: true
                };

                for(var i=0; i< detectedRoots; i++) {
                    root.children.push(transformedData[i]);
                    //transformedData[i].parent = root;
                }

                chart_config.nodeStructure = root;
                chart_config.hideRootNode = true;
                chart_config.rootOrientation =  'NORTH';
            }

            new Treant( chart_config, function() {
                $('#imgId').show();
                makeLinkForDownload();
            });

            var dbSource = null;

            $('#btnViewOrgChart').click(function() {

                if ($('#LineManagerId').val() == '') {
                    return;
                }

                $('#btnPdfDownloader').hide();
                bufferProgress.start();
                var request = $.ajax({
                    url: window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/organisationcharts-auto/get-data',
                    type: "POST", global: false,
                    data: {
                        'Id': $('#LineManagerId').val(),
                        _token: '{!! csrf_token() !!}'
                    }
                });

                request.done(function (msg) {
                    dbSource = $.parseJSON(msg);

                    var chart_config = {
                        chart: {
                            container: "#chart-body",
                            connectors: {
                                type: 'step'
                            },
                            node: {
                                HTMLclass: 'nodeExample1'
                            }
                        },
                        nodeStructure: {
                            text: {
                                name: "Mark Hill",
                                title: "Chief executive officer",
                                contact: "Tel: 01 213 123 134"
                            },
                            children: [
                                {
                                    text:{
                                        name: "Joe Linux",
                                        title: "Chief Technology Officer"
                                    },
                                    stackChildren: true,
                                    children: [
                                        {
                                            text:{
                                                name: "Ron Blomquist",
                                                title: "Chief Information Security Officer"
                                            }
                                        }
                                    ]
                                }
                            ]
                        }
                    };
                    chart_config.nodeStructure = dbSource;

                    new Treant( chart_config, function() {
                        $('#btnPdfDownloader').show();
                    });

                });
                request.complete(function() {
                    bufferProgress.end();
                })
            });

        });

        function makeLinkForDownload(){
            var node = document.getElementById('chart-body');
            var svg = document.getElementsByTagName('svg')[0];
            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext('2d');

            domtoimage.toPng(node).then(function (dataUrl) {
                var img = new Image();
                img.width = svg.getAttribute('width');
                img.height = svg.getAttribute('height');

                img.src = dataUrl;
                img.onload = function(){
                    canvas.setAttribute('width', img.width);
                    canvas.setAttribute('height', img.height);
                    ctx.drawImage(img, 0, 0);

                    var canvasData = canvas.toDataURL('image/png');
                    canvasData = dataURItoBlob(canvasData);
                    var a = document.getElementById('imgId');
                    a.download = "Smartz-HAM Organisation chart " + Date.now() + ".png";
                    a.href = window.URL.createObjectURL(canvasData);
                };

            }).catch(function (error) {
                console.error('oops, something went wrong!', error);
            });
        }

        function dataURItoBlob(dataURI) {
            // convert base64 to raw binary data held in a string
            // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
            var byteString = atob(dataURI.split(',')[1]);

            // separate out the mime component
            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

            // write the bytes of the string to an ArrayBuffer
            var ab = new ArrayBuffer(byteString.length);

            // create a view into the buffer
            var ia = new Uint8Array(ab);

            // set the bytes of the buffer to the correct values
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }

            // write the ArrayBuffer to a blob, and you're done
            var blob = new Blob([ab], {type: mimeString});
            return blob;

        }

    </script>
@endsection