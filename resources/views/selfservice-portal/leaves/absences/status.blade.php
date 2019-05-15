<section>
    @foreach($eligibility as $eligible)
        <div class="col-md-2 chart-container">
            <div class="leave-label"><h4>{{$eligible->absence_description}}</h4></div>
            <canvas id="progress_leave_{{$eligible->id}}" width="400" height="400"></canvas>
            {{--                <div class="pie_progress" role="progressbar" data-goal="{{($eligible->remaining/$eligible->total)*100}}">--}}
            {{--                    <div class="pie_progress__number">{{number_format($eligible->remaining, 1)}}/{{number_format($eligible->total, 1)}}</div>--}}
            {{--                    <div class="pie_progress__label"><b>{{$eligible->absence_description}}</b></div>--}}
            {{--                </div>--}}
            <div class="row">
                <a id="request_leave_{{$eligible->id}}" href="#light-modal" data-wenk="{{$eligible->absence_description}} application form" data-description="{{$eligible->absence_description}}" data-type-id="{{$eligible->id}}" class="btn btn-primary btn-apply" onclick="addFormType(event,{{$eligible->id }},'{{ $eligible->absence_description }}')">
                    <i class="glyphicon glyphicon-plane"></i>  Apply
                </a>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function(event) {
                var id = JSON.parse("{!! json_encode($eligible->id) !!}");
                var ctx = document.getElementById('progress_leave_'+id);

                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [JSON.parse({!! $eligible->taken !!}),JSON.parse({!! $eligible->remaining !!})],
                            backgroundColor: [
                                'rgba(17,121,203,0.8)',
                                'rgba(18,199,206,0.14)'
                            ],
                            borderColor: [
                                '#f8f8f8',
                                '#f8f8f8',
                            ],
                            fill: '-2'
                    }],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: [
                            'Taken',
                            'Remaining'
                        ]

                    },
                    options: {
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 75,
                        animation: {
                            animateRotate: true
                        }
                    }
                });
            });

        </script>
    @endforeach
</section>




