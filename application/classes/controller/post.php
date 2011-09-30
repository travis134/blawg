<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller {

	public function action_read()
	{
		$post = Model::factory('post')->set('id', $this->request->param('id'))->read();
		
		if( ! $post->getLoaded())
		{
			throw new HTTP_Exception_404('Post not found!');
		}
		
		$this->response->body(View::factory('common/template')
			->set('title', $post->get('title'))
			->set('body', View::factory('post/read')
				->set('post', $post)));
	}

	public function action_page()
	{
		$POSTS_PER_PAGE = 10;
		
		$posts = Model_Post::readAll($POSTS_PER_PAGE, $POSTS_PER_PAGE * max(0,(intval($this->request->param('page_number', 1))-1)));
	
		if( ! Arr::is_array($posts))
		{
			throw new HTTP_Exception_404('No posts returned!');
		}
		
		$this->response->body(View::factory('common/template')
			->set('title', 'All Posts')
			->set('body', View::factory('post/read_all')
				->set('posts', $posts)));
	}
	
} // End Post