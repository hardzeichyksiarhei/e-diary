<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\ProfileStaffRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileStaffController extends Controller
{
    public function get( Request $request ) {
	    return $request->user()->profileStaff;
    }

    public function update( ProfileStaffRequest $request ) {

		$user = $request->user();

		$user
		    ->profileStaff()
			->update($request->toArray());
			
		$user->hasProfileActive();

		return $request->user();

    }
}
