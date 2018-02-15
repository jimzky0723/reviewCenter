<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class FileCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
    }
    public function index()
    {
        return redirect('validate');
    }

    public function show($file)
    {
        if($file=='sample.csv')
        {
            $headers = array(
                'Content-Type: text/csv',
            );
            $path = 'public/'.$file;

            return response()->download($path, 'format.csv', $headers);

        }
        return response()->file('public/upload/'.$file);
    }

    public function destroy($id)
    {
        $file = Lesson::find($id)->file;
        $path = 'public/upload/'.$file;
        $delete = File::delete($path);


        Lesson::where('id',$id)
            ->update([
                'file' => ''
            ]);
        return redirect()->back()->with('status','filedeleted');
    }

    static function removeFile($file)
    {
        $path = 'public/upload/'.$file;
        File::delete($path);
    }
}
