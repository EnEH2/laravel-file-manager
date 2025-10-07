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
            $disk = config('filemanager.disk', 'public');
            $basePath = config('filemanager.base_path', 'uploads') . '/' . date('Y-m-d');
            $maxSize = config('filemanager.max_size', 50) * 1024; // convert MB → KB
            $allowed = config('filemanager.allowed_extensions', []);

            // --- Validate request ---
            $request->validate([
                'file' => [
                    'required',
                    'file',
                    'max:' . $maxSize, // Laravel max rule uses kilobytes
                    function ($attribute, $value, $fail) use ($allowed) {
                        if (!in_array(strtolower($value->getClientOriginalExtension()), $allowed)) {
                            $fail('This file type is not allowed.');
                        }
                    },
                ],
            ]);


            $file = $request->file('file');
            $path = $file->store($basePath, $disk);

            $fileRecord = EnehFile::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'disk' => $disk,
                'visibility' => true,
            ]);

            return response()->json([
                'success' => true,
                'file' => $fileRecord ?? [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'url' => config('filemanager.url_prefix', '/storage') . '/' . $path,
                ],
            ], 201);
        } catch (\Exception $ex) {
            \Log::info("EnEH2 File Manager Error: " . $ex->getMessage());
            return response()->json(false);
        }

        return response()->json(false);
    }
}
