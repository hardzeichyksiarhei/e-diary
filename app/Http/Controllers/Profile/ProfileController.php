<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        return tap($user)->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'patronymic_name' => $request['patronymic_name'],
            'name' => $request['last_name'] . ' ' . $request['first_name'] . ( $request['patronymic_name'] ? ' ' . $request['patronymic_name'] : '' ),
            'email' => $request['email']
        ]);
    }
}
