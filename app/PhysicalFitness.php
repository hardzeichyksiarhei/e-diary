<?php

namespace App;

use Carbon\Carbon;
use App\Traits\Excludable;

use Illuminate\Database\Eloquent\Model;

class PhysicalFitness extends Model
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
	public function getCalculate($userId)
	{

		$labels = collect([
			"long_jump" => 'Прыжок в длину с места, см',
			"long_jump_point" => 'Кол-во баллов',
			"torso_inclination" => 'Наклон туловища вперед, см',
			"torso_inclination_point" => 'Кол-во баллов',
			"run_shuttle" => 'Челночный бег 9 х 4 метров (сек)',
			"run_shuttle_point" => 'Кол-во баллов',
			"pull_up" => 'Подтягивание на перекладине, кол-во раз',
			"pull_up_point" => 'Кол-во баллов',
			"press" => 'Поднимание туловища из положения лежа на спине за 60 с (раз)',
			"press_point" => 'Кол-во баллов',
			"push_up" => 'Сгибание и разгибание рук в упоре лежа, раз',
			"push_up_point" => 'Кол-во баллов',
			"run_short" => 'Бег 30 м (сек)',
			"run_short_point" => 'Кол-во баллов',
			"run_long" => 'Бег 1500/3000 метров (мин.сек)',
			"run_long_point" => 'Кол-во баллов',
			"swimming_s" => 'Плавание 50 метров (время)',
			"swimming_m" => 'Плавание 50 метров (метры)',
			"swimming_point" => "Кол-во баллов",
			"sum_scores" => "Сумма баллов ФП",
			"assessment" => "Оценка ФП",
			"level" => 'Уровень ФП',
			"updated_at" => 'Обновлено'
		]);

		$user = User::find($userId);

		$profile = $user->profile;

		$exceptFields = ['id', 'user_id', 'created_at'];

		if ($profile->gender === 'woman') {
			array_push($exceptFields, 'pull_up', 'pull_up_point');
			$labels = $labels->filter(function ($value, $key) {
				return $key !== 'pull_up' && $key !== 'pull_up_point';
			});
		}

		$data = $user->physicalFitnesses()
			->exclude($exceptFields)
			->get();

		if ($data->count() == 0) return null;

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

		$labels->each(function ($label, $labelKey) use ($data, $newData, &$semesters) {
			$data->each(function ($d, $dKey) use ($labelKey, &$semesters) {
				if (!is_numeric($d->$labelKey)) {
					// $semesters[$columns[$dKey]] = $d->$labelKey;
					$semesters['semester_' . $d->semester] = $d->$labelKey;
				} else {
					// $semesters[$columns[$dKey]] = round($d->$labelKey, 2);
					$semesters['semester_' . $d->semester] = round($d->$labelKey, 2);
				}
			});
			$newData->put($labelKey, collect(['label' => $label] + $semesters));
		});

		return $newData;
	}

	/**
	 * Get calculate from chart by userId
	 * @param $userId
	 * @return collect DataTable format
	 */
	public function getCalculateFromChart($userId)
	{
		$selectFields = [
			'semester',
			'long_jump_point',
			'torso_inclination_point',
			'run_shuttle_point',
			'pull_up_point',
			'press_point',
			'push_up_point',
			'run_short_point',
			'run_long_point',
			'swimming_point'
		];

		$user = User::find($userId);

		$profile = $user->profile;

		if ($profile->gender === 'woman') {
			unset($selectFields[4]);
		}

		$data =  $user->physicalFitnesses()
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
			"long_jump_point" => null,
			"torso_inclination_point" => null,
			"run_shuttle_point" => null,
			"pull_up_point" => null,
			"press_point" => null,
			"push_up_point" => null,
			"run_short_point" => null,
			"run_long_point" => null,
			"swimming_point" => null
		];

		$transposeData = $data->chart($semesters, $default)->transpose();

		return $transposeData;
	}

	/**
	 * Get assessment from chart by userId
	 * @param $userId
	 * @return collect DataTable format
	 */
	public function getAssessmentFromChart($userId)
	{
		$data = User::find($userId)
			->physicalFitnesses()
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
