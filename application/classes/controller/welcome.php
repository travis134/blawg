<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		$posts = Model_Post::readAll(10, 0);
		
		if( ! Arr::is_array($posts))
		{
			throw new HTTP_Exception_404('No posts returned!');
		}
		
		$this->response->body(View::factory('common/template')
			->set('title', 'Blawg')
			->set('body', View::factory('welcome')
				->set('posts', $posts)));
	}

} // End Welcome
