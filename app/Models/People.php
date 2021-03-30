<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class People extends Model
{
    use HasFactory;

    public static function cachePeople()
	{
		$client = Http::withToken(config('services.airtable.key'))
        ->get("https://api.airtable.com/v0/app6UanNZ7ntT5a08/Grid%20view?maxRecords=9&view=Grid%20view");

		Cache::rememberForever('client', function () use ($client){
			return $client->json();
		});
	}
}
