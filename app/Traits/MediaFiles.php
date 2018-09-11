<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Plank\Mediable\Media;
use MediaUploadException;
use MediaUploader;
use Plank\Mediable\Mediable;
use Session;

trait MediaFiles
{
    /**
     * To diplay files
     * @param Request $request
     * @param $Id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attachment(Request $request, $Id)
    {
        $uModelName = $this->getModelName($request)['model'];
        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);
        $medias = $relatedMedias->media()->get();

        return view('partials.medias', compact('medias','uModelName','Id'));
    }

    /**
     * To upload file
     * @param Request $request
     * @param $Id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attach(Request $request, $Id)
    {
        $name = $this->getModelName($request);
        $uModelName = $name['model'];
        $modelClass = 'App\\'.$uModelName;

        $relatedMedias = $modelClass::find($Id);

        if ($request->isMethod('post') && !is_null($request->file('attachment'))) {
            try {
                //get current disk where the file will be uploaded
                $disk = 'uploads';

                $media = MediaUploader::fromSource($request->file('attachment'))
                    ->toDestination($disk, $uModelName)
                    // pass the callable
                    ->beforeSave(function (Media $model) use ($request){
                        $model->setAttribute('comment',$request->input('comment'));
                        $model->setAttribute('extrable_id', $request->input('Extrable_Id'));
                        $model->setAttribute('extrable_type',  $request->input('Extrable_Type'));
                    })
                    ->upload();
            } catch (MediaUploadException $e) {
                Session::put('error', $e->getMessage());
            }

            //to sync mediable table with media table on upload
            $relatedMedias->attachMedia($media, $uModelName);
            //$relatedMedias->syncMedia($media, $modelName);
        }
    }

    /**
     * remove media
     * @param $pivot_mediable_id
     * @param $mediaId
     * @return mixed
     */
    public function detach(Request $request, $pivot_mediable_id, $mediaId)
    {
        $name = $this->getModelName($request);
        $modelClass = 'App\\'.$name['model'];

        $relatedMedias = $modelClass::find($pivot_mediable_id);

        $media = Media::find($mediaId);
        $media->delete();
        $relatedMedias->detachMedia($media);

        Session::put('success', 'media removed Successfully!');

        return Redirect::back();
    }

    /**
     * to download files
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
        $uModelName = Str::singular(ucfirst(explode(".", $routeName)[0]));
        return [ 'route' => $routeName , 'model' => $uModelName];
    }
}