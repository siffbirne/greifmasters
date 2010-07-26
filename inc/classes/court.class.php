<?php


class court extends db{

	protected $id;
	protected $name;
	protected $location;
	protected $owner;
	protected $status;
	
	
	public function __construct(){
		parent::__construct('courts');
	}
	

	public function get_name(){
		
		return $this->name;
	}
	
	public function get_location(){
		
		return $this->location;
	}
	
	public function get_id(){
		
		return $this->id;
	}
	
	public function get_status(){
		
		return $this->status;
	}

	public function get_owner(){
		
		return $this->owner;
	}

#@todo: set-methoden
	
	
	
	
	public function store($name, $location){
		
		if ($name == '' || $location == ''){return 'Please specify name and location';}


		parent::store('name, location, owner', "'$name', '$location', '".$_SESSION['user']."'");

		
		return 'Court was created successfully';
		
	}
	
	


	
	
	
	
	public function check_occupation($start_time, $end_time){
		
		
		$result = parent::select('id',"court_id='$this->id' AND end_time > '$start_time' AND start_time <'$end_time'");
		if ($result==FALSE){return FALSE;}
		return TRUE;
		
	}
	
	
	
}

?>