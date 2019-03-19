<?php
include("JSON.php");
	
	$list  = array(
			'W:W#Cis#A:A' => array( 'NA' ),
			'W:W#Cis#A:G' => array( 'NA' ),
			'W:W#Cis#A:C' => array( 'Protonated(A)' ),
			'W:W#Cis#A:U' => array( 'NA' ),
			'W:W#Cis#G:G' => array( 'NA' ),
			'W:W#Cis#G:C' => array( 'NA' , 'Protonated(C)' ),
			'W:W#Cis#G:U' => array( 'NA' ),
			'W:W#Cis#C:C' => array( 'Protonated(C)' ),
			'W:W#Cis#C:U' => array( 'NA' , 'Protonated(C)'),
			'W:W#Cis#U:U' => array( 'NA' ),
			
			'W:W#Trans#A:A' => array( 'NA' ),
			'W:W#Trans#A:G' => array( 'NA' ),
			'W:W#Trans#A:C' => array( 'NA' , 'Protonated(A)' , 'Protonated(C)' ),
			'W:W#Trans#A:U' => array( 'NA' ),
			'W:W#Trans#G:G' => array( 'NA' ),
			'W:W#Trans#G:C' => array( 'NA' ),
			'W:W#Trans#G:U' => array( 'NA' ),
			'W:W#Trans#C:C' => array( 'NA' , 'Protonated(C)' ),
			'W:W#Trans#C:U' => array( 'NA' , 'Protonated(C)'),
			'W:W#Trans#U:U(I)' => array( 'NA' ),
			'W:W#Trans#U:U(II)' => array( 'NA' ),
		
			
			'W:H#Cis#A:A' => array( 'NA' ),
			'W:H#Cis#A:G' => array( 'Protonated(A)' ),
			'W:H#Cis#A:C' => array( 'NA' ),
			'W:H#Cis#A:U' => array( 'NA' ),
			'W:H#Cis#G:A' => array( 'NA' ),
			'W:H#Cis#G:G' => array( 'NA' ),
			'W:H#Cis#G:C' => array( 'NA' ),
			'W:H#Cis#G:U' => array( 'NA' ),
			'W:H#Cis#C:A' => array( 'NA' ),
			'W:H#Cis#C:G' => array( 'Protonated(C)' ),
			'W:H#Cis#C:C' => array( 'NA' ),
			'W:H#Cis#C:U' => array( 'NA' ),
			'W:H#Cis#U:A' => array( 'NA' ),
			'W:H#Cis#U:G' => array( 'NA' ),
			'W:H#Cis#U:C' => array( 'NA' ),
			'W:H#Cis#U:U' => array( 'NA' ),
			
			'W:H#Trans#A:A' => array( 'NA' ),
			'W:H#Trans#A:G' => array( 'Protonated(A)' ),
			'W:H#Trans#A:C' => array( 'NA' ),
			'W:H#Trans#A:U' => array( 'NA' ),
			'W:H#Trans#G:A' => array( 'NA' ),
			'W:H#Trans#G:G' => array( 'NA' ),
			'W:H#Trans#G:C' => array( 'NA' ),
			'W:H#Trans#G:U' => array( 'NA' ),
			'W:H#Trans#C:A' => array( 'NA' ),
			'W:H#Trans#C:G' => array( 'Protonated(C)' ),
			'W:H#Trans#C:C' => array( 'NA' ),
			'W:H#Trans#C:U' => array( 'NA' ),
			'W:H#Trans#U:A' => array( 'NA' ),
			'W:H#Trans#U:G' => array( 'NA' ),
			'W:H#Trans#U:C' => array( 'NA' ),
			'W:H#Trans#U:U' => array( 'NA' ),
			
			'H:H#Cis#A:A' => array( 'NA' ),
			'H:H#Cis#A:G' => array( 'NA' ),
			'H:H#Cis#A:C' => array( 'NA' ),
			'H:H#Cis#A:U' => array( 'NA' ),
			'H:H#Cis#G:G' => array( 'NA' ),
			'H:H#Cis#G:C' => array( 'NA' ),
			'H:H#Cis#G:U' => array( 'NA' ),
			'H:H#Cis#C:C' => array( 'NA' ),
			'H:H#Cis#C:U' => array( 'NA' ),
			'H:H#Cis#U:U' => array( 'NA' ),
		
			'H:H#Trans#A:A' => array( 'NA' ),
			'H:H#Trans#A:G' => array( 'NA' ),
			'H:H#Trans#A:C' => array( 'NA' ),
			'H:H#Trans#A:U(I)' => array( 'NA' ),
			'H:H#Trans#A:U(II)' => array( 'NA' ),
			'H:H#Trans#G:G' => array( 'NA' ),
			'H:H#Trans#G:C(I)' => array( 'NA' ),
			'H:H#Trans#G:C(II)' => array( 'NA' ),
			'H:H#Trans#G:U' => array( 'NA' ),
			'H:H#Trans#C:C' => array( 'NA' ),
			'H:H#Trans#C:U' => array( 'NA' ),
			'H:H#Trans#U:U' => array( 'NA' ),
		
			'W:S#Cis#A:rA' => array( 'NA' ),
			'W:S#Cis#A:rG' => array( 'NA' ),
			'W:S#Cis#A:rC' => array( 'NA' ),
			'W:S#Cis#A:rU' => array( 'NA' ),
			'W:S#Cis#G:rA' => array( 'NA' ),
			'W:S#Cis#G:rG' => array( 'NA' ),
			'W:S#Cis#G:rC' => array( 'NA' ),
			'W:S#Cis#G:rU' => array( 'NA' ),
			'W:S#Cis#C:rA' => array( 'NA' ),
			'W:S#Cis#C:rG' => array( 'NA' ),
			'W:S#Cis#C:rC' => array( 'NA' ),
			'W:S#Cis#C:rU' => array( 'NA' ),
			'W:S#Cis#U:rA' => array( 'NA' ),
			'W:S#Cis#U:rG' => array( 'NA' ),
			'W:S#Cis#U:rC' => array( 'NA' ),
			'W:S#Cis#U:rU' => array( 'NA' ),
			
			'W:S#Trans#A:rA' => array( 'NA' ),
			'W:S#Trans#A:rG' => array( 'NA' ),
			'W:S#Trans#A:rC' => array( 'NA' ),
			'W:S#Trans#A:rU' => array( 'NA' ),
			'W:S#Trans#G:rA' => array( 'NA' ),
			'w:S#Trans#G:rG' => array( 'NA' ),
			'W:S#Trans#G:rC' => array( 'NA' ),
			'W:S#Trans#G:rU' => array( 'NA' ),
			'W:S#Trans#C:rA' => array( 'NA' ),
			'W:S#Trans#C:rG' => array( 'NA' ),
			'W:S#Trans#C:rC' => array( 'Protonated(C)' ),
			'W:S#Trans#C:rU' => array( 'Protonated(C)' ),
			'W:S#Trans#U:rA' => array( 'NA' ),
			'W:S#Trans#U:rG' => array( 'NA' ),
			'W:S#Trans#U:rC' => array( 'NA' ),
			'W:S#Trans#u:rU' => array( 'NA' ),
	);
	
	if( $_REQUEST != null ) {		
		$searchKey = $_REQUEST['option'];
		$return_list = array();

		foreach ($list as $key => $value) {
			if( strcmp($key, $searchKey) == 0 ) {
				$tmp = $list[$key];
				foreach ($tmp as $key ) {
					if( $key == 'NA') {
						$key = 'NA';
					}
					$return_list[$key] = $key;
				}
			}
		}
		if(sizeof($return_list) == 0 ) {
			$return_list['none'] = 'NONE';
		}
		echo json_encode($return_list);
		
	}else{
		echo "Error";
	}

?>
