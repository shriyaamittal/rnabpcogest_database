<?php
include("JSON.php");
	
	$list  = array(
			'default' => 'Select BP Type',
			'W:W' => 'W:W',
			'W:H' => 'W:H',
			'W:S' => 'W:S',
			'H:H' => 'H:H',
			'H:W' => 'H:W',
			'H:S' => 'H:S',
			'S:S' => 'S:S',
			'S:H' => 'S:H',
			'S:W' => 'S:W',
			 );

	if( $_REQUEST != null ) {		
		echo json_encode($list);
	}else{
		echo "Error";
	}
?>
