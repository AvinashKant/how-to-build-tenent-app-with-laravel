<?php

namespace App\Http\Middleware;
use Closure;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Config;
use Session;

class EnforceTenancy {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (Session::get('username')) {
			Config::set('database.default', 'tenant');

			$environment = app(Environment::class);
			// Retrieve your website
			$website = Website::where('uuid', Session::get('username'))->first();
			// Now switch the environment to a new tenant.
			$environment->tenant($website);

			return $next($request);
		}

		/*

			$website = app(\Hyn\Tenancy\Environment::class)->tenant();

			var_dump($website);
			die;
		*/
		return redirect('/');

	}
}