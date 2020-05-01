<?php

namespace App\Http\Controllers;

use App\User;
use App\PhysicalFitness;
use Illuminate\Http\Request;

use App\Http\Requests\PhysicalFitnessRequest;

use App\Console\Commands\PhysicalFitness\LongJump;
use App\Console\Commands\PhysicalFitness\TorsoInclination;
use App\Console\Commands\PhysicalFitness\RunShuttle;
use App\Console\Commands\PhysicalFitness\Press;
use App\Console\Commands\PhysicalFitness\RunShort;
use App\Console\Commands\PhysicalFitness\PushUp;
use App\Console\Commands\PhysicalFitness\PullUp;
use App\Console\Commands\PhysicalFitness\RunLong;
use App\Console\Commands\PhysicalFitness\Swimming;

use App\CommonTables\AssessmentLevel;

use App\Traits\CalculateAge;

class PhysicalFitnessController extends Controller
{
    use CalculateAge;

    private $pf;

    public function __construct()
    {
        $this->pf = new PhysicalFitness();
    }

    public function getInitialData(Request $request, $semester)
    {

        return $request
            ->user()
            ->physicalFitnesses()
            ->where('semester', $semester)
            ->first();
    }

    public function updateСalculation(PhysicalFitnessRequest $request, $semester)
    {

        $user = $request->user();

        $gender = $user->profile->gender;

        $age = $request->age || self::calculateAge($user->profile->birthday);

        $data = $request->toArray();

        // Прыжок в длину с места, см
        $data['long_jump_point'] = $this->dispatch(new LongJump($gender, $age, $request->long_jump));

        // Наклон туловища вперед, см
        $data['torso_inclination_point'] = $this->dispatch(new TorsoInclination($gender, $age, $request->torso_inclination));

        // Подтягивание на перекладине, кол-во раз
        $data['run_shuttle_point'] = $this->dispatch(new RunShuttle($gender, $age, $request->run_shuttle));

        // Поднимание туловища из положения лежа на спине за 60 с, раз
        $data['press_point'] = $this->dispatch(new Press($gender, $age, $request->press));

        // Бег 30 м, сек
        $data['run_short_point'] = $this->dispatch(new RunShort($gender, $age, $request->run_short));

        // Сгибание и разгибание рук в упоре лежа, раз
        $data['push_up_point'] = $this->dispatch(new PushUp($gender, $age, $request->push_up));

        // Бег 1500/3000 м (мин. сек)
        $data['run_long_point'] = $this->dispatch(new RunLong($gender, $age, $request->run_long));

        // Подтягивание на высокой перекладине, раз
        // $data['pull_up'] = $data['pull_up'] ?: 0;
        $data['pull_up_point'] = $this->dispatch(new PullUp($gender, $age, $request->pull_up));

        // Плавание 50 метров (сек/метры)
        // $data['swimming_s'] = $data['swimming_s'] ?: 0.0;
        // $data['swimming_m'] = $data['swimming_m'] ?: 0;
        $data['swimming_point'] = $this->dispatch(new Swimming($gender, $request->swimming_s, $request->swimming_m));

        // Сумма баллов ФП
        $points = [
            $data['long_jump_point'],
            $data['torso_inclination_point'],
            $data['run_shuttle_point'],
            $data['press_point'],
            $data['run_short_point'],
            $data['push_up_point'],
            $data['run_long_point'],
            $data['pull_up_point'],
            $data['swimming_point'],
        ];
        $sum_scores = array_sum($points);

        $amount_tests = 0;

        foreach ($points as $point) {
            if ($point !== 0) $amount_tests++;
        }

        $assessment_level = AssessmentLevel::getAssessmentLevelPoint($amount_tests, $sum_scores);
        $level = $assessment_level['level'];
        $assessment = $assessment_level['assessment'];

        $user
            ->physicalFitnesses()
            ->firstOrCreate(['semester' => $semester])
            ->update($data + [
                    'count_tests' => $amount_tests,
                    'sum_scores' => $sum_scores,
                    'level' => $level,
                    'assessment' => $assessment
                ]);
    }

    public function getСalculationFromTableByID(Request $request, $id)
    {
        $data = $this->pf->getCalculate($id);
        return $data;
    }

    public function getСalculationPointsFromChartByID(Request $request, $id)
    {
        $data = $this->pf->getCalculateFromChart($id);
        return $data;
    }

    public function getAssessmentFromChartByID(Request $request, $id)
    {
        $data = $this->pf->getAssessmentFromChart($id);
        return $data;
    }

    public function destroyСalculationByUserIdAndSemester(Request $request, $userId, $semester)
    {
        return PhysicalFitness::where([
            ['user_id', '=', $userId],
            ['semester', '=', $semester]
        ])->delete();
    }
}
