<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // 50 MB max, يقبل كل أنواع الملفات
            // لو عايز تحدد امتدادات معينة استخدم 'mimes:pdf,doc,docx,xls,xlsx,jpg,png,...'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        // حفظ الملف في storage/app/public/files
        $file->storeAs('public/files', $filename);

        // ممكن تخزن اسم الملف ومساره في قاعدة البيانات لو عايز

        return back()->with('success', 'File uploaded successfully!');
    }


    public function listFiles()
    {
        $files = Storage::files('public/files');

        // تحويل المسارات إلى روابط للوصول للملفات
        $fileUrls = [];
        foreach ($files as $file) {
            $fileUrls[] = asset(str_replace('public/', 'storage/', $file));
        }

        return view('files.index', compact('fileUrls'));
    }
}
