<!-------------------------------------------------------------------------------------------------->
<!-- Containers -->
<!-------------------------------------------------------------------------------------------------->
<div data-type="container" data-preview="{{ asset('plugins/keditor/snippets/default/preview/row_12.png') }}" data-keditor-title="1 column (100%)" data-categories="1 column">
    <div class="row">
        <div class="col-sm-12" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="{{ asset('plugins/keditor/snippets/default/preview/row_6_6.png') }}" data-keditor-title="2 columns (50% - 50%)" data-categories="2 columns">
    <div class="row">
        <div class="col-sm-6" data-type="container-content">
        </div>
        <div class="col-sm-6" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="{{ asset('plugins/keditor/snippets/default/preview/row_4_8.png') }}" data-keditor-title="2 columns (33% - 67%)" data-categories="2 columns">
    <div class="row">
        <div class="col-sm-4" data-type="container-content">
        </div>
        <div class="col-sm-8" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="{{ asset('plugins/keditor/snippets/default/preview/row_8_4.png') }}" data-keditor-title="2 columns (67% - 33%)" data-categories="2 columns">
    <div class="row">
        <div class="col-sm-8" data-type="container-content">
        </div>
        <div class="col-sm-4" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="{{ asset('plugins/keditor/snippets/default/preview/row_4_4_4.png') }}" data-keditor-title="3 columns (33% - 33% - 33%)" data-categories="3 columns">
    <div class="row">
        <div class="col-sm-4" data-type="container-content">
        </div>
        <div class="col-sm-4" data-type="container-content">
        </div>
        <div class="col-sm-4" data-type="container-content">
        </div>
    </div>
</div>

<!-------------------------------------------------------------------------------------------------->
<!-- Components -->
<!-------------------------------------------------------------------------------------------------->
<div data-type="component-text" data-preview="{{ asset('plugins/keditor/snippets/default/preview/text.png') }}" data-keditor-title="Text block" data-categories="Text">
    <p>This is an example text block. Please type your content here.</p>
</div>

@foreach($files as $r)
    @if($r['type'] == 'Photo')
        <div class="" data-type="component-photo" data-user=" user" data-preview="{{ url('topics/embed',$r['name']) }}" data-keditor-title="Photo" data-categories="Media;Photo">
            <div class="photo-panel">
                <img class="img-responsive fragment" src="{{ url('topics/embed',$r['name']) }}"  />
            </div>
        </div>
    @endif
    @if($r['type'] == 'Audio')
        <div class="keditor-component-content" data-type="component-media" data-preview="{{ asset('plugins/keditor/snippets/default/preview/audio.png') }}" data-keditor-title="{{$r['name']}}" data-categories="Media">
            <div class="audio-wrapper keditor-component-content">
                <div data-type="component-media" class="keditor-component-content">
                    <audio src='{{ url('topics/embed',$r['name']) }}' controls></audio>
                </div>
            </div>
        </div>
    @endif
    @if($r['type'] == 'Video')
        <div class="keditor-component-content" data-type="component-media" data-preview="{{ asset('plugins/keditor/snippets/default/preview/video.png') }}" data-keditor-title="{{$r['name']}}" data-categories="Media">
            <div class="video-wrapper keditor-component-content">
                <div data-type="component-media" class="keditor-component-content">
                    <video class="fragment" width="320" height="180" controls style="background: #222;">
                        <source src='{{ url('topics/embed',$r['name']) }}' type='video/{{ $r['ext'] }}' />
                    </video>
                </div>
            </div>
        </div>
    @endif
@endforeach

{{--
<div data-type="component-text" data-preview="{{ asset('keditor/snippets/default/preview/thumbnail_panel.png') }}" data-keditor-title="Thumbnail Panel" data-categories="Text;Photo;Bootstrap component">
    <div class="thumbnail">
        <div class="photo-panel">
            <img src="{{ asset('keditor/snippets/default/img/somewhere_bangladesh.jpg') }}" width="100%" height="" />
        </div>
        <div class="caption">
            <h3>Thumbnail label</h3>
            <p>This is an example text block. Please type your content here.</p>
        </div>
    </div>
</div>

<div data-type="component-photo" data-preview="{{ asset('keditor/snippets/default/preview/snippet_06.png') }}" data-keditor-title="Featured Article" data-categories="Text;Heading;Photo">
    <div class="row">
        <div class="col-md-6 text-center">
            <div class="photo-panel">
                <img class="img-circle img-responsive" style="display: inline-block;" src="{{ asset('keditor/snippets/default/img/sydney_australia_squared.jpg') }}" />
            </div>
        </div>
        <div class="col-md-6">
            <h3>Lorem ipsum</h3>
            <p>This is an example text block. Please type your content here</p>
        </div>
    </div>
</div>

<div data-type="component-text" data-preview="{{ asset('keditor/snippets/default/preview/snippet_07.png') }}" data-keditor-title="Articles List" data-categories="Text;Heading;Photo">
    <div class="row">
        <div class="col-md-4 text-center">
            <img class="img-circle img-responsive" style="display: inline-block;" src="{{ asset('keditor/snippets/default/img/somewhere_bangladesh_squared.jpg') }}" />
            <h3>Lorem ipsum</h3>
            <p>This is an example text block. Please type your content here.</p>
        </div>
        <div class="col-md-4 text-center">
            <img class="img-circle img-responsive" style="display: inline-block;" src="{{ asset('keditor/snippets/default/img/wellington_newzealand_squared.jpg') }}" />
            <h3>Lorem ipsum</h3>
            <p>This is an example text block. Please type your content here.</p>
        </div>
        <div class="col-md-4 text-center">
            <img class="img-circle img-responsive" style="display: inline-block;" src="{{ asset('keditor/snippets/default/img/yenbai_vietnam_squared.jpg') }}" />
            <h3>Lorem ipsum</h3>
            <p>This is an example text block. Please type your content here.</p>
        </div>
    </div>
</div>

<div data-type="component-text" data-preview="{{ asset('keditor/snippets/default/preview/Horizontal-Line.png') }}" data-keditor-title="Divider" data-categories="Text">
    <div class="text-center">
        <hr>
    </div>
</div>


<div data-type="component-photo" data-preview="{{ asset('keditor/snippets/default/preview/photo.png') }}" data-keditor-title="Photo" data-categories="Media;Photo">
    <div class="photo-panel">
        <img src="{{ asset('keditor/snippets/default/img/somewhere_bangladesh.jpg') }}" />
    </div>
</div>

<div data-type="component-audio" data-preview="{{ asset('keditor/snippets/default/preview/audio.png') }}" data-keditor-title="Audio" data-categories="Media">
    <div class="audio-wrapper">
        <audio src="{{ asset('keditor/snippets/default/preview/2558.mp3') }}" controls style="width: 100%"></audio>
    </div>
</div>

<div data-type="component-video" data-preview="{{ asset('keditor/snippets/default/preview/video.png') }}" data-keditor-title="Video" data-categories="Media">
    <div class="video-wrapper">
        <video width="320" height="180" controls style="background: #222;">
            <source src="{{ asset('keditor/snippets/default/preview/mov_bbb.mp4') }}" type="video/mp4" />
            <source src="{{ asset('keditor/snippets/default/preview/mov_bbb.ogg') }}" type="video/ogg" />
        </video>
    </div>
</div>
--}}