<?php
 
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function GenerateThumbnail($im_filename,$th_filename,$max_width,$max_height,$quality = 0.75){
    // The original image must exist
	    if(is_file($im_filename)){
	        // Let's create the directory if needed
	        $th_path = dirname($th_filename);
	        if(!is_dir($th_path))mkdir($th_path, 0777, true);
	        // If the thumb does not aleady exists
	        if(!is_file($th_filename)){
	            // Get Image size info
	            list($width_orig, $height_orig, $image_type) = @getimagesize($im_filename);
	            if(!$width_orig)return 2;
	            switch($image_type){
	                case 1: $src_im = @imagecreatefromgif($im_filename);    break;
	                case 2: $src_im = @imagecreatefromjpeg($im_filename);   break;
	                case 3: $src_im = @imagecreatefrompng($im_filename);    break;
	            }
	            if(!$src_im)return 3;

	            $aspect_ratio = (float) $height_orig / $width_orig;

	            $thumb_height = $max_height;
	            $thumb_width = round($thumb_height / $aspect_ratio);
	            if($thumb_width > $max_width)
	            {
	                $thumb_width    = $max_width;
	                $thumb_height   = round($thumb_width * $aspect_ratio);
	            }

	            $width = $thumb_width;
	            $height = $thumb_height;

	            $dst_img = @imagecreatetruecolor($width, $height);
	            if(!$dst_img)return 4;
	            $success = @imagecopyresampled($dst_img,$src_im,0,0,0,0,$width,$height,$width_orig,$height_orig);
	            if(!$success)return 4;
	            switch ($image_type) {
	                case 1: $success = @imagegif($dst_img,$th_filename); break;
	                case 2: $success = @imagejpeg($dst_img,$th_filename,intval($quality*100));  break;
	                case 3: $success = @imagepng($dst_img,$th_filename,intval($quality*9)); break;
	            }
	            if(!$success)return 4;
	        }
	        return 0;
	    }
	    return 1;
    }

	function cek_error($int){
		$phpFileUploadErrors = array(
		  0 => 'There is no error, the file uploaded with success',
		  1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		  2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		  3 => 'The uploaded file was only partially uploaded',
		  4 => 'No file was uploaded',
		  6 => 'Missing a temporary folder',
		  7 => 'Failed to write file to disk.',
		  8 => 'A PHP extension stopped the file upload.',
		);
		foreach ($phpFileUploadErrors as $key => $value) {
		  if($int == $key) return $value;
		} 
	}

	function create_body($message){
  		// include '../connect.php';
		$db = new DB_Connect();
		$con = $db->connect();

		$sql = "SELECT * FROM ukm where id = '1'";  
		$result = $con->query($sql);

		if(isset($_SESSION['jml'])) $jml = $_SESSION['jml'];
		else {$jml = 0;}

		if($result->num_rows > 0 ){
			$row = $result->fetch_assoc();
			$name = $row['name'];
			$alamat = $row['alamat'];
			$logo = $row['logo'];
			$hdcolor = $row['headercolor'];
			$ftcolor = $row['footercolor'];
			$tghcolor = $row['contentcolor'];
			$visi = $row['visi'];
		}  
		$header = "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>";
		$header .= "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css'>";
		$header .= "<script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>";
		$header .= "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>";
		//http://munafood.com/image/01/logo/logo01.jpg

		$atas = "<p style='font-size: 20px;'><br/>". $name . " <br/></p>";	
	    $atas .= "<p><hr/></p>";
		$atas .= "<br/><br/>";

		$bawah = "<br/><br/><br/>";
		$bawah .= "<p><hr/></p>";
		$bawah .= "<table><tr>";		
		$bawah .= "<td style='width:15%;text-align:center;'><img style='width:70%;' src='http://munafood.com/image/01/logo/logo01.jpg'></td>";  
	    $bawah .= "<td style='width:25%;text-align:left;'><p style='font-size: 14px;'>". $name . " <br/>" . $alamat . "</p></td>";
	    $bawah .= "<td style='width:25%;text-align:left;'>";
	    $bawah .= "<p style='font-size: 14px;'> <a target='blank' href='https://www.facebook.com/profile.php?id=100011417305407'>";
	    $bawah .= "<img style='width:10%;' src='http://munafood.com/image/fb3.png'> Tempe Cokelat PeChoc</a><br/></p>";
	    $bawah .= "<p style='font-size: 14px;'><a target='blank' href='https://www.instagram.com/pechoc_enakunik/'>";
	    $bawah .= "<img style='width:10%;' src='http://munafood.com/image/IG.jpg'> PeChoc enak_unik</a><br/></p>";
	    $bawah .= "<p style='font-size: 14px;'>";
	    $bawah .= "<img style='width:10%;' src='http://munafood.com/image/wa.png'> 0812-1822-6469<br/></p>";	      
	    $bawah .= "</td>";
	    $bawah .= "<td style='width:35%;text-align:center;'></td>";  
	    $bawah .= "</tr></table>";

	    return $header . $atas . $message . $bawah;
	}

	function send_email($to, $subject, $message, $from){
		$env = new DB_Connect();

		if($from == 0){$sender = 'no-reply@munafood.com';}
		else if($from == 1){$sender = 'admin@munafood.com';}
		$password = "mun4f00d";

		// if($env->system_env() == "Production")
		// {
		// 	ini_set( 'display_errors', 1 );
		//     $headers = "From:" . $sender;	 
		// 	$status = mail($to, $subject, $message, $headers);
		 
		// }
		// else if($env->system_env() == "Development")
		// {
			require("lib/PHPMailer/PHPMailerAutoload.php");
			require("lib/PHPMailer/class.phpmailer.php");
			require("lib/PHPMailer/class.smtp.php");
			$mail = new PHPMailer;
			$mail->SMTPDebug = 3; 
			$mail->SMTPDebug = 1; 
			$mail->isSMTP(); 
			$mail->Host = "mx1.hostinger.co.id"; 
			$mail->SMTPAuth = true;                          
			$mail->Username = $sender; 
			$mail->Password = $password; 
			$mail->SMTPSecure = "tls"; 
			$mail->Port = 587; 
			$mail->From = $sender; 
			$mail->FromName = "munafood"; 
			$mail->addAddress($to , "Recepient Name"); 
			$mail->isHTML(true); 
			$mail->Subject = $subject;
			$mail->Body =  create_body($message);
			 
			$status = $mail->send();
		// }
		if($status){ return "Email berhasil dikirim";  } 
			else { return "Terdapat kesalahan dalam sistem";}
	}

    
?>