<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\CommonTables\AssessmentLevel;

class CommonAssessmentController extends Controller
{
    public function getCommonAssessmentFromTableByID(Request $request, $id)
    {
        $user = User::find($id);

        $data = $user
            ->functionalStates()
            ->leftJoin('physical_fitnesses', function ($join) {
                $join->on('physical_fitnesses.user_id', '=', 'functional_states.user_id')->on('physical_fitnesses.semester', '=', 'functional_states.semester');
            })
            ->get([
                'functional_states.semester AS semester',
                'functional_states.count_tests AS count_tests_fs',
                'functional_states.sum_scores AS sum_scores_fs',
                'functional_states.assessment AS assessment_fs',
                'functional_states.level AS level_fs',
                
                'physical_fitnesses.count_tests AS count_tests_pf',
                'physical_fitnesses.sum_scores AS sum_scores_pf',
                'physical_fitnesses.assessment AS assessment_pf',
                'physical_fitnesses.level AS level_pf'
            ]);

        if ($data->count() == 0) return null;

        $amount_tests = 0;

        $pf_sum_scores = $data->pluck('sum_scores_pf', 'semester');

        $pf_count_tests = $data->pluck('count_tests_pf', 'semester');

        $data->each(function ($value, $key) use ($pf_sum_scores, $pf_count_tests, $amount_tests) {
            $amount_tests += $value['count_tests_fs'];
            if ($pf_sum_scores->has($value->semester)) {
                $amount_tests += $pf_count_tests[$value->semester];
                $value['common_sum_scores'] = $value['sum_scores_fs'] + $pf_sum_scores[$value->semester];
                $assessment_level = AssessmentLevel::getAssessmentLevelPoint($amount_tests, $value['common_sum_scores']);
                $value['common_level'] = $assessment_level['level'];
                $value['common_assessment'] = $assessment_level['assessment'];
            } else {
                $value['common_sum_scores'] = '';
                $value['common_assessment'] = '';
                $value['common_level'] = '';
            }
        });

        $labels = collect([
            "sum_scores_fs" => "Сумма баллов ФР и ФС",
            "assessment_fs" => "Оценка ФР и ФС",
            "level_fs" => "Уровень ФР и ФС",
            "sum_scores_pf" => "Сумма баллов ФП",
            "assessment_pf" => "Оценка ФП",
            "level_pf" => "Уровень ФП",
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

    public function getCommonAssessmentFromChartByID(Request $request, $id)
    {
        $data = DB::table('functional_states as fs')
            ->where('fs.user_id', $id)
            ->join('physical_fitnesses as ps', function ($join) {
                $join
                    ->on([
                        ['fs.user_id', 'ps.user_id'],
                        ['fs.semester', 'ps.semester']
                    ]);
            })
            ->select('fs.semester as semester', 'fs.count_tests as fs_count_tests', 'ps.count_tests as ps_count_tests', 'fs.sum_scores as fs_sum_scores', 'ps.sum_scores as ps_sum_scores')
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

        $data = $data->map(function ($value, $key) {
            $amount_tests = $value->fs_count_tests + $value->ps_count_tests;
            $assessment_level = AssessmentLevel::getAssessmentLevelPoint($amount_tests, $value->fs_sum_scores + $value->ps_sum_scores);
            $common_level = $assessment_level['level'];
            $common_assessment = $assessment_level['assessment'];
            return [
                'semester' => $value->semester,
                'assessment' => $common_assessment
            ];
        });

        $data = $data->chart($semesters, $default)->transpose();

        return $data;
    }
}
