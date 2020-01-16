<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\ProfileStudentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileStudentController extends Controller
{

	public function get( Request $request ) {
		return $request->user()->profile;
	}

	public function update( ProfileStudentRequest $request ) {

		$user = $request->user();

		$user
			->profile()
			->updateOrCreate(array( 'user_id' => $user->id ), $request->except('disease_group_ids'));

		$profile = $request->user()->profile;

		$profile
			->diseaseGroups()
		->sync($request['disease_group_ids']);

		return $request->user();

	}
}
