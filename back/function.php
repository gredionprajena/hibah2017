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
			$mail->SMTPDebug = 3; $mail->SMTPDebug = 1; $mail->isSMTP(); $mail->Host = "mx1.hostinger.co.id"; $mail->SMTPAuth = true;                          
			$mail->Username = $sender; $mail->Password = $password; $mail->SMTPSecure = "tls"; 
			$mail->Port = 587; $mail->From = $sender; $mail->FromName = "munafood"; 
			$mail->addAddress($to , "Recepient Name"); $mail->isHTML(true); $mail->Subject = $subject;
			$mail->Body =  $message;
			 
			$status = $mail->send();
		// }
		if($status){ return "Email berhasil dikirim";  } 
			else { return "Terdapat kesalahan dalam sistem";}
	}

    
?>