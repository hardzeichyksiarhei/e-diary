<?php

namespace App\Http\Controllers;

use App\User;
use App\ProfileStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

  public function addUser( UserRequest $request )
  {
    $user = User::create([
      'first_name' => $request['first_name'],
      'last_name' => $request['last_name'],
      'name' => $request['first_name'] . ' ' . $request['last_name'],
      'email' => $request['email'],
      'password' => bcrypt($request['password']),
      'role' => $request['role']
    ]);

    if ($user['role'] == 'student') {
        $user->profileStudent()->create([]);

        for ($i = 0; $i <= 6; $i++) {
            $user->functionalStates()->create(['semester' => $i]);
            $user->physicalFitnesses()->create(['semester' => $i]);
        }
    }
    else
        $user->profileStaff()->create([]);
  }

	public function getTeachers( Request $request ) {
		return User::where('role', 'teacher')->get();
	}

	public function searchUsers( Request $request, $role = null )
	{
    $query = User::query();
    if (!is_null($role)) {
      $query = $query->where('role', $role);
    }

    $query = $query->where(function($query) use ($request) {
      $query->where('email', 'LIKE', "%$request->term%");
      $query->orWhere('name', 'LIKE', "%$request->term%");
    });

    $response = $query->paginate(10);

    return response()->json($response);
  }

	public function getStudentsByTeacherID( Request $request, $id ) {
		$students_ids = ProfileStudent::where('teacher_id', $id)->pluck('user_id');
		return User::whereIn('id', $students_ids)->get();
	}

	public function getStudentsPaginate( Request $request ) {

    $search = json_decode($request->search);

		$students = DB::table('users as u1')->where([
        ['u1.name', 'like', "%$search->name%"],
				['u1.role', 'student'],
        ['faculties.name', 'like', "%$search->faculty%"],
        ['u2.name', 'like', "%$search->teacher%"],
        ['profile_students.birthday', 'like', "%$search->birthday%"],
        ['profile_students.course', 'like', "%$search->course%"],
        ['profile_students.group', 'like', "%$search->group%"]
      ])
			->leftJoin('profile_students', 'profile_students.user_id', '=', 'u1.id')
			->leftJoin('faculties', 'profile_students.faculty_id', '=', 'faculties.id')
			->leftJoin('health_groups', 'profile_students.health_group_id', '=', 'health_groups.id')
			->leftJoin('users as u2', 'profile_students.teacher_id', '=', 'u2.id')
			->select([
				'u1.id', 'u1.name', 'u1.email', 'u1.created_at',
				'profile_students.birthday', 'profile_students.course', 'profile_students.group', 'profile_students.disease',
				'faculties.name as faculty_name',
				'health_groups.name as health_group_name',
        'u2.name as teacher_name'])->orderBy('u1.created_at', 'desc')->paginate($request->per_page);

		return $students;
	}

	public function getStaffsPaginate( Request $request ) {
    $search = json_decode($request->search);

    if ($search->role == 'admin') {
      $role = ['student', 'teacher'];
    } else if ($search->role == 'teacher') {
      $role = ['student', 'admin'];
    } else {
      $role = ['student'];
    }

		$teachers = User::where([
      ['id', '!=', $request->user()->id],
      ['name', 'like', "%$search->name%"],
      ['email', 'like', "%$search->email%"]
    ])
      ->whereNotIn('role', $role)
      ->paginate($request->per_page);

		return $teachers;
	}

	public function destroy( Request $request ) {
    if ($request->ids === $request->user()->id) Auth::logout();
		$ids = is_array($request->ids) ? $request->ids : [ $request->ids ];

		User::destroy($ids);
	}
}
