<?php



class tournament extends db {

	protected $id;
	protected $name;
	protected $city;
	protected $begin;
	protected $end;
	protected $status;
	protected $spots_available;
	protected $registration_deadline;
	protected $host;
	protected $qualifications_mode;
	protected $finals_mode;
	
	
	public function __construct(){
		parent::__construct('tournaments');
	}
	
	
	public function get_id(){
		return $this->id;
	}
	
	public function get_name(){
		return $this->name;
	}
	
	public function get_city(){
		return $this->city;
	}
	
	public function get_begin($format_output = FALSE){
		if ($format_output == TRUE){
			return date('d.m.Y', strtotime($this->begin));
		}
		return $this->begin;
	}
	
	public function get_end($format_output = FALSE){
		if ($format_output == TRUE){
			return date('d.m.Y', strtotime($this->end));
		}
		return $this->end;
	}
	
	public function get_status(){
		return $this->status;
	}
	
	public function get_spots_available(){
		return $this->spots_available;
	}
	
	public function get_registration_deadline(){
		return $this->registration_deadline;
	}
	
	public function get_host(){
		return $this->host;
	}

	public function get_qualifications_mode(){
		return $this->qualifications_mode;
	}
	
	public function get_finals_mode(){
		return $this->finals_mode;
	}
	
	
	public function get_brackets(){
		$brackets = new bracket();
		
		return $brackets->select('id, name',"tournament_id='$this->id'");
		
	}
	
	public function get_playing_times(){
		
		return parent::fetch_results("
			SELECT
				id, court, begin, end
			FROM
				gm_playing_times
			WHERE
				tournament_id = '".$_SESSION['tournament_id']."'
			ORDER BY begin ASC
		");
		
	}
	
	
	
	public function store($name, $city, $begin, $end, $spots_available){

		
		parent::store(
			'name, city, begin, end, spots_available, status',
			"'$name','$city','$begin','$end','$spots_available','0'"
		);

	}

	
	
	public function get_registered_teams(){
		
		$query = "
			SELECT
				t.id, t.name, t.city, r.id AS reg_id
			FROM
				gm_teams AS t
				INNER JOIN gm_registration AS r ON t.id = r.team_id
			WHERE r.tournament_id='$this->id'
		";
		
		
		
		return parent::fetch_results($query);
	}


	public function get_number_of_teams(){
		
		if(self::get_registered_teams() == FALSE){return 0;}

		return sizeof(self::get_registered_teams());

	}



	public function set_status($status){


		if( is_numeric($status) && $status>=0 && $status<=4 ){
			
			parent::update("status='$status'", "id='$this->id'");

		}

	}
	
	#@todo: possible to sum up the set methods?
	
	public function set_spots_available($spots){
		parent::update("spots_available='$spots'","id='$this->id'");
	}
	
	public function set_reg_deadline($deadline){
		parent::update("registration_deadline='$deadline'","id='$this->id'");
	}
	
	public function set_host($host){
		parent::update("host='$host'","id='$this->id'");
	}
	
	public function set_qualification_mode($mode){
		parent::update("qualification_mode='$mode'","id='$this->id'");
	}
	
	public function set_finals_mode($mode){
		parent::update("finals_mode='$mode'","id='$this->id'");
	}


	public function clear_schedule(){
		
		$bracket = new bracket();
		while ($bracket->d);
		var_dump($id);
		
	}
	
	public function delete(){
		parent::delete($this->id);
	}





}



?>