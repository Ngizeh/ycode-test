<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeopleRequest;

class PeopleController extends Controller
{

	public function index()
	{
		return view('people');
	}

	public function store(PeopleRequest $request)
	{
		return response()->json([], 201);
	}
	

}
