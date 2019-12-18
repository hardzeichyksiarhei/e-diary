<?php


namespace App\Exports;

use Maatwebsite\Excel\Facades\Excel;

class ExportExcel
{
    public static function download($settings, $filename, $extension = 'xlsx') {
        return Excel::create($filename, $settings->init())->download($extension);
    }

    public static function store($settings, $filename, $extension = 'xlsx', $path = 'exports') {
        return Excel::create($filename, $settings->init())->store($extension, $path);
    }
}
