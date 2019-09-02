<?php

namespace App\Providers;

use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

// include in your ServiceProvider

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {

	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

		//$request = app(\Illuminate\Http\Request::class);
		$request = $this->app->request;
		$userName = explode('/', $request->getRequestUri());

		if (!empty($userName) && isset($userName[1]) && $userName[1] != '') {

			$userName = $userName[1];
			$environment = app(Environment::class);
			// Retrieve your website
			$website = Website::where('uuid', $userName)->first();
			if (isset($website->id)) {
				// Now switch the environment to a new tenant.
				$data = $environment->tenant($website);
				$request->request->add(['websiteID' => $website->id]); //add request

				Config::set('database.default', 'tenant');
			}
		}
	}
}
