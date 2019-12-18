<?php

namespace App;

use Carbon\Carbon;
use App\Traits\Excludable;

use App\User;
use App\CommonTables\AssessmentLevel;

use Illuminate\Database\Eloquent\Model;

class FunctionalState extends Model
{
    use Excludable;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
	];

	public function getUpdatedAtAttribute($value)
	{
		Carbon::setLocale(config('app.locale'));
		return Carbon::parse($value)->diffForHumans();
  }

  /**
   * Get calculate by userId
   * @param  $userId
   * @return collect DataTable format
   */
  public function getCalculate($userId) {
    $user = User::find($userId);

      $data = $user
        ->functionalStates()
        ->get();

      if ($data->count() == 0) return null;

      $amount_tests = 0;

      $pf = $user->physicalFitnesses()->get();

      $pf_sum_scores = $pf->pluck('sum_scores', 'semester');

      $pf_count_tests = $pf->pluck('count_tests', 'semester');

      $data->each( function ($value, $key) use ($pf_sum_scores, $pf_count_tests, $amount_tests) {
        $amount_tests += $value['count_tests'];
        if ($pf_sum_scores->has($value->semester)) {
          $amount_tests += $pf_count_tests[$value->semester];
          $value['common_sum_scores'] = $value['sum_scores'] + $pf_sum_scores[$value->semester];
          $assessment_level = AssessmentLevel::getAssessmentLevelPoint($amount_tests, $value['common_sum_scores']);
          $value['common_level'] = $assessment_level['level'];
          $value['common_assessment'] = $assessment_level['assessment'];
        } else {
          $value['common_sum_scores'] = '';
          $value['common_assessment'] = '';
          $value['common_level'] = '';
        }

      } );

      $labels = collect([
        "length_body" => "Длина тела (см)",
        "mass_body" => "Масса тела (кг)",
        "mass_index_value" => "Росто-массовый показатель",
        "mass_index_point" => "Кол-во баллов",
        "chss_lie" => "ЧСС в положении лежа за 1 мин",
        "chss_stand" => "ЧСС в положении стоя за 1 мин",
        "orthostatic_test_value" => "Ортостатическая проба",
        "orthostatic_test_point" => "Кол-во баллов",
        "chss_initial" => "ЧСС исходная  уд/10 с",
        "chss_after_load" => "ЧСС после нагрузки уд/10 с",
        "chss_restoring" => "ЧСС восстановления уд/10 с",
        "dosed_load_value" => "Проба на дозированную нагрузку",
        "dosed_load_point" => "Кол-во баллов",
        "sample_shtange" => "Проба Штанге (с)",
        "sample_shtange_point" => "Кол-во баллов",
        "sample_genchi" => "Проба Генчи (с)",
        "sample_genchi_point" => "Кол-во баллов",
        "sum_scores" => "Сумма баллов ФР и ФС",
        "assessment" => "Оценка ФР и ФС",
        "level" => "Уровень ФР и ФС",
        "common_sum_scores" => "Общая сумма баллов ФР, ФС и ФП",
        "common_assessment" => "Оценка физического состояния (ФР, ФС, ФП)",
        "common_level" => "Уровень физического состояния (ФР, ФС, ФП)",
        "updated_at" => "Обновлено"
      ]);

      $semesters = [
				'semester_0' => null,
				'semester_1' => null,
				'semester_2' => null,
				'semester_3' => null,
				'semester_4' => null,
				'semester_5' => null,
				'semester_6' => null
			];

      $newData = collect();

      $labels->each( function ($label, $labelKey) use ($data, $newData, &$semesters) {
        $data->each(function ($d, $dKey) use ($labelKey, &$semesters) {
          if (!is_numeric($d->$labelKey)) {
						// $semesters[$columns[$dKey]] = $d->$labelKey;
						$semesters['semester_' . $d->semester] = $d->$labelKey;
          } else {
						// $semesters[$columns[$dKey]] = round($d->$labelKey, 2);
						$semesters['semester_' . $d->semester] = round($d->$labelKey, 2);
          }
        });
        $newData->put($labelKey, collect([ 'label' => $label ] + $semesters));
      });

      return $newData;
	}
	
	/**
	 * Get calculate from chart by userId
	 * @param $userId
	 * @return collect DataTable format
	 */
	public function getCalculateFromChart($userId) {
		$selectFields = ['semester', 'mass_index_point', 'orthostatic_test_point', 'dosed_load_point', 'sample_shtange_point', 'sample_genchi_point'];

		$data = User::find($userId)
			->functionalStates()
			->select($selectFields)
			->get();

		$semesters = [
			'semester_0',
			'semester_1',
			'semester_2',
			'semester_3',
			'semester_4',
			'semester_5',
			'semester_6'
		];

		$default = [
			"mass_index_point" => null,
			"orthostatic_test_point" => null,
			"dosed_load_point" => null,
			"sample_shtange_point" => null,
			"sample_genchi_point" => null
		];

		$transposeData = $data->chart($semesters, $default)->transpose();

		return $transposeData;
	}

	/**
	 * Get assessment from chart by userId
	 * @param $userId
	 * @return collect DataTable format
	 */
	public function getAssessmentFromChart($userId) {
		$data = User::find($userId)
			->functionalStates()
			->select('semester', 'assessment')
			->get();

		$semesters = [
			'semester_0',
			'semester_1',
			'semester_2',
			'semester_3',
			'semester_4',
			'semester_5',
			'semester_6'
		];

		$default = [
			'assessment' => null
		];

		$data = $data->chart($semesters, $default)->transpose();

		return $data;
	}

    /**
	 * Relationships
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
