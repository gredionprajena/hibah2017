<html>
<?php
  include 'menu.php';

  $sql = "SELECT * FROM produk order by id";
  $result = $con->query($sql);

  $jmlProd = $jmlErr = array();
  $flagForm = -1;

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
        echo $kode;
        if($jmlProd[$kode] == 0){
          $err = $jmlErr[$kode] = "Masukkan jumlah lebih dari 0";
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
  <title>Index</title>
  <link rel="shortcut icon" type="image/jpg" href="image/01/logo/logo01.jpg" />
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
  <div class="container hidden-xs" style="background-color:#404040;margin-top: 53px;margin-bottom: 10px;">
    <!-- <div class="col-xs-12 col-sm-12 col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-10"> -->
      <div id="myCarousel" class="carousel slide" data-ride="carousel" style="background-color: #585858;">
          <ol class="carousel-indicators">
            <?php
              for ($i=0; $i < $result->num_rows; $i++) { 
                if($i == 0) {echo "<li data-target='#myCarousel' data-slide-to='$i' class='active'></li>";}
                else {echo "<li data-target='#myCarousel' data-slide-to='$i'></li>";}
              }
            ?>
          </ol>   
          <div class="carousel-inner">
            <?php
              $j = 0;
              while($row = $result->fetch_assoc()) {                
                if($j == 0){ echo "<div class='item active'>";}
                else {echo "<div class='item'>";}
            ?>
                <div class="container" style="background-color: #585858;width:100%;padding:30px;padding-bottom: 60px;">
                <?php echo "<a href='detailproduct.php?id=" . $row['id'] . "'>"; ?>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: white;">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-offset-2 col-lg-4" >
                      <?php 
                        echo "<img class='img-responsive' style='margin: auto;left:0;right: 0;' src='" . $row['image'] . "' alt='produk'>";
                      ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
                      <div class="caption" >
                        <h4 class="text-left" style="font-size:20px;color: #034f84;margin-top: 50px;">
                          <?php echo $row['produk']; ?></h4>
                        <p class="text-right" style="font-size:18px;color: #BE1E2D;">Harga <?php echo "Rp " . number_format($row['hargabaru'],0,',','.'); ?><br/><hr/></p>
                        <p class="text-left" style="font-size:14px;color: #BE1E2D;"><?php echo $row['deskripsi']; ?><br/></p>
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-1 col-md-2 col-lg-2">
                      <p></p>
                    </div>
                  </div>
                <?php echo "</a>"; ?>
                </div>              
                
              </div>  
            <?php
                $j++;
              }
            ?>
          </div>
          <a class="carousel-control left" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
          </a>
          <a class="carousel-control right" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
          </a>
      </div>         
    <!-- </div>  -->
  </div>
  <hr/>
  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <form class="form-horizontal" id="reminder" name="reminder" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "#reminder"; ?>" >
        <div class="container" id="grad4" style="margin-top: 25px;">        
          <h4 style="color:white;margin-top: 15px;text-align: center;">Produk Favorit</h4>          
        </div>
         <?php
          $sql = "SELECT * FROM produk order by id";
          $result = $con->query($sql); 
          $jumlah = 1;
          $j = 0;
          while($row = $result->fetch_assoc()) {
        ?>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid gainsboro;">
            <br/>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php 
                echo "<a class='thumbnail' href='#thumb'><img class='img-responsive' style='height:200px;margin: auto;left: 0;right: 0;' src='" . $row['image'] . "' alt='produk'><span>" . $row['produk'] . "<br /><img src='" . $row['image'] . "' /></span></a>";
              ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="caption" >
                <h4 class="text-center" style="font-size:12px;color: #034f84;"><?php echo "<a href='detailproduct.php?id=" . $row['id'] . "'>" . $row['produk'] . "</a>"; ?></h4>
                <p class="text-center" style="font-size:12px;color: #BE1E2D;">Harga <?php echo "Rp " . number_format($row['hargabaru'],0,',','.'); ?><br/></p>
              </div>
            </div>
          </div>
        </div>        
        <?php 
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