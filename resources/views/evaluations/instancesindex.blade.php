@extends('portal-index')
@section('title','Instances')

@section('content')
    <div class="flex-wrapper">
        <div id="filter-sidebar" class="card shadow-eff1 sidebar-nav" role="navigation" style="height:170px">
            <form action="" class="">
                <ul style="margin-left:0;padding-left:0" class="list-unstyled">
                    <li>
                        <input type="hidden" name="name" class="submitable-column-name" id="submitable-column-name" value="">
                        <div class="table-search-form">
                            <input type="search" name="search-term" value="{{old('search-term', null)}}" placeholder="Search" class="search-input" data-mirror="#submitable-column-name">
                            <div class="search-option">
                                <button type="submit" data-wenk="Do the Search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('evaluations.instances')}}" role="button" data-wenk="Reset all Criteria & reload the list">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="table-search-form" style="height:50px">
                            <button type="button" class="search-column-chooser-btn">
                                <p class="search-small">Search by</p>
                                <p class="search-large">Name</p>
                            </button>
                        </div>
                        <ul class="search-column-list">
                            <li data-filter-column="name">By Name<i class="fa fa-question-circle" data-wenk="Search on First Name/Surname"></i></li>
                            <li data-filter-column="assessment:name">By Assessment Name</li>
                            <li data-filter-column="department:description">By Department</li>
                            <li data-filter-column="reference_source">By Reference Source</li>
                            <li data-filter-column="reference_no">By Reference No</li>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <div id="table-container">
            @if(count($evaluations) > 0)
                <div id="toolbar" class="shadow-eff1">
                    <div class="btn-group">
                        <button id="sidebarCollapse" class="btn btn-default" data-toggle="offcanvas">
                            <i class="glyphicon glyphicon-align-left"></i>
                            <span>Filters</span>
                        </button>
                    </div>
                </div>
            @endif

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

