<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeopleRequest;
use App\Models\People;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class PeopleController extends Controller
{
    /**
     * Get all the cached data from Air API
     * @return View|Response|Collection
     */
	public function index()
	{
		$table = collect(Cache::get('client'))->flatten(1)->reverse()->pluck('fields');

		$team = $table->map(function ($data) {
			return [
				'name' => $data['Name'],
				'email' => $data['Email'],
				'photo' => $data['Photo'][0]['url'] ?? ""
			];
		});

		if (request()->wantsJson()) {
			return $team;
		}

		return view('people', compact('team'));
	}

    /**
     * Store data in Airtable via API
     * @param PeopleRequest $request
     * @return JsonResponse
     */
	public function store(PeopleRequest $request): JsonResponse
    {
		$response = Http::withToken(config('services.airtable.key'))
			->post("https://api.airtable.com/v0/{config('services.airtable.id')}/{config('services.airtable.table')", [
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

	/*
	 * Check where weather file is uploaded and return path
	 *
	 * @return string
	 */
	private function hasFile($request)
	{
		if ($request->hasFile('photo')) {
			$path = $request->file('photo')->storeAs('avatars', $request->file('photo')->getClientOriginalName());
			return url($path);
		}
		return '';
	}

	/**
	 * Clears and sets the cache
     * @return void
	 */

	private function clearAndSetCache()
	{
		Cache::forget('client');
		People::cachePeople();
	}
}
