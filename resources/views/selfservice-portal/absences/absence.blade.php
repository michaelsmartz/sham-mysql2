<div class="col1 col-lg-8">
    <main class="main-container">
        <header class="portal-help-header">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h3>Absences & leaves</h3>
        </header>
        <div class="default-body">
            <section>
                <div class="row">
                    <div class="col-lg-12">
                        @if(count($leaves)>0)
                            <table class="table table-responsive">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">&nbsp;</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Taken</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Starts at</th>
                                        <th scope="col">Ends at</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Approved by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaves as $leave)
                                        <tr>
                                            <th scope="row">{{$leave->absence_description}}</th>
                                            <td>{{$leave->total}}</td>
                                            <td>{{$leave->taken}}</td>
                                            <td>{{$leave->remaining}}</td>
                                            <td>{{$leave->starts_at}}</td>
                                            <td>{{$leave->ends_at}}</td>
                                            <td>{{$leave->status}}</td>
                                            <td>{{$leave->validator}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-success">Currently, there are no leave types allocated to you</div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>