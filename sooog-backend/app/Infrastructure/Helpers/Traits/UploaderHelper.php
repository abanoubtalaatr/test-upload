<?php
namespace App\Infrastructure\Helpers\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
//use Image;
trait UploaderHelper {

	/**
	* Generate file random name
	* @param $extension
	* @return String
	*/
	public function generateFileRandomName($extension){
		$time = time();
		$str_random = Str::random(8);
		return "{$time}_{$str_random}.{$extension}";
    }

    public function handleUploadImg($file, $folderName = 'uploads')
    {
        $extention = $file->extension();

        $fileName = $this->generateFileRandomName($extention);

        Storage::disk('public')->put($folderName .'/'.$fileName,  File::get($file));

        // $fullPath = $this->getFileFullPath($fileName, $folderName);

        return $fileName;
    }

	/**
	* Get file full path
	* @param file_path
	* @return string
	*/
    public function getFileFullPath($fileName, $folderName = 'uploads')
    {
        return Storage::disk('public')->url($folderName .'/'.$fileName);
    }

    public function getFileRelativePath($fileName, $folderName = 'uploads')
    {
		$filePath = Storage::url($folderName .'/'.$fileName);

        return $filePath;
	}

	/**
	* Delete file
	* @param file_path
	* @return boolean
	*/
    public function deleteFile($fileName, $folderName = 'uploads')
    {
        $file = Storage::disk('public')->delete($folderName.'/'.$fileName);
        //$x = unlink(storage_path('app/public/'.$folderName.'/'.$fileName));
        //dd($x);
        return $file;
	}

	function uploadImage($image, $image_path, $width = null, $height = null)
    {
        $fileName = $this->generateFileRandomName($image->getClientOriginalExtension());
        $type = null;
        $videos = ['mpeg','ogg','mp4','webm','3gp','mov','flv','avi','wmv','ts'];
        $files = ['csv','txt','xlx','xls','pdf'];
        if(in_array($image->getClientOriginalExtension(), $videos)){
            $type = 'video';
        }else if(in_array($image->getClientOriginalExtension(), $files)){
            $type = 'pdf';
        }else{
            $type = 'image';
        }

        if($type == 'image'){
            $img = Image::make($image);
            //$img = Image::make($image->getRealPath());

            // RESIZE IMAGE
            if (isset($width) || isset($height))
                $img->resize($width, $height, function ($ratio) {
                    $ratio->aspectRatio();
                });
            if (Storage::disk('public')->missing($image_path)) {
                Storage::disk('public')->makeDirectory($image_path);
            }
            $source = storage_path('app/public/'.$image_path) .'/'.$fileName;
            $img->save($source);
            //$img->stream();

            //Storage::disk('public')->put($image_path .'/'.$fileName, $img);
        }else{
            Storage::disk('public')->put($image_path .'/'.$fileName, file_get_contents($image));
        }

        return [
            'name' => $fileName,
            'file'  =>  $this->getFileFullPath($fileName, $image_path),
            'type' =>  $type,
            'folder' => $image_path
        ];
    }
}
?>
