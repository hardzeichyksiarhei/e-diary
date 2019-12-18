<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\ProfileStudentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileStudentController extends Controller
{

	public function get( Request $request ) {
		return $request->user()->profileStudent;
	}

	public function update( ProfileStudentRequest $request ) {

		$user = $request->user();

		$user
			->profileStudent()
			->update($request->except('disease_group_ids'));

		$profileStudentData = $request->user()->profileStudent;

		$profileStudentData
			->diseaseGroups()
		->sync($request['disease_group_ids']);

		$user->hasProfileActive();

		return $request->user();

	}
}
