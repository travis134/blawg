<?php

//Base class to inherit from, for future use to cleanup redundancies
class Model_Base extends Model_Database
{
	//Data members of Model_Comment
	protected $data = array(
		'id'=>NULL
		);
		
	//Ensure the data was loaded from the db correctly
	protected $loaded;
	
	//Name of the model's table
	protected $table;
	
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
	
	//Creates row in database representing this post object
	public function create()
	{
		//Validate id (must be integer >= 0)
		if($this->get('id') < 0)
		{
			//Throw exception
		}
		
		$this->data['id'] = DB::insert($table, array_keys($this->data))->values($this->data)->execute($this->_db);
		
		return $this;
	}
	
	//Read row from database that corresponds to the specified id
	public function read()
	{
		$this->data = DB::select()->from($table)->where('id', '=', $this->get('id'))->limit(1)->execute($this->_db)->current();
		$this->setLoaded(Arr::is_array($this->data));
		return $this;
	}
	
	//Update row from database that corresponds to the specified id
	public function update()
	{
		DB::update($table)->where('id', '=', $this->get('id'))->set($this->data)->execute($this->_db);
		return $this;
	}
	
	//Delete row from database that corresponds to the specified id
	public function delete()
	{
		DB::delete($table)->where('id', '=', $this->get('id'))->execute($this->_db);
	}

}

?>