<?php

namespace App\Exports;

use App\User;

use App\CommonTables\AssessmentLevel;

use Illuminate\Support\Facades\DB;

class StudentsExportToExcel {
    protected $ids;

    public function __construct($ids, $semester = 0) {
        $this->ids = $ids;
        $this->semester = $semester;
    }

    public function collection() {
        $data = DB::table('users as u1')->whereIn('u1.id', $this->ids)->where([
            ['u1.role', 'student']
        ])
        ->leftJoin('profile_students', 'profile_students.user_id', '=', 'u1.id')
        ->leftJoin('faculties', 'profile_students.faculty_id', '=', 'faculties.id')
        ->leftJoin('health_groups', 'profile_students.health_group_id', '=', 'health_groups.id')
        ->leftJoin('users as u2', 'profile_students.teacher_id', '=', 'u2.id')

        ->leftJoin('functional_states as fs', function ($join) {
            $join->on('fs.user_id', '=', 'u1.id')->where('fs.semester', '=', $this->semester);
        })

        ->leftJoin('physical_fitnesses as pf', function ($join) {
            $join->on('pf.user_id', '=', 'u1.id')->where('pf.semester', '=', $this->semester);
        })

        ->select([
            'u1.name',
            'profile_students.birthday',
            'profile_students.course',
            'profile_students.group',
            'profile_students.disease',
            'faculties.name as faculty_name',
            'health_groups.name as health_group_name',
            'u2.name as teacher_name',

            'fs.length_body',
            'fs.mass_body',
            'fs.mass_index_value',
            'fs.mass_index_point',
            'fs.chss_lie',
            'fs.chss_stand',
            'fs.orthostatic_test_value',
            'fs.orthostatic_test_point',

            'fs.chss_initial',
            'fs.chss_after_load',
            'fs.chss_restoring',
            'fs.dosed_load_value',
            'fs.dosed_load_point',

            'fs.sample_shtange',
            'fs.sample_shtange_point',

            'fs.sample_genchi',
            'fs.sample_genchi_point',

            'fs.sum_scores as fs_sum_scores',
            'fs.assessment as fs_assessment',
            'fs.level as fs_level',

            'pf.long_jump',
            'pf.long_jump_point',
            'pf.torso_inclination',
            'pf.torso_inclination_point',
            'pf.run_shuttle',
            'pf.run_shuttle_point',
            'pf.pull_up',
            'pf.pull_up_point',
            'pf.press',
            'pf.press_point',
            'pf.push_up',
            'pf.push_up_point',
            'pf.run_short',
            'pf.run_short_point',
            'pf.run_long',
            'pf.run_long_point',
            DB::raw('COALESCE(pf.swimming_s, pf.swimming_m) as swimming'),
            'pf.swimming_point',

            'pf.sum_scores as pf_sum_scores',
            'pf.assessment as pf_assessment',
            'pf.level as pf_level'])->get();



        $data->each( function ($value, $key) {
            $value->common_sum_scores = $value->fs_sum_scores + $value->pf_sum_scores;

            $assessment_level_point = AssessmentLevel::getAssessmentLevelPoint(14, $value->common_sum_scores);

            $value->common_assessment = $assessment_level_point['level'];
            $value->common_level = $assessment_level_point['assessment'];

        } );

        return json_decode( json_encode($data), true);;
    }

    public function headings() {
        return [
            'Имя',
            'Дата рождения',
            'Курс',
            'Группа',
            'Заболевание',
            'Факультет',
            'Медицинская группа здоровья',
            'Преподаватель',

            'Длина тела',
            'Масса тела',
            'Росто-массовый показатель',
            'Балл',
            'ЧСС в положении лежа за 1 мин.',
            'ЧСС в положении стоя за 1 мин.',
            'Разница пульсов',
            'Балл',

            'ЧСС исх. 10 с',
            'ЧСС после нагр. 10 с',
            'ЧСС вост. 10 с',
            'ПНДН',
            'Балл',

            'Проба Штанге',
            'Балл',

            'Проба Генчи',
            'Балл',

            'Сумма баллов (ФР и ФС)',
            'Оценка (ФР и ФС)',
            'Уровень (ФР и ФС)',

            'Прыжок в длину с места (см)',
            'Балл',
            'Наклон туловища вперед',
            'Балл',
            'Челночный бег 4x9 и (сек)',
            'Балл',
            'Подтягивание на высокой перекладине (раз)',
            'Балл',
            'Поднимание туловища из положения лежа на спине (раз)',
            'Балл',
            'Сгибание и разгибание рук в упоре лежа (раз)',
            'Балл',
            'Бег 30 м (сек)',
            'Балл',
            'Бег 1500/3000 м',
            'Балл',
            'Плавание',
            'Балл',

            'Сумма баллов (ФП)',
            'Оценка (ФП)',
            'Уровень (ФП)',

            'Общая сумма баллов ФР, ФС и ФП',
            'Оценка физического состояния (ФР, ФС, ФП)',
            'Уровень физического состояния (ФР, ФС, ФП)'
        ];
    }

    public function init() {
        return function($excel) {
            $excel->sheet('Студенты', function($sheet)
            {
                $sheet->fromArray($this->collection(), null, 'A1', false, false);
                $sheet->prependRow($this->headings());
                $sheet->cells('A1:AZ1', function($cells) {
                    $cells->setBackground('#d8e4bc');
                    $cells->setFontWeight('bold');
                });
            });
        };
    }
}
