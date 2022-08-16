<?php
namespace App\Http\Triats;
use Illuminate\Support\Facades\Storage;
trait AttachFilesTriat
{
    public function uploadFile($request,$name,$foldername)
    {
       //name refrer to photoname
       //foldername refer to folder will be create for save php
       //هتعمل مجلد اسمه attachments and create folder will pass foldername and se photo
        $file_name = $request->file($name)->getClientOriginalName();
        $request->file($name)->storeAs('attachments/'.$foldername,$file_name,'upload_attachments');
    }

    public function deleteFile($name,$foldername)
    {
        $exists = Storage::disk('upload_attachments')->exists('attachments/'.$foldername.'/'.$name);

        if($exists)
        {
            Storage::disk('upload_attachments')->delete('attachments/'.$foldername.'/'.$name);
        }
    }
}