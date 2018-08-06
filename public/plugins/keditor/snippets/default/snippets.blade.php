@php

$dir = '../../../../storage/e-learning-images';

// Run the recursive function
$response = scan($dir);
//var_dump($response); die;

// This function scans the files folder recursively, and builds a large array
function scan($dir){

	$files = array();
	// Is there actually such a folder/file?
	if(file_exists($dir)){
		foreach(scandir($dir) as $f) {
			if(!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			}

			if(is_dir($dir . '/' . $f)) {
				// The path is a folder
                /*
				$files[] = array(
					"name" => $f,
                    "type" => 'folder',
                    "path" => $dir . '/' . $f,
                    "items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
                    );
                */
            } else {
                // It is a file
                $files[] = array(
                    "name" => $f,
                    "type" => 'file',
                    "path" => $dir . '/' . $f,
                    "size" => filesize($dir . '/' . $f) // Gets the size of this file
                );
            }
        }

    }

    return $files;
}

@endphp

<!-------------------------------------------------------------------------------------------------->
<!-- Containers -->
<!-------------------------------------------------------------------------------------------------->

<div data-type="container" data-preview="../../../keditor/snippets/default/preview/row_12.png" data-keditor-title="1 column (100%)" data-categories="1 column">
    <div class="row">
        <div class="col-sm-12" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="../../../keditor/snippets/default/preview/row_6_6.png" data-keditor-title="2 columns (50% - 50%)" data-categories="2 columns">
    <div class="row">
        <div class="col-sm-6" data-type="container-content">
        </div>
        <div class="col-sm-6" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="../../../keditor/snippets/default/preview/row_4_8.png" data-keditor-title="2 columns (33% - 67%)" data-categories="2 columns">
    <div class="row">
        <div class="col-sm-4" data-type="container-content">
        </div>
        <div class="col-sm-8" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="../../../keditor/snippets/default/preview/row_8_4.png" data-keditor-title="2 columns (67% - 33%)" data-categories="2 columns">
    <div class="row">
        <div class="col-sm-8" data-type="container-content">
        </div>
        <div class="col-sm-4" data-type="container-content">
        </div>
    </div>
</div>

<div data-type="container" data-preview="../../../keditor/snippets/default/preview/row_4_4_4.png" data-keditor-title="3 columns (33% - 33% - 33%)" data-categories="3 columns">
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
<div data-type="component-text" data-preview="../../../keditor/snippets/default/preview/text.png" data-keditor-title="Text block" data-categories="Text">
    <p>This is an example text block. Please type your content here.</p>
</div>

<div data-type="component-photo" data-preview="../../../keditor/snippets/default/preview/photo.png" data-keditor-title="Photo" data-categories="Media;Photo">
    <div class="photo-panel">
        <img src="../../../keditor/snippets/default/img/somewhere_bangladesh.jpg" />
    </div>
</div>

<div data-type="component-audio" data-preview="../../../keditor/snippets/default/preview/audio.png" data-keditor-title="Audio" data-categories="Media">
    <div class="audio-wrapper">
        <audio src="../../../keditor/snippets/default/preview/2558.mp3" controls style="width: 100%"></audio>
    </div>
</div>

<div data-type="component-video" data-preview="../../../keditor/snippets/default/preview/video.png" data-keditor-title="Video" data-categories="Media">
    <div class="video-wrapper">
        <video width="320" height="180" controls style="background: #222;">
            <source src="../../../keditor/snippets/default/preview/mov_bbb.mp4" type="video/mp4" />
            <source src="../../../keditor/snippets/default/preview/mov_bbb.ogg" type="video/ogg" />
        </video>
    </div>
</div>


<div data-type="component-text" data-preview="../../../keditor/snippets/default/preview/thumbnail_panel.png" data-keditor-title="Thumbnail Panel" data-categories="Text;Photo;Bootstrap component">
    <div class="thumbnail">
        <div class="photo-panel">
            <img src="../../../keditor/snippets/default/img/somewhere_bangladesh.jpg" width="100%" height="" />
        </div>
        <div class="caption">
            <h3>Thumbnail label</h3>
            <p>This is an example text block. Please type your content here.</p>
            <p>
                <a href="#" class="btn btn-primary" role="button">Button</a>
                <a href="#" class="btn btn-default" role="button">Button</a>
            </p>
        </div>
    </div>
</div>


<div data-type="component-photo" data-preview="../../../keditor/snippets/default/preview/snippet_06.png" data-keditor-title="Featured Article" data-categories="Text;Heading;Photo">
    <div class="row">
        <div class="col-md-6 text-center">
            <div class="photo-panel">
                <img class="img-circle img-responsive" style="display: inline-block;" src="../../../keditor/snippets/default/img/sydney_australia_squared.jpg" />
            </div>
        </div>
        <div class="col-md-6">
            <h3>Example Title</h3>
            <p>This is an example text block. Please type your content here.</p>
        </div>
    </div>
</div>

<div data-type="component-text" data-preview="../../../keditor/snippets/default/preview/snippet_07.png" data-keditor-title="Articles List" data-categories="Text;Heading;Photo">
    <div class="row">
        <div class="col-md-4 text-center">
            <img class="img-circle img-responsive" style="display: inline-block;" src="../../../keditor/snippets/default/img/somewhere_bangladesh_squared.jpg" />
            <h3>Lorem ipsum</h3>
            <p>This is an example text block. Please type your content here</p>
        </div>
        <div class="col-md-4 text-center">
            <img class="img-circle img-responsive" style="display: inline-block;" src="../../../keditor/snippets/default/img/wellington_newzealand_squared.jpg" />
            <h3>Lorem ipsum</h3>
            <p>This is an example text block. Please type your content here</p>
        </div>
        <div class="col-md-4 text-center">
            <img class="img-circle img-responsive" style="display: inline-block;" src="../../../keditor/snippets/default/img/yenbai_vietnam_squared.jpg" />
            <h3>Lorem ipsum</h3>
            <p>This is an example text block. Please type your content here</p>
        </div>
    </div>
</div>

@foreach($response as $r)
    <div data-type="component-photo" data-preview="" data-keditor-title="Photo" data-categories="Media;Photo">
        <div class="photo-panel">
            <img src='localhost:8000/e-learning-images/oreo_2.jpg' />
        </div>
    </div>
@endforeach