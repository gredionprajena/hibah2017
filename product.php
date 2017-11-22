<html>
<?php include 'menu.php'; ?>
<?php
  $sql = "SELECT * FROM produk order by id";
  $result = $con->query($sql);

  $jmlProd = $jmlErr = array();
  $flagForm = -1;
  $jmlAll = 0;
  $err = "";

  for ($i=0; $i < $result->num_rows; $i++) { 
    $jmlProd[$i] = 0;
    $jmlErr[$i] = "";
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["jmlProd"]) || $_POST["jmlProd"] == "") {
      $err = "Silakan masukkan jumlah produk yang mau dipesan";
      $flagForm = 0;
    }
    else if(isset($_POST["jmlProd"]) && $_POST["jmlProd"] != ""){
      foreach ($_POST['jmlProd'] as $key => $value) {
        $jmlProd[$key] = test_input($value);
        if (!preg_match("/^[0-9]{0,2}$/",$jmlProd[$key])) {
          $err = $jmlErr[$key] = "Hanya angka yang diperbolehkan";
          $flagForm = 0;
        }
      }    
      if(isset($_POST["pesan"]) && $_POST["pesan"] != ""){      
        $kode = test_input($_POST["pesan"]); 
        if($jmlProd[$kode] == 0){
          $jmlErr[$kode] = "Masukkan jumlah lebih dari 0";
        }
        else{
          $jmlAll += $jmlProd[$kode];
          if($jmlProd[$kode] > 0){
            $_SESSION['cart'][$kode+1] = $jmlProd[$kode];
            if(isset($_SESSION['jml'])){ 
              $_SESSION['jml'] = $_SESSION['jml'] + $jmlProd[$kode]; 
            }
            else{
              $_SESSION['jml'] = $jmlProd[$kode];
            }
            header('Location: #');
          }  
        }
      }
    }
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
  <title>Product</title>
  <link rel="shortcut icon" type="image/jpg" href="<?php echo $logo; ?>" />
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
      top: -75;      
      left: 200px; /*position where enlarged image should offset horizontally */
      width: 310px;      
    }
    img {
      background: transparent;
      -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF,endColorstr=#00FFFFFF)"; /* IE8 */   
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF,endColorstr=#00FFFFFF);   /* IE6 & 7 */      
      zoom: 1;    
    }
  </style>
</head>
<body style="z-index: -1;">  
  <div class="container" style="margin-top: 53px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" > 
      <form class="form-horizontal" id="reminder" name="reminder" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="">
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
        <div class="container" id="grad4" style="margin-top: 15px;">        
          <h4 style="color:white;margin-top: 15px;text-align: center;">Produk Kami</h4>          
        </div>
        <?php 
          $jumlah = 1;
          $j = 0;
          while($row = $result->fetch_assoc()) {
        ?>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid gainsboro;padding: 5px;margin-right: 25px;min-height: 310px;">
            <br/>
            <div class="hidden-xs col-sm-5 col-md-5 col-lg-5" style="background-color: none;">
              <?php 
                echo "<a class='thumbnail' href='#thumb'><img class='img-responsive' style='background-color: none;height:200px;margin: auto;left: 0;right: 0;' src='" . $row['image'] . "' alt='produk'><span><img src='" . $row['image'] . "' /><br />" . $row['produk'] . "</span></a>";
              ?>              
            </div>
            <div class="visible-xs col-xs-12">
              <?php 
                echo "<img class='img-responsive' style='background-color: none;height:200px;margin: auto;left: 0;right: 0;' src='" . $row['image'] . "' alt='produk'>";
              ?>        
            </div>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
              <div class="" >
                <h4 class="text-left" style="color: #034f84;"><?php echo "<a href='detailproduct.php?id=" . $row['id'] . "'>" . $row['produk'] . "</a>"; ?></h4>
                <p class="text-left" style="font-size:14px;min-height: 140px"><?php echo $row['deskripsi']; ?><br/></p>
                <p class="text-right" style="font-size:14px;color: #BE1E2D;">Harga <?php echo "Rp " . number_format($row['hargabaru'],0,',','.'); ?>&emsp;&emsp;<br/></p>
              </div>              
            </div>      
            <div class="clearfix visible-xs-block"></div>
            <div class="clearfix visible-sm-block"></div>
            <div class="clearfix visible-md-block"></div>
            <div class="clearfix visible-lg-block"></div>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">      
                <span class="text-danger"><?php echo $jmlErr[$j];?></span>
              </div>   
            </div>            
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
              <label class="control-label col-xs-6 col-sm-4 col-md-6 col-lg-4" for="Jumlah" style="text-align:right;margin-top: 4px;">*Jumlah: </label>
              <div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
                <input style="margin-top: 2px;" type="text" class="form-control" id="jmlProd[]" name="jmlProd[]" value="<?php echo $jmlProd[$j]; ?>" placeholder="0">
              </div>              
              <div class="col-xs-12 col-sm-4 col-md-12 col-lg-4" style="margin-top: 4px;">
                <?php echo "<button type='submit' style='font-size:14px;' class='btn btn-sm btn-info  pull-right' name='pesan' value='$j'><span class='glyphicon glyphicon-shopping-cart'></span> Pesan&nbsp;&nbsp;</button>"; ?>
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