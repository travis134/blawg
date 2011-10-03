<?php

class Model_User extends Model_Database
{
	//Data members of Model_User
	protected $data = array(
		'id'=>NULL,
		'username' => NULL,
		'email_address'=> NULL,
		'password' => NULL
		);
	//Ensure the data was loaded from the db correctly
	protected $loaded;
	
	//Default constructor, creates user object from data members
	public function __construct(array $data=NULL)
	{
		if(Arr::is_array($data))
		{
			$this->data = $data;
		}
	}
	
	//Get data member, second parameter provides a default return value
	public function get($property, $default=NULL)
	{
		return Arr::get($this->data, $property, $default);
	}
	
	//Set data member, return reference to self to allow method chaining
	public function set($property, $value)
	{
		$this->data[$property] = $value;
		return $this;
	}
	
	public function getLoaded()
	{
		return $this->loaded;
	}
	
	protected function setLoaded($loaded)
	{
		$this->loaded = $loaded;
		return $this;
	}
	
	//Set session for user to login
	public function login($password)
	{
		$result = false;
		//If the md5 hashes match
		if($this->get('password') == $password)
		{
			$result = true;
		}
		return $result;
	}
	
	//Creates row in database representing this user object
	public function create()
	{
		//Validate id (must be integer >= 0)
		if($this->get('id') < 0)
		{
			//Throw exception
		}
		//Validate username (must be <= 20 chars)
		if(strlen($this->get('username')) > 20)
		{
			//Throw exception
		}
		//Validate email_address (must be <= 100 chars)
		if(strlen($this->get('email_address')) > 100)
		{
			//Throw exception
		}
		//Validate password (must be == 32 chars, md5)
		if(strlen($this->get('password') != 32))
		{
			//Throw exception
		}
		
		$this->data['id'] = DB::insert('users', array_keys($this->data))->values($this->data)->execute($this->_db);
		
		return $this;
	}
	
	//Read row from database that corresponds to the specified id
	public function read()
	{
		$this->data = DB::select()->from('users')->where('id', '=', $this->get('id'))->or_where('username', '=', $this->get('username'))->or_where('email_address', '=', $this->get('email_address'))->limit(1)->execute($this->_db)->current();
		$this->setLoaded(Arr::is_array($this->data));
		return $this;
	}
	
	//Update row from database that corresponds to the specified id
	public function update()
	{
		DB::update('users')->where('id', '=', $this->get('id'))->set($this->data)->execute($this->_db);
		return $this;
	}
	
	//Delete row from database that corresponds to the specified id
	public function delete()
	{
		DB::delete('users')->where('id', '=', $this->get('id'))->execute($this->_db);
	}
	
	//Return array of all user objects limited by the second parameter and offset by the third (for paging)
	public static function readAll($numberOfItems=10, $offset=0)
	{
		$result = DB::select()->from('users')->limit($numberOfItems)->offset($offset)->execute();
		$users = array();
		foreach($result as $user_data)
		{
			$users[] = new Model_User($user_data);
		}
		return $users;
	}

}

?>