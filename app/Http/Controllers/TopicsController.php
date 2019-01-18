<?php

namespace App\Http\Controllers;

use App\Topic;
use App\AttachmentHelper;
use App\SystemSubModule;
use App\Traits\MediaFiles;
use App\VideoStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Plank\Mediable\Media;
use Exception;
use View;

class TopicsController extends CustomController
{
    use MediaFiles;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Topic();
        $this->baseViewPath = 'topics';
        $this->baseFlash = 'Topic details ';
    }

    /**
     * Display a listing of the topics.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $topics = $this->contextObj::filtered()->paginate(10);
        
        $allowedActions = getAllowedActions(SystemSubModule::CONST_TOPICS);

        // handle empty result bug
        if (Input::has('page') && $topics->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('topics','allowedActions'));
    }

    public function create()
    {
        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload documents, photos, audio and video files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf', 'jpg', 'png', 'mp3', 'mp4', 'wav']",
            "fileMaxSize" => "5", // in MB
            "totalMaxSize" => "15", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];
        return view($this->baseViewPath . '.create', compact('uploader'));
    }

    /**
     * Store a new topic in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validator($request);
        $input = array_except($request->all(),array('_token', '_method', 'id', 'redirectsTo'));
        
        return $this->saveTopic(0, $input);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $data = null;
        $id = Route::current()->parameter('topic');
        $data = $this->contextObj->findData($id);
        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload documents, photos, audio and video files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'jpg', 'png' ,'pdf', 'mp3', 'mp4', 'wav']",
            "fileMaxSize" => "5", // in MB
            "totalMaxSize" => "15", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];
        return view($this->baseViewPath . '.edit', compact('data', 'uploader'));
    }

    /**
     * Update the specified topic in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));
        $input = array_except($request->all(),array('_token', '_method','redirectsTo'));
        
        return $this->saveTopic($id, $input);
    }

    /**
     * Remove the specified topic from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->contextObj->destroyData($id);

        \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');
    }
        
    /**
     * Validate the given request with the defined rules.
     *
     * @param  Request $request
     *
     * @return boolean
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'header' => 'required|string|min:1|max:299',
            'description' => 'string|min:1|max:299|nullable',
            'data' => 'required|string|min:1',
        ];
        $messages = [
            'data.required' => 'The content is required'
        ];

        $this->validate($request, $validateFields, $messages);
    }

    public function show(Request $request) {
        // prevent Laravel from farting when no id is passed in topic create mode
        return $this->getSnippets($request);
    }

    public function getSnippets(Request $request) {

        $id = Route::current()->parameter('topic');
        $dir = Storage::disk('uploads')->getAdapter()->getPathPrefix();
        $filter = [];

        if($id > 0) {
            $obj = $this->contextObj->find($id);
            $relatedMedia = $obj->media()->whereIn('aggregate_type', [Media::TYPE_AUDIO,Media::TYPE_VIDEO, Media::TYPE_IMAGE])->get();
            
            
            if(sizeof($relatedMedia) > 0 ){
                foreach($relatedMedia as $file) {
                    $filter[] = $file->filename . '.' .$file->extension;
                }
            }
        }

        $files = self::getMediaFiles($dir.'Topic', $filter);

        $vw = View::make($this->baseViewPath .'.snippets', ['files' => $files]);
        return $vw->render();

    }

    public function embedMedia($file) {
        $dir = Storage::disk('elearning')->getAdapter()->getPathPrefix();

        $fileObj = AttachmentHelper::fromPath($dir.$file);

        $headers = array(
            'Content-Transfer-Encoding' => 'binary',
            'Content-Type' => $fileObj->mime,
            'Content-Disposition' => 'inline; filename="'.$file.'"'
        );

        if ($fileObj->extension=='mp4') {

            $stream = new VideoStream($fileObj->pathToFile);
            $stream->start();

        } else {
            $response = response()->file($fileObj->pathToFile, $headers);

            //here is the magic
            if (ob_get_length() > 0 ) {
                ob_end_clean();
            }

            return $response;
        }
    }

    private static function getMediaFiles($dir, $filter) {
        // file extensions
        // value doesn't matter, search if key exists to see if the file extension is in the array
        $extensions = array(
            'Photo' => array('jpg' =>0, 'jpeg' =>1, 'png' =>2, 'gif' =>3, 'bmp' =>4),
            'Audio' => array('mp3' => 5, 'wav' => 6, 'mpga' => 7),
            'Video' => array('mp4' => 8)
        );

        // init result
        $result = array();

        // directory to scan
        $directory = new \DirectoryIterator($dir);

        // iterate
        foreach ($directory as $fileinfo) {
            if($fileinfo->isFile()){
                // file extension
                $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
              
                // must be a file
                if (in_array($fileinfo->getFilename(), $filter)) {
                    $type = '';
                    // check if extension match
                    if (isset($extensions['Photo'][$extension])) {
                        $type = 'Photo';
                    }
                    if (isset($extensions['Audio'][$extension])) {
                        $type = 'Audio';
                    }
                    if (isset($extensions['Video'][$extension])) {
                        $type = 'Video';
                    }
                    // add to result
                    $result[] = array(
                        "name" => $fileinfo->getFilename(),
                        "type" => $type,
                        "ext" => $extension,
                        "path" => $fileinfo->getPathname()
                    );
                }
            }

        }

        return $result;
    }

    private function saveTopic($id, $input)
    {
        try {

            $response = ['status' => 'OK', 'snippets' => []]; 
            $responseCode = 200;

            $snippetsLength = $input['snippetsLength'];
            $hasAttachments = isset($input['attachment']) && sizeof($input['attachment'])>0;
            $temp = array_except($input, ['snippetsLength','attachment','model']);

            if ($id == 0) {
                $context = $this->contextObj->addData($temp);
            } else {
                $temp['id'] = $id;
                $res = $this->contextObj->updateData($id, $temp);
                $context = $this->contextObj->findData($id);
            }
            $response['id'] = $context->id;

            if($hasAttachments) {
                $request = app('request');
                $media = $this->attach($request, $context->id);

                $elementId = intval($snippetsLength);

                foreach ($media as $index => $file) {
                    $elementId += intval($index);
                    if($file->aggregate_type == 'photo') {
                        $response['snippets'][] = '<section class="keditor-snippet ui-draggable ui-draggable-handle" data-snippet="#keditor-snippet-' . $elementId .'" data-type="component-media" title="'. $file->filename .'" data-categories="Media">   <img class="keditor-snippet-preview " src="http://localhost:17000/plugins/keditor/snippets/default/preview/photo.png"></section>';
                    }
                    if($file->aggregate_type == 'audio') {
                        $response['snippets'][] = '<section class="keditor-snippet ui-draggable ui-draggable-handle" data-snippet="#keditor-snippet-' . $elementId .'" data-type="component-media" title="'. $file->filename .'" data-categories="Media">   <img class="keditor-snippet-preview " src="http://localhost:17000/plugins/keditor/snippets/default/preview/audio.png"></section>';
                    }
                    if($file->aggregate_type == 'video') {
                        $response['snippets'][] = '<section class="keditor-snippet ui-draggable ui-draggable-handle" data-snippet="#keditor-snippet-' . $elementId .'" data-type="component-media" title="'. $file->filename .'" data-categories="Media">   <img class="keditor-snippet-preview " src="http://localhost:17000/plugins/keditor/snippets/default/preview/video.png"></section>';
                    }
                }
            }

        } catch (Exception $exception) {
            $response['status'] = 'KO';
            $responseCode = 500;
        }

        return response()->json(['response' => $response], $responseCode);

    }

    protected function createRequest($method, $content, $uri = '/test',$server = ['CONTENT_TYPE' => 'application/json'],
        $parameters = [], $cookies = [], $files = []) {
        $request = new Request;
        return $request->createFromBase(\Symfony\Component\HttpFoundation\Request::create($uri, $method, $parameters, $cookies, $files, $server, $content));
    }

    
}
