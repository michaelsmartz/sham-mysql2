@extends('portal-index')
@section('title','Instances')

@section('content')
    <div class="flex-wrapper">
        <div id="table-container">

            <div class="table-responsive">
                @if(count($evaluations) == 0)
                    <h4 class="text-center">Its a bit empty here. You may click <a href="javascript:;" class="text-primary item-create">here</a> to add a new evaluation</h4>
                @else
                    <table id="table" data-toggle="table" data-detail-view="true">
                        <thead>
                        <tr>
                            <th data-sortable="true">Assessment</th>
                            <th data-sortable="true">Employee</th>
                            <th data-sortable="true">Department</th>
                            <th data-sortable="true">Feedback Date</th>
                            <th data-sortable="true">Evaluation Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 0;
                        ?>
                        @foreach($evaluations as $evaluation)
                            <?php
                            $counter =  $counter+1;
                            ?>
                            <tr class="clickable-row"  id="tr{{$evaluation->id}}" data-id="{{$evaluation->id}}"  data-url="{{URL::to('/evaluations')}}">
                                <td>{{ optional($evaluation->assessment)->name }}</td>
                                <td>{{ optional($evaluation->employee)->full_name }}</td>
                                <td>{{ optional($evaluation->department)->description }}</td>
                                <td>{{ $evaluation->feedback_date }}</td>
                                <td>{{ optional($evaluation->evaluationStatus)->description }}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <nav>
                        {!! $evaluations->render() !!}
                    </nav>
                @endif
            </div>
            @component('partials.index', ['routeName'=> 'evaluations.destroy'])
            @endcomponent
        </div>
    </div>
@endsection

@section('scripts')

    <script>

        $(document).ready(function(){
            var $table = $('#table');

            $table.find('tr td:first-child').each(function () {
                $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk', 'Show Assessors');
                $(this).children('a.detail-icon').children('i.glyphicon.glyphicon-plus.icon-plus').attr('data-wenk-pos', 'right');
                //alert('row');
            });
            //alert('Document Ready');
        });

    </script>
@endsection

