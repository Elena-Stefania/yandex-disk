<?php

namespace App\Http\Controllers\Disk;

use App\Http\Controllers\Controller;
use App\Services\YandexDisk\YandexDiskService;
use Illuminate\Http\Request;

class GetFileController extends Controller
{
    public function __construct(private YandexDiskService $service)
    {
    }

    public function __invoke(Request $request)
    {
        $data = $this->service->getFile($request->input('path'));
        return response()->json([
            'status' => 200,
            'data' => $data->href
        ]);
    }
}
