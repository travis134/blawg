<?php

class Model_Post extends Model_Database
{
	//Data members of Model_Post
	protected $data = array(
		'id'=>NULL,
		'title'=>'No Title',
		'content' => 'No Content',
		'date_time' => NULL,
		'author_id' => NULL
		);
	//Ensure the data was loaded from the db correctly
	protected $loaded;
	
	//Default constructor, creates post object from data members
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
	
	//Creates row in database representing this post object
	public function create()
	{
		//Validate id (must be integer >= 0)
		if($this->get('id') < 0)
		{
			//Throw exception
		}
		//Validate title (must be <= 160 chars)
		if(strlen($this->get('title')) > 160)
		{
			//Throw exception
		}
		//Validate content (must be <= 1000 chars)
		if(strlen($this->get('content')) > 1000)
		{
			//Throw exception
		}
		//Validate date_time (must be MySQL default datetime format)
		if(!is_int($this->get('date_time')))
		{
			if($this->get('date_time') != date('Y-m-d H:i:s', strtotime($this->get('date_time'))))
			{
				//Throw exception
			}
		}else{
			if($this->get('date_time') != date('Y-m-d H:i:s', $this->get('date_time')))
			{
				//Throw exception
			}
		}
		//Validate author_id (must be integer >= 0)
		if($this->get('author_id') < 0)
		{
			//Throw exception
		}
		
		$this->data['id'] = DB::insert('posts', array_keys($this->data))->values($this->data)->execute($this->_db);
		
		return $this;
	}
	
	//Read row from database that corresponds to the specified id
	public function read()
	{
		$this->data = DB::select()->from('posts')->where('id', '=', $this->get('id'))->limit(1)->execute($this->_db)->current();
		$this->setLoaded(Arr::is_array($this->data));
		return $this;
	}
	
	//Update row from database that corresponds to the specified id
	public function update()
	{
		DB::update('posts')->where('id', '=', $this->get('id'))->set($this->data)->execute($this->_db);
		return $this;
	}
	
	//Delete row from database that corresponds to the specified id
	public function delete()
	{
		DB::delete('posts')->where('id', '=', $this->get('id'))->execute($this->_db);
	}
	
	//Return array of all posts objects limited by the first parameter and offset by the second (for paging)
	public static function readAll($numberOfItems=10, $offset=0)
	{
		$result = DB::select()->from('posts')->limit($numberOfItems)->offset($offset)->execute();
		$posts = array();
		foreach($result as $post_data)
		{
			$posts[] = new Model_Post($post_data);
		}
		return $posts;
	}

	//Return array of all posts objects from the given author limited by the first parameter and offset by the second (for paging)
	public static function readAllByUser($author_id, $numberOfItems=10, $offset=0)
	{
		$result = DB::select()->from('posts')->where('author_id', '=', $author_id)->limit($numberOfItems)->offset($offset)->execute();
		$posts = array();
		foreach($result as $post_data)
		{
			$posts[] = new Model_Post($post_data);
		}
		return $posts;
	}

}

?>