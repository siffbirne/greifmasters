<?php


class upc_match extends match {
	
	
	protected $id;
	protected $match_id;
	protected $order;
	protected $ready_team1;
	protected $ready_team2;

#@todo: class is just scratch
	public function __construct() {

		parent::__construct ('upc_matches');
	
	}
	
	
	public function store($match_id, $court_id, $queue = ''){
		if ($queue != ''){
			db::store('match_id, court_id, match_order', "'$match_id', '$court_id', '$queue'");
		}else{
			db::store('match_id, court_id', "'$match_id', '$court_id'");
		}
	}
	

	
}

?>