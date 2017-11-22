<html>
<?php include 'menu.php';

  if(isset($_GET['hash']))
  {
    $hash = $_GET['hash'];
    $sql = "SELECT * FROM users WHERE hash='".$hash."'";
    $result = $con->query($sql);
    if($result->num_rows > 0) 
    {
      $data = $result->fetch_assoc();
      $email = $data['email'];
      $_POST['email']=$email;
      $sql_update = "UPDATE users SET hash='' WHERE email='".$email."'";
      $con->query($sql_update);
      $can_reset=1;
      $flagForm = 1;
      $success= "Set your new password";
    }
    else
    {
      $flagForm = 0;
      $err= "Email Verification Failed";
    }
  }

  if(isset($_POST['btn_reset'])){
    if(isset($_POST['email']) && $_POST['email'] == "")
    {
        $flagForm = 0;
        $err= "Email harus diisi";
    }
    else
    {
      $email = $_POST['email'];
      $sql = "SELECT * FROM users WHERE email = '".$email."'";
      $result = $con->query($sql);
      if($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $name = $data['name'];

        $milliseconds = microtime(true);
        $seconds = $milliseconds / 1000;
        $remainder = round($seconds - ($seconds >> 0), 3) * 1000;
        $hash =  md5(date("ymdHis").$remainder);
        $sql_update = "UPDATE users SET hash='".$hash."' WHERE email='".$email."'";
        $con->query($sql_update);

        $to = $email;
        $subject = "Reset Password";
        $message = '<head>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
                    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script></head><h4>Hai '.$name.',<br>
                    Untuk melakukan reset password silahkan klik link berikut <a href="http://munafood.com/resetpassword.php?hash='.$hash.'">Reset Password</a>.</h4>';
        $from = 0;
        send_email($to, $subject, $message, $from);

        $flagForm = 1;
        $success = "Please check your email to reset password.";
      }
      else {
        $flagForm = 0;
        $err = "Email not registered";
      }
    }

  }
  else if(isset($_POST['btn_change_pass'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "UPDATE users SET password = '".md5($password)."' WHERE email='".$email."'";

    if(empty($password) || empty($confirm_password)) {
      $flagForm = 0;
      $err = "All field should be filled";
      $can_reset=1;
    }
    else if($password != $confirm_password) {
      $flagForm = 0;
      $err = "Password should be same with confirm password";
      $can_reset=1;
    }
    else if ($con->query($sql) === TRUE) {
      $flagForm = 1;
      $success = "Change password success, please do Login";
    }
    else {
      $flagForm = 0;
      $err = "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
  }
?>
<head>
  <meta property="og:image" itemprop="image" content="image/logo/logo01.jpg"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Reset Password</title>
  <link rel="shortcut icon" type="image/png" href="image/logo/logo01.jpg" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    $(function() {

    $('#login-form-link').click(function(e) {
    $("#login-form").delay(100).fadeIn(100);
    $("#register-form").fadeOut(100);
    $('#register-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
    $("#register-form").delay(100).fadeIn(100);
    $("#login-form").fadeOut(100);
    $('#login-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
    });
    });
  </script>
  <style> 
    #grad4 {
      /*margin-top: 60px;*/
      height: 50px; 
      width: 100%;
      background: red; /* For browsers that do not support gradients */
      background: -webkit-linear-gradient(left, #034f84 , #034f84); /* For Safari 5.1 to 6.0 */
      background: -o-linear-gradient(right, #034f84, #034f84); /* For Opera 11.1 to 12.0 */
      background: -moz-linear-gradient(right, #034f84, #034f84); /* For Firefox 3.6 to 15 */
      background: linear-gradient(to right, #034f84, #034f84); /* Standard syntax */
    }

  </style>
</head>
<body style="z-index: -1;">  
  <div class="container" style="margin-top: 53px;">
    <h3>Reset Password</h3>  
    <?php
      if(isset($flagForm) && $flagForm == 1){
        echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> $success </strong></div>";
      }
      else if(isset($flagForm) && $flagForm == 0){
        echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> Error!</strong> $err </div>";
      }
      if(isset($can_reset) && $can_reset == 1)
      {
        ?>
        <form name="form_resetpassword" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div class='col-xs-12 col-sm-9 col-md-9 col-lg-12'>
          <div class='form-group'>   
            <label class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Nama'>New Password</label>
            <div class='col-xs-12 col-sm-9 col-md-9 col-lg-3'>
              <input type='password' class='form-control' id='password' name='password' value='' autofocus>
            </div>
            <div class='clearfix visible-xs-block'></div>
            <div class='clearfix visible-sm-block'></div>
            <div class='clearfix visible-md-block'></div>
            <div class='clearfix visible-lg-block'></div>
          </div>
          <div class='form-group'>   
            <label class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Nama'>Confirm New Password</label>
            <div class='col-xs-12 col-sm-9 col-md-9 col-lg-3'>
              <input type='password' class='form-control' id='confirm_password' name='confirm_password' value='' autofocus>
            </div>
            <div class='clearfix visible-xs-block'></div>
            <div class='clearfix visible-sm-block'></div>
            <div class='clearfix visible-md-block'></div>
            <div class='clearfix visible-lg-block'></div>
          </div>
            <div class='col-xs-12 col-sm-9 col-md-9 col-lg-12'>  
            <div class='col-xs-12 col-sm-9 col-md-9 col-lg-offset-3 col-lg-3'>   
            <input type="hidden" name="email" value="<?php echo isset($_POST['email'])?$_POST['email']:'';?>">
              <button type="submit" name="btn_change_pass" class="btn btn-success pull-right">
              Change Password<span class="glyphicon glyphicon-send"></span>
              </button>
            </div>
          </div>
        </form>
        </div>
      <?php
      }
      else{
      ?>  
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-offset-3 col-lg-6"> 
      <form id="resetpass-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="">
        <div class="form-group">
          <h4 class="col-xs-12 col-sm-12 col-md-12 col-lg-4">Email</h4>
          <input class="col-xs-12 col-sm-12 col-md-12 col-lg-6" type="email" name="email" id="email" tabindex="1" class="form-control" style="margin-top:5px;" placeholder="Email Address" value="">
          <button type="submit" class="col-xs-12 col-sm-12 col-md-12 col-lg-offset-7 col-lg-3 btn btn-success" style="margin-top:5px;" name="btn_reset">Reset <span class="glyphicon glyphicon-send"></span></button>
        </div>
      </form>
  	</div>
    <?php
    }
    ?>
  </div>
  <?php include 'footer.php'; ?>    
</body>
</html>