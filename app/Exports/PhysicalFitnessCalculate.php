<?php

namespace App\Exports;

use App\PhysicalFitness;

class PhysicalFitnessCalculate
{

  protected $userId;

  public function __construct($userId)
  {
      $this->userId = $userId;
  }

  public function collection()
  {
    $pf = new PhysicalFitness();
    $data = $pf->getCalculate($this->userId)->except(['updated_at']);
    return $data;
  }

  public function headings()
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
            $excel->sheet('Физическая подготовленность', function($sheet)
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
