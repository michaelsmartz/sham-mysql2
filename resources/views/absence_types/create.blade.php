@extends(Request::ajax()?'blank':'portal-index')
@section('title', 'Add Leave Type')

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('absence_types.store') }}" accept-charset="UTF-8" id="create_absence_type_form" name="create_absence_type_form" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                        @include('absence_types.form', [
                            'mode' => 'create',
                            'absenceType' => null,
                        ])
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary pull-right" type="submit">Add</button>
                    <a href="{{ route('absence_types.index') }}" class="btn btn-default pull-right" title="Show all Leave Types">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('post-body')
<script src="{{URL::to('/')}}/js/absence_type.min.js"></script>
<script>
    $(function(){

        // Simple example, see optional options for more configuration.
        const pickr = Pickr.create({
            el: '.color-picker',
            theme: 'nano',
            default: '{{ collect($colours)->first() }}',
            swatches: {!! json_encode($colours) !!},

            components: {
                preview: false, opacity: false, hue: false,
                interaction: {
                    hex: false, rgba: false,
                    hsla: false, hsva: false,
                    cmyk: false, input: false,
                    clear: true, save: true
                }
            },
            strings: {
                save: 'Ok',
                clear: 'Clear'
            }
        });

        pickr.on('save', function(obj, instance) {
            if(typeof obj != 'undefined') {
                $('#colour_code').val(obj.toHEXA().toString());
            }
        });
    });
</script>
@endsection