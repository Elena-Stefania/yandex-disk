<?php

namespace App\Http\Controllers\Disk;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetFolderRequest;
use App\Services\YandexDisk\YandexDiskService;

class GetFolderListController extends Controller
{
    public function __construct(private YandexDiskService $service)
    {
    }

    public function __invoke(GetFolderRequest $request)
    {
        $navigation = $this->service->getResource($request->input('folder') ?? 'Библиотека');
        return response()->json([
            'status' => 200,
            'html' => view('components.folder-list', compact('navigation'))->render()
        ]);
    }
}
