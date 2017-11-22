<html>
<?php include 'menu.php'; ?>
<head>
  <meta property="og:image" itemprop="image" content="image/logo/logo01.jpg"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Home</title>
  <link rel="shortcut icon" type="image/png" href="image/logo/logo01.jpg" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
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
  <?php include 'carousel.php'; ?>
  <div class="container" style="margin-top: 53px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <form class="form-horizontal" id="reminder" name="reminder" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="min-height: 400px;"> 
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-5 col-md-4 col-lg-offset-1 col-lg-3 well" style="height: 600px;">
                <div class="well-sm">
                  <form id="loginForm" method="POST">
                    <div class="form-group">
                      <h2><span class="label label-default" style="background-color:#204d74">Login</span></h2>
                    </div>
                    <div class="form-group">
                      <label for="email" class="control-label">Email</label>
                      <input type="text" class="form-control" name="email" value="" required="" title="Please enter your email" placeholder="email">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                      <label for="password" class="control-label">Password</label>
                      <input type="password" class="form-control" name="password" placeholder="password" value="" required="" title="Please enter your password">
                      <span class="help-block"></span>
                    </div>
                    <div id="loginErrorMsg" class="alert alert-error hide">Wrong email or password</div>
                    <div class="checkbox">
                      <label>
                          <input type="checkbox" name="remember" id="remember"> Remember login
                      </label>
                    </div>
                    <button type="submit" value="login" name="submit" class="btn btn-primary btn-block">Login</button>
                  </form>
                </div>
              </div>
              <div class="visible-xs col-xs-12" style="height: 10px;">
                <p> </p>
              </div>              
              <div class="hidden-xs col-sm-2 col-md-1 col-lg-1" style="height: 600px;">
                <p></p>
              </div>
              <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3 well" style="height: 600px;">
                <div class="well-sm">
                  <form id="loginForm" method="POST">
                    <div class="form-group">
                      <h2><span class="label label-default" style="background-color:#398439">Register</span></h2>
                    </div>
                    <div class="form-group">
                      <label for="email" class="control-label">Email</label>
                      <input type="text" class="form-control" name="email" value="" required="" title="Please enter your email" placeholder="email">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                      <label for="name" class="control-label">Name</label>
                      <input type="text" class="form-control" name="name" value="" required="" title="Please enter your name" placeholder="name">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                      <label for="address" class="control-label">Address</label>
                      <textarea type="text" class="form-control" name="address" value="" required="" title="Please enter your address" placeholder="address"></textarea>
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                      <label for="password" class="control-label">Password</label>
                      <input type="password" class="form-control" name="password" placeholder="password" value="" required="" title="Please enter your password">
                      <span class="help-block"></span>
                    </div>
                     <div class="form-group">
                      <label for="confirm_password" class="control-label">Confirm Password</label>
                      <input type="password" class="form-control" name="confirm_password" placeholder="confirm password" value="" required="" title="Please enter your confirm password">
                      <span class="help-block"></span>
                    </div>
                    <div id="loginErrorMsg" class="alert alert-error hide">Wrong email or password</div>
                    <button type="submit" value="Register" name="register" class="btn btn-success btn-block">Register</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>      
    <?php include 'footer2.php'; ?>    
  </div>
  <?php include 'footer.php'; ?>    
</body>
</html>