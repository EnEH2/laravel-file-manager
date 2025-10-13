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
            $disk = config('eneh-filemanager.disk', 'public');
            $basePath = config('eneh-filemanager.base_path', 'uploads') . '/' . date('Y-m-d');
            $maxSize = config('eneh-filemanager.max_size', 50) * 1024;
            $allowed = config('eneh-filemanager.allowed_extensions', []);


            $request->validate([
                'file' => [
                    'required',
                    'file',
                    'max:' . $maxSize,
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
                    'url' => config('eneh-filemanager.url_prefix', '/storage') . '/' . $path,
                ],
            ], 201);
        } catch (\Exception $ex) {
            \Log::info("EnEH2 File Manager Error (Upload): " . $ex->getMessage());
            return response()->json(false);
        }

        return response()->json(false);
    }


    public function show(Request $request)
    {
        try {
            $uuid = $request->uuid;

            $enehFile = EnehFile::findByUuid($uuid);

            return response()->json([
                'success' => true,
                'file' => $enehFile
            ], 200);
        } catch (\Exception $ex) {
            \Log::info("EnEH2 File Manager Error (Show): " . $ex->getMessage());
            return response()->json(false);
        }

        return response()->json(false);
    }
}
