<?php

namespace App\Http\Controllers;

use App\DiseaseGroup;
use Illuminate\Http\Request;

class DiseaseGroupController extends Controller
{
    public function index( Request $request ) {
	    return DiseaseGroup::all();
    }

	public function store( Request $request ) {
		$this->validate($request, [
			'name' => 'required',
			'text' => 'required'
		]);

		return DiseaseGroup::create($request->all());
	}

	public function destroy( Request $request, $id ) {
		DiseaseGroup::find($id)->delete();
	}

	public function update( Request $request, $id ) {
		$this->validate($request, [
			'name' => 'required',
			'text' => 'required'
		]);

		DiseaseGroup::find($id)->update($request->all());
	}
}
