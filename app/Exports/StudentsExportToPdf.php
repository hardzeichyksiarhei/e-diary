<?php

namespace App\Exports;

use App\User;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
 
class StudentsExportToPdf implements  FromCollection, WithHeadings
{
    use Exportable;

    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
      $student = DB::table('users as u1')->whereIn('u1.id', $this->ids)->where([
				['u1.role', 'student']
			])
			->leftJoin('profile_students', 'profile_students.user_id', '=', 'u1.id')
			->leftJoin('faculties', 'profile_students.faculty_id', '=', 'faculties.id')
			->leftJoin('health_groups', 'profile_students.health_group_id', '=', 'health_groups.id')
			->leftJoin('users as u2', 'profile_students.teacher_id', '=', 'u2.id')
			->select([
				'u1.name', 'u1.email', 
				'profile_students.birthday', 'profile_students.course', 'profile_students.group', 
				'faculties.name as faculty_name',
				'health_groups.name as health_group_name',
        'u2.name as teacher_name'])->get();
        
        return $student;
    }

    public function headings(): array
    {
        return [
            'Name',
            'E-mail',
            'Birthday',
            'Course',
            'Group',
            'Disease',
            'Health Group Name',
            'Teacher Name'
        ];
    }
 
}
