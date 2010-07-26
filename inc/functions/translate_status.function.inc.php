<?php

function translate_status($code){

	switch ($code) {

		case 0:
			return '<span class="grey2">registration open</span>';
		break;


		case 1:
			return '<span class="grey2">registration closed</span>';
		break;
		

		case 2:
			return '<span class="green">started</span>';
		break;


		case 3:
			return '<span class="grey1">finished</span>';
		break;
	}
}
?>