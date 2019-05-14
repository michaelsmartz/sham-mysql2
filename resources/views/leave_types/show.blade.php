@extends('portal-index')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Leave Type' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('leave_types.leave_type.destroy', $leaveType->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('leave_types.leave_type.index') }}" class="btn btn-primary" title="Show All Leave Type">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('leave_types.leave_type.create') }}" class="btn btn-success" title="Create New Leave Type">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('leave_types.leave_type.edit', $leaveType->id ) }}" class="btn btn-primary" title="Edit Leave Type">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Leave Type" onclick="return confirm(&quot;Click Ok to delete Leave Type.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Description</dt>
            <dd>{{ $leaveType->description }}</dd>
            <dt>Default Balance</dt>
            <dd>{{ $leaveType->default_balance }}</dd>

        </dl>

    </div>
</div>

@endsection