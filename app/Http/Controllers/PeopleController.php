<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Http\Requests\PeopleRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PeopleController extends Controller
{

	public function index()
	{
		return view('people');
	}

	public function store(PeopleRequest $request)
	{
		$response = Http::withToken(config('services.airtable.key'))
			->post("https://api.airtable.com/v0/app6UanNZ7ntT5a08/Grid%20view", [
				"fields" => [
					"Name" => request('name'),
					"Email" => request('email'),
					"Photo" => [
						["url" => $this->hasFile($request)],
					]
				]
			]);
		$this->clearAndSetCache();
		return response()->json($response, 201);
	}

	private function hasFile($request)
	{
		if ($request->hasFile('photo')) {
			$path = $request->file('photo')->storeAs('avatars', $request->file('photo')->getClientOriginalName());
			return url($path);
		}
		return '';
	}

	private function clearAndSetCache()
	{
		Cache::forget('client');
		People::cachePeople();
	}
}
