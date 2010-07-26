<?php


#FIXME: are players to be saved seperately from their team already, as the intended use of the system as platform would need it? one team would then belong to 3 players. or do players belong to their team? save surname and name seperately? 


class player extends db{
	
	protected $id;
	protected $lastname;
	protected $surname;
	protected $email;
	protected $tshirtsize;
	protected $nick;


	function __construct() {
		parent::__construct('players');
	}
	
	
	
	public function get_id(){
		return $this->id;
	}
	
	public function get_name(){
		return array($this->lastname, $this->surname);
	}
	
	public function get_email(){
		return $this->email;
	}
	
	public function get_tshirtsize(){
		return $this->tshirt_size;
	}
	
	public function get_nick(){
		return $this->nick;
	}
	
	#@todo: set methods
	
	
	
	public function set_name(){
		
	}
	
	public function set_surname(){
		
	}
	
	public function set_email(){
		
	}
	
	public function set_tshirtsize(){
		
	}
	
	public function set_nick(){
		
	}

	
	
	public function store($name, $surname, $email, $tshirtsize, $nick){


		parent::store('name, surname, email, tshirtsize, nick', "'$name', '$surname', '$email', '$tshirtsize', '$nick'");
		
	}
}

?>