<?php

namespace App\Http\Controllers;

use App\Topic;
use App\AttachmentHelper;
use App\Traits\MediaFiles;
use App\VideoStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
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
        return view($this->baseViewPath .'.index', compact('topics'));
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

        $input = array_except($request->all(),array('_token'));

        $context = $this->contextObj->addData($input);

        $this->attach($request, $context->id);

        \Session::put('success', $this->baseFlash . 'created Successfully!');

        return redirect()->route($this->baseViewPath .'.index');
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

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data'));
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
        $this->validator($request);

        $input = array_except($request->all(),array('_token','_method'));

        $this->contextObj->updateData($id, $input);

        \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');       
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

        $this->validate($request, $validateFields);
    }

    public function getSnippets(Request $request) {

        $dir = Storage::disk('elearning')->getAdapter()->getPathPrefix();
        $files = self::getMediaFiles($dir);

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
            ob_end_clean();

            return $response;
        }
    }

    private static function getMediaFiles($dir) {
        // file extensions
        // value doesn't matter, search if key exists to see if the file extension is in the array
        $extensions = array(
            'Photo' => array('jpg' =>0, 'jpeg' =>1, 'png' =>2, 'gif' =>3, 'bmp' =>4),
            'Audio' => array('mp3' => 5, 'wav' => 6),
            'Video' => array('mp4' => 7)
        );

        // init result
        $result = array();

        // directory to scan
        $directory = new \DirectoryIterator($dir);

        // iterate
        foreach ($directory as $fileinfo) {

            // must be a file
            if ($fileinfo->isFile()) {
                // file extension
                $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
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

        return $result;
    }

    
}
