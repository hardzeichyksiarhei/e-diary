<?php

namespace App\Http\Controllers;

use App\Exports\ExportExcel;
use App\FunctionalState;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\StudentsExportToExcel;
use App\Exports\FunctionalStateCalculate;
use App\Exports\PhysicalFitnessCalculate;

class ExportToExcel extends Controller {
    public function students( Request $request ) {
        $ids = $request->ids;
        $semester = $request->semester;
        ExportExcel::download(new StudentsExportToExcel($ids, $semester), 'students');
    }

    public function functionalStateCalculation($userId) {
        ExportExcel::download(new FunctionalStateCalculate($userId), 'function-state');
    }

    public function physicalFitnessCalculation($userId) {
        ExportExcel::download(new PhysicalFitnessCalculate($userId), 'physical-fitness');
    }
}
