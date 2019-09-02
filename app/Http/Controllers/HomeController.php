<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Jobs\InsertInToPost;
use App\User;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Http\Request;
use Session;
use Str;

class HomeController extends Controller {

	public function createWesiteUsers() {

		$website = new Website;
		$website->uuid = Str::random(10);

		// Information of website is stored in the default system connection,
		// the tenant database is created using the system.asia connection.

		//$website->managed_by_database_connection = 'system.asia';

		app(WebsiteRepository::class)->create($website);
		dd($website->uuid);
	}

	public function createAndConnectHostname() {
		$user = 'malaysiaCMS3';
		$website = new Website;
		$website->uuid = $user;

		// Information of website is stored in the default system connection,
		// the tenant database is created using the system.asia connection.

		//$website->managed_by_database_connection = 'system.asia';

		app(WebsiteRepository::class)->create($website);

		$hostname = new Hostname;

		$hostname->fqdn = $user . '.' . config('app.url');
		$hostname = app(HostnameRepository::class)->create($hostname);

		app(HostnameRepository::class)->attach($hostname, $website);
		dd($website->hostnames); // Collection with $hostname

	}

	public function switchToNewTenant(Request $request) {

		$appUser = $request->get('user');
		$tenancy = app(Environment::class);
		$hostname = Hostname::where('fqdn', "$appUser." . config('app.url'))->first();
		$tenancy->hostname($hostname);
		$tenancy->hostname(); // resolves $hostname as currently active hostname
		$Website = Website::where('uuid', $appUser)->first();
		$user = $tenancy->tenant($Website); // switches the tenant and reconfigures the app
		$userwebsite = $tenancy->website(); // resolves $website
		$usertenant = $tenancy->tenant(); // resolves $website
		$tenancy->identifyHostname(); // resets resolving $hostname by using the Request
		echo "<pre>";

		foreach (User::get() as $value) {
			echo $value->user_name . "<br/>";
		}
		Session::put('username', $appUser);

	}

	//private function createPost() {
	public function createPost($user, Request $request) {

		//echo $request->input('user');
		//echo $user;

		InsertInToPost::dispatch(Session::get('websiteID'));
		//->delay(now()->addMinutes(1));

		//Session::flush(Session::getId());

		/*for ($i = 0; $i < 10; $i++) {

				$insertArray[] = [
					'user_name' => "1 database " . Str::random(10),
					'user_post' => Str::random(10) . " -" . Str::random(20),
				];

			}

		*/
		Session::flush(Session::getId());

	}

}
