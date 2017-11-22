<?php
// 
  // require("../lib/PHPMailer/PHPMailerAutoload.php");
  // require("../lib/PHPMailer/class.phpmailer.php");
  // require("../lib/PHPMailer/class.smtp.php");
  // $mail = new PHPMailer;
  // $mail->SMTPDebug = 3; $mail->SMTPDebug = 1; $mail->isSMTP(); $mail->Host = "smtp.gmail.com"; $mail->SMTPAuth = true;                          
  // $mail->Username = "gredionprajena@gmail.com"; $mail->Password = "gr3d10npr4j3n4"; $mail->SMTPSecure = "tls"; 
  // $mail->Port = 587; $mail->From = "gredionprajena@gmail.com"; $mail->FromName = "noreply"; 
  // $mail->addAddress("gprajena@binus.edu" , "Recepient Name"); $mail->isHTML(true); $mail->Subject = "Email verification";
  // $mail->Body =  "halo1<br>http://localhost/hibahibm/Munafood/emailverif.php?email=".$email."&hash=".$hash;
   
  // if(!$mail->send()) {
  //     echo "Mailer Error: " . $mail->ErrorInfo;
  // } 
  // else{
  //     echo "Mail Sent Successfully";
  // }

?>
<html>
<head>
  <meta property="og:image" itemprop="image" content="<?php echo $logo; ?>"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Index</title>
  <link rel="shortcut icon" type="image/jpg" href="image/logo/logo01.j<?php echo $logo; ?>" />
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

    .thumbnail{
      position: relative;
      z-index: 0;
    }

    .thumbnail:hover{
      background-color: transparent;
      z-index: 50;
    }

    .thumbnail span{
      position: absolute;
      background-color: white;
      padding: 5px;
      border: 1px dashed gray;
      visibility: hidden;
      color: black;
      text-decoration: none;            
    }

    .thumbnail span img{ 
      border-width: 0;
      padding: 2px;
      width: 300px;
    }

    .thumbnail:hover span{ /*CSS for enlarged image on hover*/
      text-align: center;
      visibility: visible;
      top: 200px;      
      left: -55px; /*position where enlarged image should offset horizontally */
      width: 310px;      
    }
  </style>
</head>
<body style="z-index: -1;">  
  <div class="container" style="margin-top: 53px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <?php
        include 'connect.php';
        $db = new DB_Connect();
        $con = $db->connect('ukm');

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
        $con->close();
      ?>
      <style type="text/css">
        /* unvisited link */
        a.linkmenu {color:white;}
        a.linkmenu:link  {text-decoration: none; color: white;}
        a.linkmenu:visited {text-decoration: none; color: white;}
        a.linkmenu:hover {text-decoration: underline; color: black;}
        a.linkmenu:active {text-decoration: none; color: black;}

        a.linksubmenu {color:black;}
        a.linksubmenu:link  {text-decoration: none; color: black;}
        a.linksubmenu:visited {text-decoration: none; color: black;}
        a.linksubmenu:hover {text-decoration: underline; color: blue;}
        a.linksubmenu:active {text-decoration: none; color: blue;}
      </style>

      <div class="container" style="color: white;font-size: 16px;">
        <nav role="navigation" class="navbar navbar-fixed-top">
          <div >
            <div class="navbar-header" style="background-color: <?php echo $hdcolor; ?>;">
              <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="pull-left navbar-toggle">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
                <span> <?php echo $name; ?></span>
              </button>
                
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse" style="background-color: <?php echo $hdcolor; ?>;">
              <?php     
                echo "<ul class='nav navbar-nav'>";
                echo "<li><a class='linkmenu hidden-xs' href='index.php' style='border-right:1px solid grey;margin-right:50px;'>CV Munafood</a></li>";    
                echo "<li><a class='linkmenu' href='product.php'>Produk</a></li>";           
                echo "<li><a class='linkmenu' href='sejarah.php'>Sejarah</a></li>";       
                echo "<li><a class='linkmenu' href='visimisi.php'>Visi Misi</a></li>";           
                echo "</ul>";
              ?>
              <ul class="nav navbar-nav navbar-right" style="margin-right: 50px;"> 
                <?php          
                  echo "<li ><a class='linkmenu' href='cart.php'><span class='glyphicon glyphicon-shopping-cart'></span> Keranjang <span class='badge' style='font-size: 15px;'>$jml</span></a></li>";        
                  if(isset($_SESSION['email'])){
                    echo "<li><a class='linkmenu' href='logout.php' >Logout</a></li>";
                  }
                  else
                    echo "<li><a class='linkmenu' href='login.php' >Login / Daftar</a></li>";
                ?>
                <!-- <li class="dropdown">
                  <a class="linkmenu hidden-xs" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> a <span class="caret"></span></a>
                  <ul role="menu" class="dropdown-menu">              
                    <li><a class="linksubmenu hidden-xs" href="changePassword.php?change">Ganti Password</a></li>
                    <li class="divider hidden-xs"></li>
                    <li><a class="linksubmenu hidden-xs" href="dologout.php">Logout</a></li>
                  </ul>
                </li> -->
              </ul>
            </div>                  
          </div>
        </nav>
      </div>
    </div>
        <div class="container">    
        <h3>Email Verification</h3>    
            <?php
              if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_REQUEST['email']) && isset($_REQUEST['hash'])) {
                require_once('connect.php');
                $db = new DB_Connect();
                $con = $db->connect('ukm');

                $email = $_REQUEST['email'];
                $hash = $_REQUEST['hash'];
                $query = "SELECT * FROM user01 WHERE email='".$email."' AND hash='".$hash."'";
                $result = $con->query($sql);
                if($result->num_rows >= 1) {
                  $query = "UPDATE users01 SET status = 'active' WHERE email='".$email."' AND hash='".$hash."'";
                  if($con->query($query) === TRUE) {
                    $flagForm = 1;
                    $success = "Congratulations, ".$email." !!! Your account has been activated";
                  }
                  else {
                    $flagForm = 0;
                    $err = "Error occured when activate your account";
                  }
                }
                else {
                  $flagForm = 0;
                  $err = "wrong link!";
                }
              }
            ?>
            <div>
            <?php
                if(isset($flagForm) && $flagForm == 1){
                  echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!</strong> $success </div>";
                }
                else if(isset($flagForm) && $flagForm == 0){
                  echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> Error!</strong> $err </div>";
                }             
              ?>
            <form class="form-horizontal" id="reminder" name="reminder" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            Email <input type="text" name="emailverif" placeholder="your email"> <input type="submit" value="Verify">
            </div>
        </div>
      </form>  
    </div>   
  </div> 
  <?php include 'footer.php'; ?>   
</body>
</html>