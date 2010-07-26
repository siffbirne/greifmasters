<?php



function shuffle_matchlist($matchlist, $number_of_teams) {

	$shuffled = array ();
	$exception = FALSE;
	
	$mingap = floor ( ($number_of_teams - 3) / 2 );
	
	while ( sizeof ( $matchlist ) > 0 ) {
		
		$didsomething = FALSE;
		
		for($i = 0; $i < sizeof ( $matchlist ); $i ++) {
			
			$each = each ( $matchlist );
			if ($each == FALSE) {
				reset ( $matchlist );
				$each = each ( $matchlist );
			}
			$index = $each [0];
			$match = $each [1];
			$k = sizeof ( $shuffled )-1;
			
			$passt = TRUE;
			
			for($j = 0; $j <= $mingap; $j ++) {
				
				if (isset ( $shuffled [$k - $j] ) && (in_array ( $match [0], $shuffled [$k - $j] ) || in_array ( $match [1], $shuffled [$k - $j] ))) {
					$passt = FALSE;
				}
			
			}
			
			if ($passt == TRUE || $exception == TRUE) {
				array_push ( $shuffled, $match );
				$didsomething = TRUE;
				$exception = FALSE;
				unset ( $matchlist [$index] );
			
			}
		}
		
		if ($didsomething == FALSE) {
			$exception = TRUE;
		}
	}

	return $shuffled;
}


//function shuffle_matchlist($matchlist, $number_of_teams) {
//
//	$shuffled = array ();
//	
//	$mingap = floor ( ($number_of_teams - 3) / 2 );
//	
//	$didsomething = TRUE;
//	
//	while (sizeof($matchlist) > 0){
//		
//		while ($didsomething == TRUE){
//			$didsomething = FALSE;
//		
//			foreach ($matchlist as $index => $match){
//				$ok = TRUE;
//			
//				for ($i=0; $i<$mingap; $i++){
//					
//					if (isset($shuffled[sizeof($shuffled)-$i])){
//						if (
//							(in_array ( $match [0], $shuffled [sizeof($shuffled)-$i] )
//							|| in_array ( $match [1], $shuffled [sizeof($shuffled)-$i] ))
//						){
//							$ok = FALSE;
//						}
//					}
//						
//				}
//			
//				if ($ok==TRUE){
//					$shuffled[] = $match;
//					unset ($matchlist[$index]);
//					$didsomething = TRUE;
//				}
//			}
//		}
//		
//		$store = $matchlist[0];
//		$matchlist[0] = $matchlist[1];
//		$matchlist[1] = $store;
//	}
//	
//	
//	
//
//	return $shuffled;
//}
?>