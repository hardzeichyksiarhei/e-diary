<?php

namespace App\Http\Controllers;

use App\HealthGroup;
use Illuminate\Http\Request;

class HealthGroupController extends Controller
{
    public function index( Request $request ) {
	    return HealthGroup::all();
    }

    public function store( Request $request ) {
	    $this->validate($request, [
		    'name' => 'required',
	    ]);

	    return HealthGroup::create($request->all());
    }

    public function destroy( Request $request, $id ) {
	    HealthGroup::find($id)->delete();
    }

	public function update( Request $request, $id ) {
		$this->validate($request, [
			'name' => 'required',
		]);

		HealthGroup::find($id)->update($request->all());
	}
}
