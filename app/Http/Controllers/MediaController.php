<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MediaUploadException;
use MediaUploader;
use Plank\Mediable\Helpers\File;
use Plank\Mediable\Media;

class MediaController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Media();
        $this->baseViewPath = 'media';
        $this->baseFlash = 'Media imports';
    }

    public function importMedias(){
        $disk = 'uploads';
        $disk_data = [];
        //truncate media table
        $this->contextObj::truncate();

        $directories = Storage::disk($disk)->directories();

        foreach($directories as $directory){
            $directory_path = env('UPLOADS_STORAGE_PATH').$directory;
            $disk_data[$directory_path] = glob($directory_path.'/'.'*', GLOB_BRACE);
        }

        foreach($disk_data as $directory=>$files) {
            foreach ($files as $file) {
                $directory = File::cleanDirname($file);
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $extension = pathinfo($file, PATHINFO_EXTENSION);

                dump($directory);
                dump($filename);
                dump($extension);exit;

                try{
                    MediaUploader::import($disk, $directory, $filename, $extension);
                }catch(MediaUploadException $e){
                    throw $this->transformMediaUploadException($e);
                }
            }
        }

        \Session::put('success', $this->baseFlash . 'Successfully!');
    }
}
