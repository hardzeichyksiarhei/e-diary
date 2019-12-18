<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
	
	public function index( Request $request ) {
	    return Faculty::all();
    }

    public function store( Request $request ) {
	    $this->validate($request, [
		    'name' => 'required',
	    ]);

	    return Faculty::create($request->all());
    }

    public function destroy( Request $request, $id ) {
	    Faculty::find($id)->delete();
    }

	public function update( Request $request, $id ) {
		$this->validate($request, [
			'name' => 'required',
		]);

		Faculty::find($id)->update($request->all());
	}
}
