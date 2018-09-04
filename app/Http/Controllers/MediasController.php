<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Plank\Mediable\Media;
use MediaUploadException;
use MediaUploader;
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
     * To display and upload files
     * @param Request $request
     * @param $Id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attach(Request $request, $Id)
    {
        $routeName = $request->route()->getName();
        $model = 'App\\'.ucfirst(explode(".", $routeName)[0]);

        //Todo to make dynamic
//        $disk = 'uploads';
//        $tag = 'LawDocuments';

        if ($request->isMethod('post')) {
//            try{
//                MediaUploader::fromSource($request->file('file'))
//                    ->toDestination($disk, $tag)
//                    ->upload();
//            }catch(MediaUploadException $e){
//                throw $this->transformMediaUploadException($e);
//            }
        }else{
            //Todo make dynamic for different media tables
            $list = $model::find($Id);
            $medias = $list->media()->get();

            $directory = ltrim(preg_replace('/([A-Z]+)/', " $1", $medias[0]->directory),' ');

            return view($this->baseViewPath .'.medias', compact('medias','directory','routeName','Id'));
        }
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
}
