<?php

namespace App\Helpers;

class FilesHelper {
    public static function getPreview(string $fileName) {
        $fileName = explode('.', $fileName);
        $type = array_pop($fileName);

        switch($type) {
            case 'docx':
            case 'doc':
                return asset('img/docx.png');
            case 'jpeg': return asset('img/jpeg.png');
            case 'jpg': return asset('img/jpg.png');
            case 'pdf': return asset('img/pdf.png');
            case 'png': return asset('img/png.png');
            case 'txt': return asset('img/txt.png');
            case 'xls':
            case 'xlsx':
                return asset('img/xls.png');
            case 'zip': return asset('img/zip.png');
        }

        return asset('img/unknown.png');
    }
}