<?php

namespace App\Http\Controllers;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public static function GetConnection($appUser) {

		$tenancy = app(Environment::class);
		$hostname = Hostname::where('fqdn', "$appUser." . config('app.url'))->first();
		$tenancy->hostname($hostname);
		$tenancy->hostname(); // resolves $hostname as currently active hostname
		$Website = Website::where('uuid', $appUser)->first();
		$user = $tenancy->tenant($Website); // switches the tenant and reconfigures the app
		$userwebsite = $tenancy->website(); // resolves $website
		$usertenant = $tenancy->tenant(); // resolves $website
		$tenancy->identifyHostname();

	}
}
