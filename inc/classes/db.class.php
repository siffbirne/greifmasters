<?php

#@todo: free result and other performance stuff still to be implemented

class db extends mysqli {


	protected $table;
	

	function __construct($table) {
		
		parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		 
			if (mysqli_connect_errno()) {
			  printf(
			    "Can't connect to MySQL Server. Errorcode: %s\n",
			    mysqli_connect_error()
			  );
			 
			  exit;
			}
	
		$this->table = DB_TABLE_PREFIX.$table;
	}

	
	
	public function list_entries($format_output=''){
		
		$list = self::select('*');
		
		
		if ($format_output == TRUE){
			foreach ($list as $row){
				foreach ($row as $element){
					$output .= $element . ', ';
				}
				$output .= '<br />';
			}
			return $output;
		}
		
		return $list;
	}

	
	
	public function store($columns, $arguments) {
		
		$query = '
			INSERT INTO ' . $this->table . ' (' . $columns . ')
			VALUES (' . $arguments . ')
		';

		try {self::query ( $query );}
		catch ( Exception $exception ) {
				echo 'Error: ' . $exception->getMessage () . '<br />';
				echo 'File: ' . $exception->getFile () . '<br />';
				echo 'Line: ' . $exception->getLine () . '<br />';
				return;
			}
			
		self::load_entry($this->insert_id);
	
		#@todo: success-notificatin through session variable or something. important database operations should give feedback
		
	}

	
	public function load_entry($id){
		
		$result = self::select('*', "id='$id'");
		$load = $result[0];
		
		if ($load == FALSE){return;}
		
		while ( list ( $key, $value ) = each ( $load ) ) {
			$this->$key = $value ;
		}
		
		
		
	}
	

	public function delete($id) {

		$query = "DELETE FROM $this->table WHERE id='" . $id ."'";

		try {self::query ( $query );}
		catch ( Exception $exception ) {
				echo 'Error: ' . $exception->getMessage () . '<br />';
				echo 'File: ' . $exception->getFile () . '<br />';
				echo 'Line: ' . $exception->getLine () . '<br />';
			}
		
	
	}



	public function select($columns, $where_clause = '') {

		
		$query = 'SELECT ' . $columns . ' FROM ' . $this->table; 
		if ($where_clause != ''){$query .= ' WHERE ' . $where_clause;}

		return self::fetch_results($query);
		
		
	
	}
	
	
	public function update($arguments, $where_clause){
		#@FIXME: expecting id of entry in where clause doesn't make any sense at all when this method is private. making this method private doesn't make any sense either, in the first place
		
		$query = 'UPDATE '. $this->table . ' SET ' . $arguments . ' WHERE ' . $where_clause;
		
		try {self::query ( $query );}
		catch ( Exception $exception ) {
				echo 'Error: ' . $exception->getMessage () . '<br />';
				echo 'File: ' . $exception->getFile () . '<br />';
				echo 'Line: ' . $exception->getLine () . '<br />';
			}
		
		self::load_entry($this->id);
		
	}
	
	
	

	
	public function fetch_results($query){
		
		try {$result = self::query ( $query );}
		catch ( Exception $exception ) {
				echo 'Error: ' . $exception->getMessage () . '<br />';
				echo 'File: ' . $exception->getFile () . '<br />';
				echo 'Line: ' . $exception->getLine () . '<br />';
		}
		
		
		if ($this->affected_rows == 0){return array();}
		
		$return = array();
		
		while ($row = $result->fetch_assoc()){
	        $return[] = $row;
	    }
	    
	    $result->close ();

	    return $return;
	    
	}
	
	
	
	
	public function query($query) {

		$result = parent::query ( $query );
		if (mysqli_error ( $this )) {
			throw new exception ( mysqli_error ( $this ), mysqli_errno ( $this ) );
		}
		return $result;
	}
	
	
	
	
	public function exists($query){
		
		$result = self::query("SELECT id FROM $this->table WHERE $query");
		if ($this->affected_rows == 0){return FALSE;}
		return TRUE;
		
	}
	
	
	
	
//	function __destruct(){
//		$this->close();
//	}
	
	
}

?>