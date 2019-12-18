<?php

namespace App\Exports;

use App\FunctionalState;
use Maatwebsite\Excel\Facades\Excel;

class FunctionalStateCalculate
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    private function collection()
    {
      $fs = new FunctionalState();
			$data = $fs->getCalculate($this->userId)->except(['updated_at']);
      return $data;
    }

    private function headings()
    {
        return [
            'Показатели ФР и ФС',
            'Нач. 1 семестра',
            '1 семестр',
            '2 семестр',
            '3 семестр',
            '4 семестр',
            '5 семестр',
            '6 семестр',
        ];
    }

    public function init() {
        return function($excel) {
            $excel->sheet('Функциональное состояние', function($sheet)
            {
                $sheet->fromArray($this->collection(), null, 'A1', false, false);
                $sheet->prependRow($this->headings());
                $sheet->cells('A1:H1', function($cells) {
                    $cells->setBackground('#d8e4bc');
                    $cells->setFontWeight('bold');
                });
            });
        };
    }
}
