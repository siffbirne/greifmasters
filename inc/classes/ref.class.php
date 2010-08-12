<?php

class ref extends db {
	
	protected $id;
	protected $user;
	protected $court;
	protected $rights = 'ref';
	protected $bracket;
	
	
	
	public function __construct(){
		parent::__construct('users');
	}


	
	public function get_id(){
		return $this->id;
	}

	
	public function get_name(){
		return $this->user;
	}
	
	public function get_court(){
		return $this->court;
	}
	
	public function get_bracket(){
		return $this->bracket;
	}
	
	
	public function store($user, $court, $bracket, $passwords) {

	
		parent::store(
			'user, rights, court, bracket, salt, pass',
				"'$user',
				'$this->rights',
				'$court',
				'$bracket',
				'$passwords[0]',
				'$passwords[1]'"
		);
	}
	
	public function delete(){
		parent::delete($this->id);
	}
	
	
}


?>