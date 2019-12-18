<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\StudentsExportToPdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportToPdfController extends Controller
{ 
    public function students( Request $request )
    {
      $ids = $request->ids;
      Excel::store(new StudentsExportToPdf($ids), 'students.pdf', 'export', \Maatwebsite\Excel\Excel::MPDF);
    }
}