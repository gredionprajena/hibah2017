<html>
<?php include 'menu.php'; ?>

<head>
  <meta property="og:image" itemprop="image" content="<?php echo $logo; ?>"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Profil Perusahaan</title>
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
  <div class="container" style="margin-top: 70px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <form class="form-horizontal" id="reminder" name="reminder" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "#reminder"; ?>" style="min-height: 460px;">       
        <div class="container" id="grad4">        
          <h4 style="color:white;margin-top: 15px;text-align: center;">Sejarah Perusahaan</h4>          
        </div>
        <div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-10 col-lg-10" style="min-height: 350px;">   
          <br/>
          <p style="margin-left: 15px;"><b>CV. Munafood</b></p>            
          <?php
            $sql = "SELECT * FROM sejarah order by urutan";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {            
              $i=0;
              while($row = $result->fetch_assoc()) {
                echo "<p style='margin-left: 30px;'>" . $row['sejarah'] . "</p>";              
              }
            }
          ?>
          <br/>          
        </div>
        <div class="clearfix visible-xs-block"></div>
        <div class="clearfix visible-sm-block"></div>
        <div class="clearfix visible-md-block"></div>
        <div class="clearfix visible-lg-block"></div>
        <div class="container" id="grad4">        
          <h4 style="color:white;margin-top: 15px;text-align: center;">Visi dan Misi</h4>          
        </div>
        <div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-10 col-lg-10" style="min-height: 300px;">  
          <br/>
          <p style="margin-left: 15px;"><b>Visi :</b></p>
          <p style="margin-left: 30px;"><?php echo $visi; ?></p>
          <br/>
          <p style="margin-left: 15px;"><b>Misi :</b></p>
          <ul style="margin-left: 15px;">          
          <?php
            $sql = "SELECT * FROM misi order by urutan";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {            
              $i=0;
              while($row = $result->fetch_assoc()) {
                echo "<li>" . $row['misi'] . "</li>";              
              }
            }
          ?>          
          </ul>
          <br/>
        </div>
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