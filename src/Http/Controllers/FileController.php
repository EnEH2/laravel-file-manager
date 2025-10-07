<?php

namespace EnEH2\FileManager\Http\Controllers;

use EnEH2\FileManager\Models\EnehFile;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => ['required', 'file', 'max:1024']
            ]);

            $file = $request->file('file');
            $disk = 'public';
            $path = $file->store('uploads/' . date('Y-m-d'), $disk);

            $file = EnehFile::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'disk' => $disk,
                'visibility' => true,
            ]);

            return response()->json($file);
        } catch (\Exception $ex) {
            \Log::info("EnEH2 File Manager Error: " . $ex->getMessage());
            return response()->json(false);
        }

        return response()->json(false);
    }
}
