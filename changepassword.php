<html>
<?php include 'menu.php';

  if(isset($_POST['change_submit'])){
    $email = $_SESSION['email'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $confirmnewpassword = $_POST['confirmnewpassword'];


    $milliseconds = microtime(true);
    $seconds = $milliseconds / 1000;
    $remainder = round($seconds - ($seconds >> 0), 3) * 1000;
    $hash =  md5(date("ymdHis").$remainder);
  
    $sql = "UPDATE users SET password = '".md5($newpassword)."' WHERE email = '".$email."'";
    if(empty($oldpassword) || empty($newpassword) || empty($confirmnewpassword)) {
      $flagForm = 0;
      $err = "All field should be filled";
    }
    else if($newpassword != $confirmnewpassword) {
      $flagForm = 0;
      $err = "New password should be same with confirm new password";
    }
    else if ($con->query($sql) === TRUE) {
      $flagForm = 1;
      $success = "Password changed";

      $to = $email;
      $subject = "[munafood.com] Password anda telah berubah";
      $message = '<head>
                  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
                  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script></head><h4>Hai '.$_SESSION['name'].',<br>
                  Kami ingin memberitahu bahwa password anda telah berubah.</h4>';
      $from = 0;
      send_email($to, $subject, $message, $from);
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
  <title>Change Password</title>
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

    .panel-login {
      border-color: #ccc;
      -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,1);
      -moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,1);
      box-shadow: 0px 2px 3px 0px rgba(0,0,0,1);
    }
    .panel-login>.panel-heading {
      color: #00415d;
      background-color: #fff;
      border-color: #fff;
      text-align:center;
    }
    .panel-login>.panel-heading a{
      text-decoration: none;
      color: #666;
      font-weight: bold;
      font-size: 15px;
      -webkit-transition: all 0.1s linear;
      -moz-transition: all 0.1s linear;
      transition: all 0.1s linear;
    }
    .panel-login>.panel-heading a.active{
      color: #029f5b;
      font-size: 18px;
    }
    .panel-login>.panel-heading hr{
      margin-top: 10px;
      margin-bottom: 0px;
      clear: both;
      border: 0;
      height: 1px;
      background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
      background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
      background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
      background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    }
    .panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
      height: 45px;
      border: 1px solid #ddd;
      font-size: 16px;
      -webkit-transition: all 0.1s linear;
      -moz-transition: all 0.1s linear;
      transition: all 0.1s linear;
    }
    .panel-login input:hover,
    .panel-login input:focus {
      outline:none;
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
      border-color: #ccc;
    }
    .btn-login {
      background-color: #59B2E0;
      outline: none;
      color: #fff;
      font-size: 14px;
      height: auto;
      font-weight: normal;
      padding: 14px 0;
      text-transform: uppercase;
      border-color: #59B2E6;
    }
    .btn-login:hover,
    .btn-login:focus {
      color: #fff;
      background-color: #53A3CD;
      border-color: #53A3CD;
    }
    .forgot-password {
      text-decoration: underline;
      color: #888;
    }
    .forgot-password:hover,
    .forgot-password:focus {
      text-decoration: underline;
      color: #666;
    }

    .btn-register {
      background-color: #1CB94E;
      outline: none;
      color: #fff;
      font-size: 14px;
      height: auto;
      font-weight: normal;
      padding: 14px 0;
      text-transform: uppercase;
      border-color: #1CB94A;
    }
    .btn-register:hover,
    .btn-register:focus {
      color: #fff;
      background-color: #1CA347;
      border-color: #1CA347;
    }
  </style>
</head>
<body style="z-index: -1;">  
  <div class="container" style="margin-top: 75px;min-height: 480px;">
  <?php
    if(isset($verif) && $verif != '')
      echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!</strong> $verif </div>";
  ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
      <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
        <div class="panel panel-login">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-12">
                <a href="#" class="active" id="login-form-link">Change Password</a>
              </div>
            </div>
            <hr>
          </div>
          <div class="panel-body">            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php
                if(isset($flagForm) && $flagForm == 1){
                  echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!</strong> $success </div>";
                }
                else if(isset($flagForm) && $flagForm == 0){
                  echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> Error!</strong> $err </div>";
                }             
              ?>
              <form id="changepassword-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" role="form" style="display: block;">
                <div class="form-group">
                  <input type="password" name="oldpassword" id="oldpassword" tabindex="1" class="form-control" placeholder="Old Password">
                </div>
                <div class="form-group">
                  <input type="password" name="newpassword" id="newpassword" tabindex="2" class="form-control" placeholder="New Password">
                </div>
                <div class="form-group">
                  <input type="password" name="confirmnewpassword" id="confirmnewpassword" tabindex="3" class="form-control" placeholder="Confirm New Password">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                      <input type="submit" name="change_submit" id="change_submit" tabindex="4" class="form-control btn btn-login" value="Change Password">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>       
  </div>
  <?php include 'footer.php'; ?>    
</body>
</html>