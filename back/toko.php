<html>
<?php include 'menu.php'; ?>
<?php
  $flagForm = -1;
  $err = $tokoErr = $alamatTokoErr = $hargabaruErr = $image_productErr = $hargaErr = "";
  $harga = $toko = $alamatToko = "";
  $uploadImgOk = 1;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    if(isset($_POST["konsinyasi"]) && $_POST["konsinyasi"] != ""){ 
      header("Location: konsinyasi.php?idToko=".$_POST["konsinyasi"]);
    }
    if(isset($_POST["editItem"]) && $_POST["editItem"] != ""){      
      $kode = test_input($_POST["editItem"]);     
      $tambahToko = $_POST["tambahToko"] = "cancel"; 
    }
    if(isset($_POST["hapus"]) && $_POST["hapus"] != ""){      
      $kode = test_input($_POST["hapus"]);       
      $tambahToko = $_POST["tambahToko"] = "cancel"; 
    }

    if(isset($_POST["cancelToko"]) && $_POST["cancelToko"] != ""){         
      $tambahToko = $_POST["tambahToko"] = "cancel";
    }
    if(isset($_POST["tambahToko"]) && $_POST["tambahToko"] == "tambahToko"){ 
      $tambahToko = $_POST["tambahToko"] = "tambahToko";   
    }
    if((isset($_POST["addToko"]) && $_POST["addToko"] != "") || (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "") || (isset($_POST["confirm"]) && $_POST["confirm"] != "")) {      
      $flagForm = 1;
      if (!isset($_POST["toko"]) || $_POST["toko"] == "") {
        $err = $tokoErr = "Silakan tulis toko yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $toko = addslashes($_POST["toko"]); 
        // if (!preg_match("/^[a-zA-Z0-9 ?.!@_]*$/",$toko)) {
        //   $tokoErr = "Hanya huruf, angka dan spasi yang diperbolehkan";  
        //   $flagForm = 0;       
        // }
      }

      if (!isset($_POST["alamatToko"]) || $_POST["alamatToko"] == "") {
        $err = $editSejarahErr = "Silakan tulis alamatToko yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $alamatToko = addslashes($_POST["alamatToko"]); 
        // if (!preg_match("/^[a-zA-Z0-9 ?.!@_]*$/",$alamatToko)) {
        //   $alamatTokoErr = "Hanya huruf, angka dan spasi yang diperbolehkan";  
        //   $flagForm = 0;       
        // }
      }
      
      if($flagForm == 1 && (isset($_POST["addToko"]) && $_POST["addToko"] != "")){ 
        $tgl = date('Y-m-d H:i:s');          
        $sql2 = "insert into toko(toko, alamatToko, image, insert_at) values ('$toko', '$alamatToko', '$filenameImg', '$tgl')";
        $result2 = $con->query($sql2);
        $success = "Berhasil tambah Toko";

        $tambahToko = $_POST["tambahToko"] = "cancel";
        // echo "$sql2";  
      }
      else if($flagForm == 1 && (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "")){ 
        $tgl = date('Y-m-d H:i:s');
        $kodeToko = test_input($_POST["saveTiket"]);     
        if($filenameImg != ""){
          $sql2 = "update toko set toko = '$toko', alamatToko = '$alamatToko', image = '$filenameImg', update_at = '$tgl' where id = '$kodeToko'";  
        }
        else{
          $sql2 = "update toko set toko = '$toko', alamatToko = '$alamatToko', update_at = '$tgl' where id = '$kodeToko'";
        }          
        $result2 = $con->query($sql2);
        $success = "Berhasil ubah Toko";

        $tambahToko = $_POST["tambahToko"] = "cancel";      
      }
      else if($flagForm == 1 && (isset($_POST["confirm"]) && $_POST["confirm"] != "")){ 
        $kodeToko = test_input($_POST["confirm"]);     
        $sql2 = "delete from toko where id = '$kodeToko'";
        $result2 = $con->query($sql2);
        $success = "Berhasil hapus Toko";

        $tambahToko = $_POST["tambahToko"] = "cancel";
        // echo "$sql2";
      }
    }
  }
  
  $sql = "SELECT * FROM toko order by id";
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
  <title>Toko</title>
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
      <form class="form-horizontal" id="toko" name="toko" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="">
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
          <div class="col-xs-6 col-sm-8 col-md-8 col-lg-6">
            <h4 style="color:white;margin-top: 15px;text-align: left;">Toko</h4>  
          </div>
          <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
          <?php 
            echo "<button type='submit' style='font-size:14px;margin-top: 8px;' class='btn btn-sm btn-success pull-right' name='tambahToko' value='tambahToko'><span class='glyphicon glyphicon glyphicon glyphicon-plus'>&nbsp;</span>Tambah Toko&nbsp;&nbsp;</button>";         
          ?>          
          </div>
        </div>
        <?php
            if(isset($_POST["tambahToko"]) && $_POST["tambahToko"] == "tambahToko"){                                      
              echo "<div class='panel panel-success col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
              echo "<div class='panel-heading'>Konfirmasi Add</div>";          
              echo "<div class='panel-body' style='width:100%;'>";
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Nama'>Nama Toko : </label>";
                echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                echo "<input type='text' class='form-control' id='toko' name='toko' value='$toko'>";   
                echo "<span class='text-danger'>$tokoErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";                
                echo "</div>";  
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Deskripsi'>Deskripsi : </label>";
                echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                echo "<textarea class='form-control' rows='5' id='alamatToko' name='alamatToko' value='$alamatToko' placeholder='add alamatToko...'>" . $alamatToko . "</textarea>";  
                echo "<span class='text-danger'>$alamatTokoErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";                
                echo "</div>";                        
              echo "<div class='panel-footer clearfix'>";
                  echo "<div class='pull-right'>";                    
                    echo "<button type='submit' class='btn btn-default' name='cancelToko' value='cancelToko'>Cancel</button>&emsp;";
                    echo "<button type='submit' class='btn btn-primary' name='addToko' value='addToko'>Konfirmasi</button>&emsp;";
                  echo "</div>";
              echo "</div>";
            echo "</div>";     
            echo "</div>";         
          }                      
          $jumlah = 1;
          $j = 0;
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="background-color:white;font-size:14px;border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="margin-top: 10px;">
              <p class="text-left">Nama Toko</p>
            </div>           
            <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3" style="margin-top: 10px;">
              <p class="text-left">Alamat Toko</p>                            
            </div> 
            <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3" style="margin-top: 10px;">
              <p class="hidden-sm text-left">Detail</p>                          
              <p class="visible-sm text-right">Detail</p>                          
            </div> 
            <div class="hidden-sm col-md-4 col-lg-4" style="margin-top: 10px;">
              <p class="text-center">Action</p>                            
            </div>        
          </div>
        </div>
        <?php
        while($row = $result->fetch_assoc()) {
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="visible-xs col-xs-12" style="background-color:gainsboro;font-size:14px;border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <p style="text-align: center;">Detail Toko</p>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divhover" style="border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <br/>
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
              <p class="text-left" style="color: #034f84;"><?php echo $row['toko']; ?></p>
            </div>             
            <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3" style="min-height: 50px;">
              <p class="text-left" style="font-size:13px;"><?php echo $row['alamatToko']; ?><br/></p>                         
            </div> 
            <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">              
              <p class="hidden-sm text-left" style="font-size:13px;color: #BE1E2D;">Insert Toko per <?php echo date("d M Y", strtotime($row['insert_at'])); ?> &emsp;&emsp;<br/></p>
              <p class="visible-sm text-right" style="font-size:13px;color: #BE1E2D;">Insert Toko per <?php echo date("d M Y", strtotime($row['insert_at'])); ?><br/></p>
            </div>                           
            <div class="clearfix visible-sm-block"></div> 
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">    
              <?php 
                echo "<button type='submit' style='font-size:12px;' class='btn btn-sm btn-primary  pull-right' name='konsinyasi' value='" . $row['id'] . "'>Lihat Konsinyasi</button>"; 
                echo "<button type='submit' style='font-size:12px;margin-right:10px;' class='btn btn-sm btn-danger  pull-right' name='hapus' value='" . $row['id'] . "'>&nbsp;<span class='glyphicon glyphicon-trash'></span>&nbsp;</button>"; 
                echo "<button type='submit' style='font-size:12px;margin-right:10px;' class='btn btn-sm btn-info  pull-right' name='editItem' value='" . $row['id'] . "'>&nbsp;<span class='glyphicon glyphicon-pencil'></span>&nbsp;</button>"; 
              ?>
            </div>          
            <?php                
              if((isset($_POST["editItem"]) && $kode == $row['id']) || (isset($_POST["hapus"]) && $kode == $row['id'])){     
                echo "<div class='visible-xs col-xs-12'>";
                echo "<hr/>";
                echo "</div>";          
                if(isset($_POST["editItem"])){
                  echo "<div class='panel panel-info col-xs-12 col-sm-12 col-md-6 col-lg-offset-3 col-lg-6' >";
                  echo "<div class='panel-heading'>Konfirmasi Edit</div>";
                } 
                else if(isset($_POST["hapus"])){
                  echo "<div class='panel panel-danger col-xs-12 col-sm-12 col-md-6 col-lg-offset-3 col-lg-6' >";
                  echo "<div class='panel-heading'>Konfirmasi Delete</div>";
                } 
                  echo "<div class='panel-body' style='width:100%;'>";
                    echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-4 col-lg-4' for='Nama'>Nama Toko : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<input type='text' class='form-control' id='toko' name='toko' value='" . $row['toko'] . "' autofocus>";   
                      echo "<span class='text-danger'>$tokoErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";  
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-4 col-md-4 col-lg-4' for='Deskripsi'>Deskripsi : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<textarea class='form-control' rows='5' id='alamatToko' name='alamatToko' value='" . $row['alamatToko'] . "' placeholder='add alamatToko...'>" . $row['alamatToko'] . "</textarea>";  
                      echo "<span class='text-danger'>$alamatTokoErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                                                                
                      echo "</div>";  
                    echo "<div class='clearfix visible-xs-block'></div>";                 
                  echo "</div>";      
                  echo "<div class='panel-footer clearfix'>";
                      echo "<div class='pull-right'>";                    
                          echo "<button type='submit' class='btn btn-default' name='cancelTiket' value='" . $row['id'] . "'>Cancel</button>&emsp;";
                          if((isset($_POST["hapus"]) && $kode == $row['id'])){ 
                            echo "<button type='submit' class='btn btn-primary' name='confirm' value='" . $row['id'] . "'>Konfirmasi</button>&emsp;";
                          }
                          else{
                            echo "<button type='submit' class='btn btn-primary' name='saveTiket' value='" . $row['id'] . "'>Konfirmasi</button>&emsp;";
                          }
                      echo "</div>";
                  echo "</div>";
              }         
            ?>
            <div class="clearfix visible-xs-block"></div>
            <div class="clearfix visible-sm-block"></div>
            <div class="clearfix visible-md-block"></div>
            <div class="clearfix visible-lg-block"></div>       
                         
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