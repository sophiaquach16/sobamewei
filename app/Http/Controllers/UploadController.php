<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function showUpload()
    {
      return view ('pages.upload');
    }
    public function doUpload(request $request)
    {

      if ($request->file('image')!=null)
        $file = $request->file('image');
      //  $filename= time() . '.' . $file->getClientOriginalExtension

      //  dd($file);
        return 'true';
    }
}
