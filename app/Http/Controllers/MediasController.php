<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Plank\Mediable\Media;
use MediaUploadException;
use MediaUploader;
use Plank\Mediable\Mediable;
use Session;

class MediasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseViewPath = 'partials';
        $this->baseFlash = 'media ';
    }

    /**
     * To diplay files
     * @param Request $request
     * @param $Id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $Id)
    {
        $uModelName = self::getModelName($request)['model'];
        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);
        $medias = $relatedMedias->media()->get();

        return view($this->baseViewPath .'.medias', compact('medias','uModelName','Id'));
    }

    /**
     * To upload file
     * @param Request $request
     * @param $Id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attach(Request $request, $Id)
    {
        $name = self::getModelName($request);
        $uModelName = $name['model'];
        $routeName = $name['route'];
        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);
        $heading = $relatedMedias->main_heading;

        if ($request->isMethod('post') && !is_null($request->file('Attachment'))) {
            try {
                //get current disk where the file will be uploaded
                $disk = 'uploads';

                $media = MediaUploader::fromSource($request->file('Attachment'))
                    ->toDestination($disk, $uModelName)
                    ->upload();
            } catch (MediaUploadException $e) {
                throw $this->transformMediaUploadException($e);
            }

            //to sync mediable table with media table on upload
            $relatedMedias->attachMedia($media, $uModelName);
            //$relatedMedias->syncMedia($media, $modelName);

            Session::put('success', $this->baseFlash . 'uploaded Successfully!');
            return Redirect::back();
        }

        return view($this->baseViewPath .'.media-upload',compact('heading', 'routeName','uModelName','Id'));
    }

    /**
     * remove media
     * @param $pivot_mediable_id
     * @param $mediaId
     * @return mixed
     */
    public function detach(Request $request, $pivot_mediable_id, $mediaId)
    {
        $name = self::getModelName($request);
        $modelClass = 'App\\'.$name['model'];

        $relatedMedias = $modelClass::find($pivot_mediable_id);

        $media = Media::find($mediaId);
        $media->delete();
        $relatedMedias->detachMedia($media);

        Session::put('success', $this->baseFlash . 'removed Successfully!');

        return Redirect::back();
    }

    /**
     * download media
     * @param $pivot_mediable_id
     * @param $mediaId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($pivot_mediable_id, $mediaId)
    {
        $media = Media::find($mediaId);
        return response()->download($media->getAbsolutePath());
    }

    /**
     * get model from routeName
     * @param $request
     * @return array
     */
    private function getModelName($request){
        $routeName = $request->route()->getName();
        $uModelName = ucfirst(explode(".", $routeName)[0]);
        return [ 'route' => $routeName , 'model' => $uModelName];
    }
}
