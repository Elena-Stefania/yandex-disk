<?php

namespace App\Http\Controllers\Disk;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetFolderRequest;
use App\Services\YandexDisk\YandexDiskService;
use Illuminate\Http\Request;

class GetFolderController extends Controller
{
    public function __construct(private YandexDiskService $service)
    {
    }

    public function __invoke(GetFolderRequest $request)
    {
        $folders = $this->service->getResource($request->input('folder') ?? 'Библиотека');
        $navigation = $this->service->getResource('Библиотека');

        return view('pages.disk.index', compact('folders', 'navigation'));
    }
}
