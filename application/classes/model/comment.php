<?php

class Model_Comment extends Model_Database
{
	//Data members of Model_Comment
	protected $data = array(
		'id'=>NULL,
		'author_id' => NULL,
		'post_id'=> NULL,
		'content' => 'No Content',
		'date_time' => NULL,
		);
	//Ensure the data was loaded from the db correctly
	protected $loaded;
	
	//Default constructor, creates comment object from data members
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
	
	//Creates row in database representing this comment object
	public function create()
	{
		//Validate id (must be integer >= 0)
		if($this->get('id') < 0)
		{
			//Throw exception
		}
		//Validate author_id (must be integer >= 0)
		if($this->get('author_id') < 0)
		{
			//Throw exception
		}
		//Validate post_id (must be integer >= 0)
		if($this->get('post_id') < 0)
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
		
		$this->data['id'] = DB::insert('comments', array_keys($this->data))->values($this->data)->execute($this->_db);
		
		return $this;
	}
	
	//Read row from database that corresponds to the specified id
	public function read()
	{
		$this->data = DB::select()->from('comments')->where('id', '=', $this->get('id'))->limit(1)->execute($this->_db)->current();
		$this->setLoaded(Arr::is_array($this->data));
		return $this;
	}
	
	//Update row from database that corresponds to the specified id
	public function update()
	{
		DB::update('comments')->where('id', '=', $this->get('id'))->set($this->data)->execute($this->_db);
		return $this;
	}
	
	//Delete row from database that corresponds to the specified id
	public function delete()
	{
		DB::delete('comments')->where('id', '=', $this->get('id'))->execute($this->_db);
	}
	
	//Return array of all comments objects for the specified post_id limited by the second parameter and offset by the third (for paging)
	public static function readAll($post_id, $numberOfItems=10, $offset=0)
	{
		$result = DB::select()->from('comments')->where('post_id', '=', $post_id)->limit($numberOfItems)->offset($offset)->execute();
		$comments = array();
		foreach($result as $comment_data)
		{
			$comments[] = new Model_Comment($comment_data);
		}
		return $comments;
	}

}

?>