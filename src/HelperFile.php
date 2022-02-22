<?php 

namespace Aldif\LaravelStorage;

use Illuminate\Support\Facades\Http;
use File;
use Image;
use Illuminate\Support\Facades\Storage;


class HelperFile 
{

    
    
    public static function getFile($file){
    
        $array=explode(".",$file);
    
        // dd(count($array));
        $ext=$array[(count($array)-1)];
        $slug = '';
        for($a=0; $a<(count($array)-1);$a++){
            if($a==0){
                $dot='';
            }else{
                $dot='.';
            }
            $slug = $slug.$dot. $array[$a];
        }
        // dd('a');
        return [
            'ext' => $ext,
            'slug' => $slug
        ];
    
    }
    
    public static function checkExtensions($array, $ext){
    
        if(!in_array($ext, $array)){
            return false;
        }else{
            return true;
        }
    
        // dd();
    
    }
    
    public static function StorageUpload($disk, $file, $prefix =  'FILE-', $array_ext=NULL,$ext = NULL)
    {	
        // dd($array_ext && !\HelperFile::checkExtensions($array_ext, $file->getClientOriginalExtension()));
        if($array_ext && !\HelperFile::checkExtensions($array_ext, $file->getClientOriginalExtension())){
            return [
                        'status' => false,
                        'keterangan' => 'Ext File yang di Upload Salah'
                    ];
        }
         
        try{
            $now = \Carbon\Carbon::now()->format('Y-m-d_H-i-s');
    
            if(!$ext){
                $ext=$file->getClientOriginalExtension();
            }
     
            // $imagename = $prefix . $now . rand(1, 1000000) . '.' . $ext;
            // dd($file);
            $storagePath=\Illuminate\Support\Facades\Storage::disk($disk)->put($prefix, $file);
            // dd($storagePath);
            return [
                'status' => true,
                'name' => basename($storagePath)
            ];
    
            // return $imagename;
    
        }catch(Exception $e){
            return [
                'status' => false,
                'keterangan' => 'Gagal Upload File'
            ];
        }
    
        
    
    }
}