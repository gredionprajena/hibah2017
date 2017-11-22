<html>
<?php
  include 'menu.php';
  $jmlProd = $jmlErr = $err = "";
  $flagForm = -1;


  if (isset($_GET["id"]) && $_GET["id"] != "") {
    $id = test_input($_GET["id"]);
    $sql = "SELECT * FROM produk where id = '$id' order by id";
    $result = $con->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if(isset($_POST["pesan"]) && $_POST["pesan"] != ""){     
        if (!isset($_POST["jmlProd"]) || $_POST["jmlProd"] == "") {
          $err = "Silakan masukkan jumlah produk yang mau dipesan";
          $flagForm = 0;
        }
        else {
          $jmlProd = test_input($_POST["jmlProd"]);
          if (!preg_match("/^[0-9]{0,2}$/",$jmlProd)) {
            $err = "Hanya angka yang diperbolehkan";
            $flagForm = 0;
          }
        }  

        if($jmlProd > 0){
          $_SESSION['cart'][$id] = $jmlProd;
          if(isset($_SESSION['jml'])){ 
            $_SESSION['jml'] = $_SESSION['jml'] + $jmlProd; 
          }
          else{
            $_SESSION['jml'] = $jmlProd;
          }
          header('Location: cart.php');
        }    
      }
    }
  }
  else{
    $err = "Produk tidak ditemukan";
  }
?>

<head>
  <meta property="og:image" itemprop="image" content="<?php echo $logo; ?>"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Product Detail</title>
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
  </style>
</head>
<body style="z-index: -1;">  
  <div class="container" style="margin-top: 53px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" > 
      <form class="form-horizontal" id="reminder" name="reminder" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id"; ?>" style="">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
          <?php
            if($flagForm == 1){
              echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!</strong> $success </div>";
            }
            else if($flagForm == 0){
              echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> Error!</strong> $err </div>";
            }             
          ?>        
        </div>        
        <div class="clearfix visible-xs-block"></div>
        <div class="clearfix visible-sm-block"></div>
        <div class="clearfix visible-md-block"></div>
        <div class="clearfix visible-lg-block"></div>
        <?php 
          $jumlah = 1;
          $j = 0;
          while($row = $result->fetch_assoc()) {
        ?>
        <div class="container hidden-xs" id="grad4">        
          <h4 style="color:white;margin-top: 15px;text-align: center;">Detail Produk - <?php echo $row['produk']; ?> </h4>               
        </div>
        <div class="container visible-xs" id="grad4" style="height: 80px;">        
          <h4 style="color:white;margin-top: 15px;text-align: center;">Detail Produk <br/><br/> <?php echo $row['produk']; ?> </h4>               
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid gainsboro;padding: 3px;margin-right: 25px;">
            <br/>
            <div class="hidden-xs col-sm-6 col-md-5 col-lg-5">
              <?php 
                echo "<img class='img-responsive' style='height:500px;margin: auto;left: 0;right: 0;' src='" . $row['image'] . "' alt='produk'>";
              ?>              
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                <br/><br/>
                <span class="text-danger"><?php echo $jmlErr;?></span>
              </div>    
            </div>
            <div class="visible-xs col-xs-12">
              <?php 
                echo "<img class='img-responsive' style='height:300px;margin: auto;left: 0;right: 0;' src='" . $row['image'] . "' alt='produk'>";
              ?>              
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                <br/><br/>
                <span class="text-danger"><?php echo $jmlErr;?></span>
              </div>    
            </div>
            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
              <div class="caption" style="">
                <h2 class="text-right" style="font-size:20px;color: #BE1E2D;">Harga <?php echo "Rp " . number_format($row['hargabaru'],0,',','.'); ?><hr/></h2>
                <p class="text-left" style="font-size:14px;min-height: 300px"><?php echo $row['deskripsi']; ?><br/></p>
              </div>
              <hr/>
              <label class="control-label col-xs-6 col-sm-8 col-md-8 col-lg-8" for="Jumlah" style="text-align:right;margin-top: 5px;">*Jumlah: </label>
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                <input type="tel" class="form-control" id="jmlProd" name="jmlProd" value="<?php echo $jmlProd; ?>" placeholder="0">
              </div>              
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 5px;">
                <?php echo "<button type='submit' style='font-size:14px;' class='btn btn-sm btn-info  pull-right' name='pesan' value='$j'><span class='glyphicon glyphicon-shopping-cart'></span> Pesan&nbsp;&nbsp;</button>&emsp;"; ?>
              </div>          
            </div>
          </div>
        </div>        
        <?php 
            $jumlah++;
            $j++;
          }         
        ?>
        <div class="clearfix visible-xs-block"></div>
        <div class="clearfix visible-sm-block"></div>
        <div class="clearfix visible-md-block"></div>
        <div class="clearfix visible-lg-block"></div>
        <div class="container" id="grad4" style="height: 30px;">        
          <h4 style="color:white;margin-top: 15px;text-align: center;"><?php echo " "; ?></h4>          
        </div>
      </form> 
    </div>      
  </div>
  <?php include 'footer.php'; ?>    
</body>
</html>