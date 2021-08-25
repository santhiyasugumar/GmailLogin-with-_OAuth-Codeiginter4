<?php

namespace App\Controllers;

class Profile extends BaseController
{
	public function index()
	{
        $data['username'] = session()->get("LoggedUserData");
		return view('profile_view' , $data);
	}
}
