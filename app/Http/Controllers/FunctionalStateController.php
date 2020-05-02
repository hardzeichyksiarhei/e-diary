<?php

namespace App\Http\Controllers;

use App\FunctionalState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Console\Commands\FunctionalState\MassIndex;
use App\Console\Commands\FunctionalState\OrthostaticTest;
use App\Console\Commands\FunctionalState\DosedLoad;
use App\Console\Commands\FunctionalState\SampleShtange;
use App\Console\Commands\FunctionalState\SampleGenchi;

use App\CommonTables\AssessmentLevel;

class FunctionalStateController extends Controller
{

    private $fs;

    public function __construct()
    {
        $this->fs = new FunctionalState();
    }

    public function getInitialData(Request $request, $semester)
    {
        $exceptFileds = ['mass_index_value', 'mass_index_point', 'orthostatic_test_value', 'orthostatic_test_point', 'dosed_load_value', 'dosed_load_point'];

        return $request
            ->user()
            ->functionalStates()
            ->where('semester', $semester)
            ->exclude($exceptFileds)
            ->first();
    }

    public function updateСalculation(Request $request, $semester)
    {
        $user = $request->user();

        $gender = $user->profile->gender;

        // Росто-масовый показатель
        $mass_body = $request['mass_body'];
        $length_body = $request['length_body'];
        $mass_index = $this->dispatch(new MassIndex($gender, $mass_body, $length_body));
        $mass_index_value = $mass_index['value'];
        $mass_index_point = $mass_index['point'];

        // Ортостатическая проба
        $chss_stand = $request['chss_stand'];
        $chss_lie = $request['chss_lie'];
        $orthostatic_test = $this->dispatch(new OrthostaticTest($gender, $chss_lie, $chss_stand));
        $orthostatic_test_point = $orthostatic_test['point'];
        $orthostatic_test_value = $orthostatic_test['value'];

        // Проба на дозированную нагрузку
        $chss_initial = $request['chss_initial'];
        $chss_after_load = $request['chss_after_load'];
        $chss_restoring = $request['chss_restoring'];
        $dosed_load = $this->dispatch(new DosedLoad($gender, $chss_initial, $chss_after_load, $chss_restoring));
        $dosed_load_value = $dosed_load['value'];
        $dosed_load_point = $dosed_load['point'];

        // Проба Генчи
        $sample_shtange = $request['sample_shtange'];
        $sample_shtange_point = $this->dispatch(new SampleShtange($gender, $sample_shtange));

        // Проба Штанге
        $sample_genchi = $request['sample_genchi'];
        $sample_genchi_point = $this->dispatch(new SampleGenchi($gender, $sample_genchi));

        // Сумма баллов ФР и ФС
        $points = [$mass_index_point, $orthostatic_test_point, $dosed_load_point, $sample_shtange_point, $sample_genchi_point];
        $sum_scores = array_sum($points);

        $amount_tests = 0;
        foreach ($points as $point) {
            if ($point !== 0) $amount_tests++;
        }

        $assessment_level = AssessmentLevel::getAssessmentLevelPoint($amount_tests, $sum_scores);
        $level = $assessment_level['level'];
        $assessment = $assessment_level['assessment'];

        $fs = $user
            ->functionalStates()
            ->firstOrCreate(['semester' => $semester]);

        $fs->update([
            'mass_body' => $mass_body,
            'length_body' => $length_body,
            'mass_index_value' => $mass_index_value,
            'mass_index_point' => $mass_index_point,

            'chss_stand' => $chss_stand,
            'chss_lie' => $chss_lie,
            'orthostatic_test_value' => $orthostatic_test_value,
            'orthostatic_test_point' => $orthostatic_test_point,

            'chss_initial' => $chss_initial,
            'chss_after_load' => $chss_after_load,
            'chss_restoring' => $chss_restoring,
            'dosed_load_value' => $dosed_load_value,
            'dosed_load_point' => $dosed_load_point,

            'sample_shtange' => $sample_shtange,
            'sample_shtange_point' => $sample_shtange_point,

            'sample_genchi' => $sample_genchi,
            'sample_genchi_point' => $sample_genchi_point,

            'count_tests' => $amount_tests,
            'sum_scores' => $sum_scores,
            'level' => $level,
            'assessment' => $assessment
        ]);

        $fs->touch();

        return $fs;
    }

    public function getСalculationFromTableByID(Request $request, $id)
    {
        $data = $this->fs->getCalculate($id, false);
        return $data;
    }

    public function getСalculationPointsFromChartByID(Request $request, $id)
    {
        $data = $this->fs->getCalculateFromChart($id);
        return $data;
    }

    public function getAssessmentFromChartByID(Request $request, $id)
    {
        $data = $this->fs->getAssessmentFromChart($id);
        return $data;
    }

    public function destroyСalculationByUserIdAndSemester(Request $request, $userId, $semester)
    {
        return FunctionalState::where([
            ['user_id', '=', $userId],
            ['semester', '=', $semester]
        ])->delete();
    }
}
