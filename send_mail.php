<?php
	//include "connect.php";
	//include "back/function.php";
	$message = file_get_contents('viewsession.php');
	echo $message;

	// if (!file_exists('newname.html')) 
	// { 
	// 	$handle = fopen('newname.html','w+'); 
	// 	fwrite($handle,$message); fclose($handle); 
	// }
	//echo send_email("gprajena@binus.edu", "tes", $message, 0);
?>