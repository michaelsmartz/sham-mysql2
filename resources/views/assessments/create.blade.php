@extends('portal-index')
@section('title', 'Add Assessment')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('assessments.store') }}" accept-charset="UTF-8" id="assessment_form" name="create_assessment_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('assessments.form', [
                            'assessment' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <input class="btn btn-primary pull-right" type="submit" value="Add">
                    <a href="{{ route('assessments.index') }}" class="btn btn-default pull-right" title="Show all Assessments">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('post-body')
    <script src="{{url('/')}}/plugins/multiselect/multiselect.min.js"></script>
    <script>
        $(function () {
            $('.multipleSelect').each(function(){
                $(this).multiselect({
                    submitAllLeft:false,
                    sort: false,
                    keepRenderingSort: false,
                    search: {
                        left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                        right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    },
                    fireSearch: function(value) {
                        return value.length > 3;
                    }
                });
            });

            $('#assessment_form').submit( function(e)
            {
                //e.preventDefault();
                var retvalue = true;
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                var data = $('#multiselect_to').val();
                data = {'AssessmentCateoryIds':$('#multiselect_to').val()};

                $.ajax({
                    url: '{{route('assessment.duplicates')}}',
                    type: 'POST',
                    data: data,
                    async:false,
                    // dataType: 'JSON',
                    success: function (data) {
                        var obj = data['questions'];
                        $('#alert_placeholder').empty();
                        if(data['duplicates'] == true)
                        {
                            retvalue = false;
                            $('#alert_placeholder').append('<br>');
                            $('#alert_placeholder').append('<div class="alert alert-danger"><strong>Error:</strong> The selected categories contain duplicate questions. Check list below for details.</div>')
                            $('#alert_placeholder').append('<table class="table"><thead><tr><th>Questions</th><th>Present in categories</th></tr></thead><tbody></tbody></table>');
                            $.each(obj, function(){
                                var categories = this['categories'];
                                var categoriestxt = ''
                                $.each(categories, function(){
                                    categoriestxt = categoriestxt + this + ', ';
                                });
                                if(categoriestxt.length > 2)
                                {
                                    categoriestxt = categoriestxt.substring(0,categoriestxt.length - 2);
                                }
                                $('#alert_placeholder tbody').append('<tr><td>'+ this['title'] + ' </td> <td>'+categoriestxt+ '</td></tr>')

                            });
                        }

                    },
                    error: function(data) {
                        retvalue == true
                    }
                });

                if(retvalue == true)
                {
                    $(this).find(":button").attr('disabled', 'true');
                    $(this).find(":submit").attr('disabled', 'true');
                    $(this).find(":submit").val('Please wait..');
                    //return true;

                }
                return retvalue;
            });

        });
    </script>
@endsection