<?php

namespace App\Http\Controllers\Disk;

use App\Http\Controllers\Controller;
use App\Services\YandexDisk\YandexDiskService;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public function __construct(private YandexDiskService $service)
    {
    }

    public function __invoke(Request $request)
    {
        $result = $this->service->uploadFile($request->file, $request->folder . '/' . $request->file->getClientOriginalName());
        if ($result)
            return response()->json([
                'status' => 400,
                'message' => $result
            ]);

        $data = $this->service->getResource($request->input('folder') . '/'. $request->file->getClientOriginalName());
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }
}
