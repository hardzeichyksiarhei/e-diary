<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\ProfileStaffRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileStaffController extends Controller
{
    public function get( Request $request ) {
	    return $request->user()->profile;
    }

    public function update( ProfileStaffRequest $request ) {

		$user = $request->user();

		$user
			->profile()
			->updateOrCreate(array( 'user_id' => $user->id ), $request->toArray());

		return $request->user();

    }
}
