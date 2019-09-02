<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Jobs\InsertInToPost;
use App\User;
use DB;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Website;
use Illuminate\Http\Request;
use Str;

class UserController extends Controller {

	public function createUserView() {
		return view('createuser');
	}

	public function createTenantUser(Request $request) {
		$website = new Website;
		$website->uuid = $this->getUniqueSlug(Str::slug($request->get('username'), '-'));
		app(WebsiteRepository::class)->create($website);
		return redirect()->route('listUsersRoute');
	}

	public function listUsers() {

		echo request()->getHost();
		$datatoview['users'] = Website::orderBy('created_at', 'DESC')->get();
		return view('listuser', $datatoview);
	}

	//private function createPost() {
	public function createPost($user, Request $request) {
		InsertInToPost::dispatch($request->get('websiteID'));
		//->delay(now()->addMinutes(1));

		echo "POST created Successfully";
	}

	public function createUser() {

		$userObj = User::insert(
			[
				'name' => Str::random(10),
				'email' => Str::random(10),
				'password' => Str::random(10),
			]
		);

		echo "User created Successfully";

	}

	private function getUniqueSlug($name) {

		DB::statement("SET @p0='" . $name . "';");
		DB::select(
			"call GET_TENENT_UNIQUE_SLUG(@p0);"
		);
		$data = DB::select(
			"SELECT @p0 AS `get_institute_name`;"
		);
		return $data[0]->get_institute_name ?? $name;
	}

}
