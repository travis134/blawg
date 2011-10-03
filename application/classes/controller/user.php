<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller {

	public function action_read()
	{
		$user = Model::factory('user')->set('id', $this->request->param('id'))->read();
		
		if( ! $user->getLoaded())
		{
			throw new HTTP_Exception_404('Post not found!');
		}
		
		$this->response->body(View::factory('common/template')
			->set('title', $user->get('username'))
			->set('body', View::factory('user/read')
				->set('user', $user)));
	}
	
	public function action_login()
	{
		$this->response->body(View::factory('common/template')
			->set('title', 'Login')
			->set('body', View::factory('user/login')));
	}
	
	
} // End User