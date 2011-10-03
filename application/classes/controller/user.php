<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller {

	public function action_read()
	{
		$user = Model::factory('user')->set('id', $this->request->param('id'))->read();
		
		if( ! $user->getLoaded())
		{
			throw new HTTP_Exception_404('User not found!');
		}
		
		$this->response->body(View::factory('common/template')
			->set('title', $user->get('username'))
			->set('body', View::factory('user/read')
				->set('user', $user)));
	}
	
	public function action_logout()
	{
		$this->session = Session::instance();
	
		$this->session->delete('id');
		$this->session->delete('username');
		$this->session->delete('email_address');
		
		$this->response->body(View::factory('common/template')
			->set('title', 'Logged out')
			->set('body', View::factory('user/logout')));
	}
	
	public function action_login()
	{
		$this->session = Session::instance();
		
		if(!is_null($this->session->get('id')))
		{
			$this->request->redirect('/controlpanel');
		}
	
		$username = $this->request->post('login-username');
		$password = $this->request->post('login-password');
		if(is_null($username) || is_null($password))
		{
			$this->response->body(View::factory('common/template')
				->set('title', 'Login')
				->set('body', View::factory('user/login')));
		}
		else
		{
			$user = Model::factory('user')->set('username', $username)->read();
			
			if( ! $user->getLoaded())
			{
				throw new HTTP_Exception_404('User not found!');
			}
			
			if($user->login(md5($password)))
			{
				$this->session->set('id', $user->get('id'));
				$this->session->set('username', $user->get('username'));
				$this->session->set('email_address', $user->get('email_address'));
			}
			else
			{
				$output = 'Incorrect password!';
			}
		}
		
		
	}
	
	public function action_controlpanel()
	{
		$this->session = Session::instance();
	
		$user = Model::factory('user')->set('id', $this->session->get('id'))->read();
		
		if( ! $user->getLoaded())
		{
			throw new HTTP_Exception_404('User not found!');
		}
	
		$this->response->body(View::factory('common/template')
			->set('title', 'Control Panel')
			->set('body', View::factory('user/controlpanel')
				->set('user', $user)));
	}
	
} // End User