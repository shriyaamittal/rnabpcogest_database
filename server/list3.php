<?php
include("JSON.php");
	
	$list  = array(

		'W:W#Cis'  => array(
				'default' => 'Select BP Name',
				'A:A' => 'A:A',
				'A:G' => 'A:G',
				'A:C' => 'A:C',
				'A:U' => 'A:U',
				'G:C' => 'G:C',
				'G:U' => 'G:U',
				'C:C' => 'C:C',
				'C:U' => 'C:U',
				'U:U' => 'U:U',
				 ),

		'W:W#Trans'  => array(
				'default' => 'Select BP Name',
				'A:A' => 'A:A',
				'A:G' => 'A:G',
				'A:C' => 'A:C',
				'A:U' => 'A:U',
				'G:G' => 'G:G',
				'G:C' => 'G:C',
				'G:U' => 'G:U',
				'C:C' => 'C:C',
				'C:U' => 'C:U',
				'U:U(I)' => 'U:U(I)',
				'U:U(II)' => 'U:U(II)',
				 ),
		'W:H#Cis' => array(
				'default' => 'Select BP Name',
				'A:A' => 'A:A',
				'A:G' => 'A:G',
				'A:C' => 'A:C',
				'A:U' => 'A:U',
				'G:A' => 'G:A',
				'G:G' => 'G:G',
				'G:C' => 'G:C',
				'G:U' => 'G:U',
				'C:A' => 'C:A',
				'C:G' => 'C:G',
				'C:C' => 'C:C',
				'C:U' => 'C:U',
				'U:A' => 'U:A',
				'U:G' => 'U:G',
				'U:C' => 'U:C',
				'U:U' => 'U:U',
				),

		'W:H#Trans' => array(
				'default' => 'Select BP Name',
				'A:A' => 'A:A',
				'A:G' => 'A:G',
				'A:C' => 'A:C',
				'A:U' => 'A:U',
				'G:A' => 'G:A',
				'G:G' => 'G:G',
				'G:C' => 'G:C',
				'G:U' => 'G:U',
				'C:A' => 'C:A',
				'C:G' => 'C:G',
				'C:C' => 'C:C',
				'C:U' => 'C:U',
				'U:A' => 'U:A',
				'U:G' => 'U:G',
				'U:C' => 'U:C',
				'U:U' => 'U:U',
				),

		'W:S#Cis' => array(
				'default' => 'Select BP Name',
				'A:rA' => 'A:rA',
				'A:rG' => 'A:rG',
				'A:rC' => 'A:rC',
				'A:rU' => 'A:rU',
				'G:rA' => 'G:rA',
				'G:rG' => 'G:rG',
				'G:rC' => 'G:rC',
				'G:rU' => 'G:rU',
				'C:rA' => 'C:rA',
				'C:rG' => 'C:rG',
				'C:rC' => 'C:rC',
				'C:rU' => 'C:rU',
				'U:rA' => 'U:rA',
				'U:rG' => 'U:rG',
				'U:rC' => 'U:rC',
				'U:rU' => 'U:rU',
				),

		'W:S#Trans' => array(
				'default' => 'Select BP Name',
				'A:rA' => 'A:rA',
				'A:rG' => 'A:rG',
				'A:rC' => 'A:rC',
				'A:rU' => 'A:rU',
				'G:rA' => 'G:rA',
				'G:rG' => 'G:rG',
				'G:rC' => 'G:rC',
				'G:rU' => 'G:rU',
				'C:rA' => 'C:rA',
				'C:rG' => 'C:rG',
				'C:rC' => 'C:rC',
				'C:rU' => 'C:rU',
				'U:rA' => 'U:rA',
				'U:rG' => 'U:rG',
				'U:rC' => 'U:rC',
				'U:rU' => 'U:rU',
				),

		'H:H#Cis' => array(
				'default' => 'Select BP Name',
				'A:A' => 'A:A',
				'A:G' => 'A:G',
				'A:C' => 'A:C',
				'A:U' => 'A:U',
				'G:G' => 'G:G',
				'G:C' => 'G:C',
				'G:U' => 'G:U',
				'C:C' => 'C:C',
				'C:U' => 'C:U',
				'U:U' => 'U:U',
				),

		'H:H#Trans' => array(
				'default' => 'Select BP Name',
				'A:A' => 'A:A',
				'A:G' => 'A:G',
				'A:C' => 'A:C',
				'A:U(I)' => 'A:U(I)',
				'A:U(II)' => 'A:U(II)',
				'G:G' => 'G:G',
				'G:C(I)' => 'G:C(I)',
				'G:C(II)' => 'G:C(II)',
				'G:U' => 'G:U',
				'C:C' => 'C:C',
				'C:U' => 'C:U',
				'U:U' => 'U:U',
				),

	);
	
	if( $_REQUEST != null ) {		
		$key = $_REQUEST['option'];
		if ( array_key_exists($key, $list) ) {
			echo json_encode($list[$key]);	
		} else {
			echo  json_encode(array('none' => 'NONE' ));
		}

		
	}else{
		echo "Error";
	}

?>
