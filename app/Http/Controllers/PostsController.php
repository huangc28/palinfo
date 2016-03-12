<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Posts;
use DB;

class PostsController extends BaseController {

	/**
	 * Get all posts data.
	 */
	public function all() {
		
		$posts = Posts::all();

		$headers = [
			'Access-Control-Allow-Origin' => '*',
		];
		
		return response()->json($posts->toArray(), 200, $headers, JSON_UNESCAPED_UNICODE);
	}
}