<section>
    @foreach($eligibility as $eligible)
        <div class="col-md-3 chart-container">
            <div class="leave-label"><h4>{{$eligible->absence_description}}</h4></div>
            <canvas id="progress_leave_{{$eligible->id}}" width="150" height="150"></canvas>
            <div class="row">
                <a id="request_leave_{{$eligible->id}}" href="#light-modal" data-wenk="{{$eligible->absence_description}} application form" data-description="{{$eligible->absence_description}}" data-type-id="{{$eligible->id}}" class="btn btn-primary btn-apply" onclick="addFormType(event,{{$eligible->id }},'{{ $eligible->absence_description }}','leaves')">
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
                            data: [JSON.parse({!! $eligible->taken !!}),JSON.parse({!! $eligible->remaining !!}),JSON.parse({!! $eligible->pending !!})],
                            backgroundColor: [
                                '#2ab27b',
                                'rgba(18,199,206,0.14)',
                                '#cbb956'
                            ],
                            borderColor: [
                                '#f8f8f8',
                                '#f8f8f8',
                                '#f8f8f8',
                            ],
                            fill: '-2'
                    }],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: [
                            'Taken',
                            'Remaining',
                            'Pending'
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




