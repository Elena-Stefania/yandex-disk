<?php

namespace App\Services\YandexDisk;

use Arhitector\Yandex\Disk;
use Illuminate\Support\Facades\Storage;

class YandexDiskService
{
    private string $url = 'https://cloud-api.yandex.net/v1/';
    private $client = null;
    private Disk $storage;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->url, 'headers' => ['Authorization' => 'OAuth ' . env('YANDEX_DISK_OAUTH_TOKEN')]]);
        $this->storage = new Disk(env('YANDEX_DISK_OAUTH_TOKEN'));
    }

    public function getResource(string $folder)
    {
        $response = $this->client->request('GET', 'disk/resources?path=' . $folder);
        $data = json_decode($response->getBody());
        $files = collect();
        $files->path = $data->path;

        if (isset($data->_embedded)) {
            foreach ($data->_embedded->items as $item) {
                if (isset($item->media_type) && $item->media_type == 'image')
                    $item->preview = $this->getImage($item->path);
                else $item->preview = null;

                $files->push($item);
            }
            return $files;
        }

        return $data;
    }

    public function uploadFile($file, $path)
    {
        try {
            $filePath = Storage::putFile('public', $file);
            $response = $this->client->request('GET', 'disk/resources/upload?path=' . $path);

            $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/storage/' . explode('/', $filePath)[1], 'r');
            $ch = curl_init(json_decode($response->getBody())->href);
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_UPLOAD, true);
            curl_setopt($ch, CURLOPT_INFILESIZE, $file->getSize());
            curl_setopt($ch, CURLOPT_INFILE, $fp);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_exec($ch);
            curl_close($ch);

            Storage::delete($filePath);

            return null;
        } catch (\Exception $e) {
            if ($e->getCode() == 409)
                return 'Файл с таким именем уже существует';
            if ($e->getCode() == 413)
                return 'Слишком большой размер файла';
        }
    }

    private function getImage($path)
    {
        $img = $this->storage->getResource($path);
        return $img->getLink();
    }
}
