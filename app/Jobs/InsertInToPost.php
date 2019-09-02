<?php

namespace App\Jobs;
use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Str;

class InsertInToPost implements ShouldQueue {

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $tries = 5;

	public $website_id;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(int $website_id) {
		$this->website_id = $website_id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 *
	Post::insert([
	'user_name' => "1 database " . Str::random(10),
	'user_post' => Str::random(10) . " -" . Str::random(20),
	]);
	 */
	public function handle() {
		$insertArray = [];

		for ($i = 0; $i < 10; $i++) {

			$insertArray[] = [
				'user_name' => "$this->website_id",
				'user_post' => Str::random(10) . " -" . Str::random(20),
			];

		}

		Post::insert($insertArray);
	}
}
