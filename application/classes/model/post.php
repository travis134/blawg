<?php

class Model_Post extends Model_Database
{

	protected $data = array(
		'id'=>NULL,
		'title'=>'No Title',
		'content' => 'No Content',
		'date_time' => NULL,
		'author_id' => NULL
		);
	protected $loaded;
	
	public function __construct(array $data=NULL)
	{
		if(Arr::is_array($data))
		{
			$this->data = $data;
		}
	}
	
	public function get($property, $default=NULL)
	{
		return Arr::get($this->data, $property, $default);
	}
	
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
	}
	
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
	}
	
	public function read()
	{
		$this->data = DB::select()->from('posts')->where('id', '=', $this->data['id'])->limit(1)->execute($this->_db)->current();
		$this->setLoaded(Arr::is_array($this->data));
		return $this;
	}
	
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

}

?>