<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    /**
     * Gets the Data from AirTable and cache it
     * @return Cache
     */
    public static function cachePeople()
    {
		$client = Http::withToken(config('services.airtable.key'))
        ->get("https://api.airtable.com/v0/".config('services.airtable.id')."/".config('services.airtable.table')."/?maxRecords=9&view=".config('services.airtable.table'));

		Cache::rememberForever('client', function () use ($client) {
            return $client->json();
        });
	}
}
