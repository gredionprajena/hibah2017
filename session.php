<?php
	//Start our session.
	if (session_status() == PHP_SESSION_NONE) {
      	//session_name("munafood");
	    session_start();
	}
	else{
		session_destroy();
		session_unset();
	}
	 	
	//Expire the session if user is inactive for 30
	//minutes or more.
	$expireAfter = 2 * 60 * 60;
	// $expireAfter = 10 * 60;
	 
	//Check to see if our "last action" session
	//variable has been set.

	if(isset($_SESSION['last_action'])){
	    
	    //Figure out how many seconds have passed
	    //since the user was last active.
	    $secondsInactive = time() - $_SESSION['last_action'];
	    
	    //Convert our minutes into seconds.
	    $expireAfterSeconds = $expireAfter;
	    
	    //Check to see if they have been inactive for too long.
	    if($secondsInactive >= $expireAfterSeconds){
	        //User has been inactive for too long.
	        //Kill their session.
	        session_unset();
	        session_destroy();
	        header('Location: index.php?error=inactive'); // Mengarahkan ke Home Page
	    }	    
	}
	 
	//Assign the current timestamp as the user's
	//latest activity
	$_SESSION['last_action'] = time();
	
	
	// $db = new DB_Connect();
 //  	$fn = new WEB_Functions();  	
	// $con = $db->connect('mobile-app');

	// if ($con->connect_error) {
	// 	die("Connection failed: " . $con->connect_error);
 //    } 
	// // Menyimpan Session
	// $user_check = $fn->test_input($_SESSION['login_user']);	
 //   	$user_check = $con->real_escape_string($user_check);

	// // Ambil data user berdasarkan username karyawan dengan mysql_fetch_assoc
	// if ($result = $con->query("select username from user where username='$user_check'")) {
	//     /* fetch associative array */
	// 	$row = $result->fetch_assoc();		
	// }
 
	// $login_session = $row['username'];
	// if(!isset($login_session)){	
	// 	$con->close();
	// 	session_unset();
	// 	session_destroy();		
	// 	$error = "session" . $user_check;
	//     header('Location: index.php?error=' . $error); // Mengarahkan ke Home Page
	// }
	// else{		
	// 	$login_pass = $_SESSION['password'];
	// 	$login_hp = $_SESSION['login_hp'];
	// 	$login_tag = $_SESSION['login_tag'];
	// 	$login_type = $_SESSION['login_type'];
	// }
?>