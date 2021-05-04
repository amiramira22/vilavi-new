<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Repositories\UploadRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class UploadController extends Controller {

    protected $uploadRepository;

    public function __construct(UploadRepository $uploadRepository) {
 parent::__construct();
        $this->uploadRepository = $uploadRepository;
    }

    public function index() {
        $title = 'ANDROID APP';
        $subTitle = 'LIST OF ANDROID APP';
        $files = $this->uploadRepository->getFiles();
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;
        $data['files'] = $files;

        return view('admin.upload', $data);
    }

    public static function download($path) {
//        return response()->file($path, [
//                    'Content-Type' => 'application/vnd.android.package-archive',
//                    'Content-Disposition' => 'attachment; filename="android.apk"',
//        ]);
        return response()->download($path,'test',['Content-Type'=>'application/vnd.android.package-archive']);
    }

    public function create() {
        $title = 'ANDROID APP';
        $subTitle = 'ADD ANDROID APP';
        return view('admin.file.create', compact('title', 'subTitle'));
    }

    public function edit($id) {
        $title = 'ANDROID APP';
        $subTitle = 'EDIT ANDROID APP';
        $file = $this->uploadRepository->getFileById($id);
        return view('admin.file.edit', compact('title', 'subTitle', 'file'));
    }

    public function postFile(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'version' => 'required',
            'file' => 'required',
        ]);

        $save['name'] = $request->input('name');
        $save['version'] = $request->input('version');
        //$save['file'] = $request->input('file');
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('apk'), $filename);
            $save['file'] = $filename;
        }
        $id_file_inserted = $this->uploadRepository->addFile($save);
        request()->session()->flash('message', 'File has been saved successfully.');
        return redirect()->route('admin.upload.index');
    }

    function deleteFile($id) {
        $this->uploadRepository->deleteFile($id);
        request()->session()->flash('message', 'File has been deleted.');
        return redirect()->route('admin.upload.index');
    }

}
