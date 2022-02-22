<?php 

namespace Aldif\LaravelStorage;

use Illuminate\Support\Facades\Http;
use File;
use Image;
use Illuminate\Support\Facades\Storage;


class FileServices 
{

	

	public static function fileImage($slug, $ext, $prefix, $width=50, $height=300)
	{   
        
        $ext_allowed = array("png", "jpg", "jpeg");
        
        
        return FileServices::ReadFileImage($slug, $ext, $prefix, $ext_allowed, 'image/jpg', $width, $height);
    }

    public static function filePDF($slug, $ext, $prefix)
	{
        $ext_allowed = array("pdf");
        
        // dd('a');
        return $this->ReadFile($slug, $ext, $prefix, $ext_allowed, 'application/pdf');
    }


    public static function OtherFile($slug, $ext, $prefix, $ext_allowed)
	{
        // $ext_allowed = array("pdf");
        
        // dd('a');
        return $this->DownloadFile($slug, $ext, $prefix, $ext_allowed);
    }

    public static function ReadFile($slug, $ext, $prefix, $ext_allowed, $contenttype){

        if(!\HelperFile::checkExtensions($ext_allowed, $ext)){
            abort(404);
        }
        
        try{
            // dd(Storage::get($prefix.'/'.$slug.'.'.$ext));
            if (Storage::disk('local')->exists($prefix.'/'.$slug.'.'.$ext)) {
                
                $image = Storage::get($prefix.'/'.$slug.'.'.$ext);
                // dd($image);
                return response()->make($image, 200, ['content-type' => $contenttype]);
            }else{
                abort(404);
            }
            

        }catch(Exception $e){
            abort(404);
        }

    }

public static function ReadFileImage($slug, $ext, $prefix, $ext_allowed, $contenttype, $width, $height){

        if(!\HelperFile::checkExtensions($ext_allowed, $ext)){
            abort(404);
        }
        
        try{
            // dd(Storage::get($prefix.'/'.$slug.'.'.$ext));
            if (Storage::disk('local')->exists($prefix.'/'.$slug.'.'.$ext)) {
                // dd(storage_path('app/'.$prefix.'/'.$slug.'.'.$ext));
                // $image = Storage::get($prefix.'/'.$slug.'.'.$ext);
                $image = Image::make(storage_path('app/'.$prefix.'/'.$slug.'.'.$ext))->resize($width, $height);
                // dd($image);
                return $image->response('jpg');
                // return response()->make($image, 200, ['content-type' => $contenttype]);
            }else{
                abort(404);
            }
            

        }catch(Exception $e){
            abort(404);
        }

    }


    public static function DownloadFile($slug, $ext, $prefix, $ext_allowed, $contenttype='NULL'){

        if(!\HelperFile::checkExtensions($ext_allowed, $ext)){
            abort(404);
        }
         
        try{
            // dd(Storage::get($prefix.'/'.$slug.'.'.$ext));
            if (Storage::disk('local')->exists($prefix.'/'.$slug.'.'.$ext)) {
                $path=storage_path('app/'.$prefix.'/'.$slug.'.'.$ext);
                // $image = Storage::get($prefix.'/'.$slug.'.'.$ext);
                // dd($image);
                return response()->download($path);
                // return response()->make($image, 200, ['content-type' => $contenttype]);
            }else{
                abort(404);
            }
            

        }catch(Exception $e){
            abort(404);
        }

    }
}