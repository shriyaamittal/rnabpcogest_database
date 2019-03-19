<?php
include("JSON.php");
	
	$list  = array(
				'default' => 'Select glyc bond',
				'Cis' => 'Cis',
				'Trans' => 'Trans',
				 );
	if( $_REQUEST != null ) {		
		echo json_encode($list);
	}else{
		echo "Error";
	}

?>
