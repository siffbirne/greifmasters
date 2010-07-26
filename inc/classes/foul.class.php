<?php

class foul extends game_event {

	protected $type;
	
	#@todo: variables. codes for fouls... don't know. everything missing, fouls not implemeted yet

	public function __construct() {

		parent::__construct ('fouls');
	
	}
	
	public function get_type(){
		return $this->type;
	}
}

?>