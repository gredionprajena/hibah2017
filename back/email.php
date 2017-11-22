<html>
<?php include 'menu.php'; ?>
<?php
  $flagForm = -1;
  $err = $recipientErr = $messageErr = $subjectErr = $hargabaruErr = $image_productErr = $hargaErr = "";
  $harga = $recipient = $message = $subject = "";
  $uploadImgOk = 1;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    if((isset($_POST["sendEmail"]) && $_POST["sendEmail"] != "") || (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "") || (isset($_POST["confirm"]) && $_POST["confirm"] != "")) {      
      $flagForm = 1;
      if (!isset($_POST["recipient"]) || $_POST["recipient"] == "") {
        $err = $recipientErr = "Silakan tulis recipient yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $recipient = addslashes($_POST["recipient"]); 
      }
      if (!isset($_POST["subject"]) || $_POST["subject"] == "") {
        $err = $subjectErr = "Silakan tulis subject yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $subject = addslashes($_POST["subject"]); 
      }

      if (!isset($_POST["message"]) || $_POST["message"] == "") {
        $err = $editSejarahErr = "Silakan tulis message yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $message = addslashes($_POST["message"]);         
      }
      
      // if($flagForm == 1 && (isset($_POST["sendEmail"]) && $_POST["sendEmail"] != "")){ 
      //   $tgl = date('Y-m-d H:i:s');          
      //   $sql2 = "insert into recipient(recipient, message, image, insert_at) values ('$recipient', '$message', '$filenameImg', '$tgl')";
      //   $result2 = $con->query($sql2);
      //   $success = "Berhasil tambah Toko";

      //   $tambahToko = $_POST["tambahToko"] = "cancel";
      //   // echo "$sql2";  
      // }
      // else if($flagForm == 1 && (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "")){ 
      //   $tgl = date('Y-m-d H:i:s');
      //   $kodeToko = test_input($_POST["saveTiket"]);     
      //   if($filenameImg != ""){
      //     $sql2 = "update recipient set recipient = '$recipient', message = '$message', image = '$filenameImg', update_at = '$tgl' where id = '$kodeToko'";  
      //   }
      //   else{
      //     $sql2 = "update recipient set recipient = '$recipient', message = '$message', update_at = '$tgl' where id = '$kodeToko'";
      //   }          
      //   $result2 = $con->query($sql2);
      //   $success = "Berhasil ubah Toko";

      //   $tambahToko = $_POST["tambahToko"] = "cancel";      
      // }
      // else if($flagForm == 1 && (isset($_POST["confirm"]) && $_POST["confirm"] != "")){ 
      //   $kodeToko = test_input($_POST["confirm"]);     
      //   $sql2 = "delete from recipient where id = '$kodeToko'";
      //   $result2 = $con->query($sql2);
      //   $success = "Berhasil hapus Toko";

      //   $tambahToko = $_POST["tambahToko"] = "cancel";
      //   // echo "$sql2";
      // }
      if($flagForm == 1){
        $status = send_email($recipient, $subject, $message, 1);

        if($status == "Email berhasil dikirim"){$success = $status;} 
        else { 
          $flagForm = 0;
          $err = "Terdapat kesalahan dalam sistem";
        }
      }   
    }
  }
  
  $sql = "SELECT * FROM recipient order by id";
  $result = $con->query($sql);

?>

<head>
  <meta property="og:image" itemprop="image" content="<?php echo "../" . $logo; ?>"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Email</title>
  <link rel="shortcut icon" type="image/jpg" href="<?php echo "../" . $logo; ?>" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
  <script src="../js/jquery-3.1.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
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

    div.divhover:hover {
      background-color:#F5F5F5;
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
      width: 200px;
    }

    .thumbnail:hover span{ /*CSS for enlarged image on hover*/
      text-align: center;
      visibility: visible;
      top: -90px;      
      left: 150px; /*position where enlarged image should offset horizontally */
      width: 210px;      
    }
  </style>
  <script type='text/javascript'>
    function preview_image(event){
     var reader = new FileReader();
     reader.onload = function(){
      var output = document.getElementById("output_image_product");
      output.src = reader.result;
     }
     reader.readAsDataURL(event.target.files[0]);
    }        
  </script>
</head>
<body style="z-index: -1;">  
  <div class="container" style="margin-top:70px;min-height: 500px;">    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" > 
      <form class="form-horizontal" id="recipient" name="recipient" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="">
        <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode;?>" placeholder="kode" readonly>
        <input type="hidden" class="form-control" id="tambahToko" name="tambahToko" value="<?php echo $tambahToko;?>" placeholder="tambahToko" readonly>
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
        <div class="container" id="grad4">                  
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4 style="color:white;margin-top: 15px;text-align: left;">Email</h4>  
          </div>          
        </div>
        <?php
          echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='border: 1px solid gainsboro;padding: 5px;margin-right: 25px;'>";
            echo "<div class='form-group'>";        
            echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-2 col-md-2 col-lg-2' for='kirim'>Kirim Ke : </label>";
            echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
            echo "<input type='text' class='form-control' id='recipient' name='recipient' value='$recipient'>";   
            echo "<span class='text-danger'>$recipientErr</span>";
            echo "</div>";
            echo "<div class='clearfix visible-xs-block'></div>";
            echo "<div class='clearfix visible-sm-block'></div>";
            echo "<div class='clearfix visible-md-block'></div>";
            echo "<div class='clearfix visible-lg-block'></div>";                
            echo "</div>";  
            echo "<div class='form-group'>";        
            echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-2 col-md-2 col-lg-2' for='kirim'>Subject : </label>";
            echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
            echo "<input type='text' class='form-control' id='subject' name='subject' value='$subject'>";   
            echo "<span class='text-danger'>$subjectErr</span>";
            echo "</div>";
            echo "<div class='clearfix visible-xs-block'></div>";
            echo "<div class='clearfix visible-sm-block'></div>";
            echo "<div class='clearfix visible-md-block'></div>";
            echo "<div class='clearfix visible-lg-block'></div>";                
            echo "</div>";  
            echo "<div class='form-group'>";        
            echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-2 col-md-2 col-lg-2' for='Deskripsi'>Deskripsi : </label>";
            echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
            echo "<textarea class='form-control' rows='5' id='message' name='message' value='$message' placeholder='add message...'>" . $message . "</textarea>";  
            echo "<span class='text-danger'>$messageErr</span>";
            echo "</div>";
            echo "<div class='clearfix visible-xs-block'></div>";
            echo "<div class='clearfix visible-sm-block'></div>";
            echo "<div class='clearfix visible-md-block'></div>";
            echo "<div class='clearfix visible-lg-block'></div>";                
            echo "</div>";                        
            echo "<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>";                    
              echo "<button type='submit' class='btn btn-primary pull-right' name='sendEmail' value='sendEmail'>Konfirmasi</button>&emsp;";
            echo "</div>";
            echo "</div>";
          echo "</div>";  
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