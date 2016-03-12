<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Filesystem\Filesystem;

class PaliDatabaseConversionTest extends TestCase {

	/**
	 * 1. Read 'json' file.
	 * 2. convert to desirable format.
	 * 3. write 'json' to new file.
	 *
	 *	[
	 *		{
	 *			id: ...
	 *			post_contnet: ...
	 * 			post_author: ...
	 * 			post_time: ...
	 *		}
	 *	]
	 *	
	 *
	 */
	public function testJsonConversion() {
		error_reporting(E_ALL); 
		ini_set('display_errors', 'on');
		$base_path = '/Users/apple/Documents/sites/palinfo';
		$fs = new Filesystem();
		if($fs->exists($base_path . '/tests/palinfo_post_data.json')) {
			$data = $fs->get($base_path . '/tests/palinfo_post_data.json');
			$posts = json_decode($data, true);
			$count = count($posts);

			foreach($posts as $i => &$post) {
				$head_line = $post['post_author'];
				$head_segs = explode('|', $head_line);
				$post['id'] = $count;
				$post['author'] = trim($head_segs[0]);
				$post['post_time'] = trim($head_segs[1]);
				unset($post['post_author']);
				$count--;
			}

			$encoded = json_encode($posts, JSON_UNESCAPED_UNICODE);
			$result = $fs->put('/Users/apple/Documents/palinfo_partial_data.json', $encoded);
		}
	}
}