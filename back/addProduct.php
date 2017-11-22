<html>
<?php include 'menu.php'; ?>
<?php
  $flagForm = -1;
  $err = $produkErr = $deskripsiErr = $hargabaruErr = $image_productErr = $hargaErr = "";
  $harga = $produk = $deskripsi = "";
  $uploadImgOk = 1;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["editItem"]) && $_POST["editItem"] != ""){      
      $kode = test_input($_POST["editItem"]);     
      $tambahProduk = $_POST["tambahProduk"] = "cancel"; 
    }
    if(isset($_POST["hapus"]) && $_POST["hapus"] != ""){      
      $kode = test_input($_POST["hapus"]);       
      $tambahProduk = $_POST["tambahProduk"] = "cancel"; 
    }

    if(isset($_POST["cancelProduk"]) && $_POST["cancelProduk"] != ""){         
      $tambahProduk = $_POST["tambahProduk"] = "cancel";
    }
    if(isset($_POST["tambahProduk"]) && $_POST["tambahProduk"] == "tambahProduk"){ 
      $tambahProduk = $_POST["tambahProduk"] = "tambahProduk";   
    }
    if((isset($_POST["addProduk"]) && $_POST["addProduk"] != "") || (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "") || (isset($_POST["confirm"]) && $_POST["confirm"] != "")) {      
      $flagForm = 1;
      if (!isset($_POST["harga"])  || $_POST["harga"] == "") {
        $err = $hargaErr = "harga tidak boleh kosong";
        $flagForm = 0;
      }
      else {
        $harga = test_input($_POST["harga"]);
        if (!preg_match("/^[0-9]{0,15}$/",$harga)) {
          $err = $hargaErr = "hanya angka yang diperbolehkan";
          $flagForm = 0;
        }
      }

      if (!isset($_POST["produk"]) || $_POST["produk"] == "") {
        $err = $produkErr = "Silakan tulis produk yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $produk = addslashes($_POST["produk"]); 
        // if (!preg_match("/^[a-zA-Z0-9 ?.!@_]*$/",$produk)) {
        //   $produkErr = "Hanya huruf, angka dan spasi yang diperbolehkan";  
        //   $flagForm = 0;       
        // }
      }

      if (!isset($_POST["deskripsi"]) || $_POST["deskripsi"] == "") {
        $err = $editSejarahErr = "Silakan tulis deskripsi yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $deskripsi = addslashes($_POST["deskripsi"]); 
        // if (!preg_match("/^[a-zA-Z0-9 ?.!@_]*$/",$deskripsi)) {
        //   $deskripsiErr = "Hanya huruf, angka dan spasi yang diperbolehkan";  
        //   $flagForm = 0;       
        // }
      }

      if(!empty($_FILES)){
        if($_FILES["imageProduct"]['name']){
          $valid_file = true;
          if(!$_FILES['imageProduct']['error']){
            if($_FILES['imageProduct']['size'] > (10240000)){$valid_file = false;}
            if($valid_file){
              $allowedExts = array("gif", "jpeg", "jpg", "png");
              $temp = explode(".", $_FILES["imageProduct"]["name"]);
              $extension = end($temp);
              if ((($_FILES["imageProduct"]["type"] == "image/gif") || ($_FILES["imageProduct"]["type"] == "image/jpeg") || ($_FILES["imageProduct"]["type"] == "image/jpg") || ($_FILES["imageProduct"]["type"] == "image/pjpeg") || ($_FILES["imageProduct"]["type"] == "image/x-png") || ($_FILES["imageProduct"]["type"] == "image/png")) && in_array($extension, $allowedExts)){
                $date = date('YmdHis');

                //ganti ini ketika ingin diubah ke hosting
                $root = $_SERVER['DOCUMENT_ROOT'] . "/Repo";
                $imgPath = "/image/01/produk/";
                $uploadpath =  $root . $imgPath;
                if(!file_exists($uploadpath)){mkdir ($uploadpath, 0777, true);}                            
                $filenameImg = $imgPath . "produk" . uniqid() . "." . $extension;
                $fullfilename = $root . $filenameImg;
                $image = $_FILES["imageProduct"]["tmp_name"];               
                if(GenerateThumbnail($image, $fullfilename, 600, 800, 0.80) == 0){$uploadImgOk = 1;}
                else{$uploadImgOk = $flagForm=0;}                
              }
              else{$uploadImgOk = $flagForm=0;}                
            }
            else{$uploadImgOk = $flagForm=0;}
          }
          else{
            $uploadImgOk = $flagForm = 0;
            $err = cek_error($_FILES['imageProduct']['error']);
          }
        }  
      }
      if($flagForm == 1 && (isset($_POST["addProduk"]) && $_POST["addProduk"] != "")){ 
        if($uploadImgOk == 1){
          $tgl = date('Y-m-d H:i:s');
          $sql2 = "insert into produk(produk, deskripsi, image, hargabaru, hargalama, insert_at) values ('$produk', '$deskripsi', '$filenameImg', '$harga', '$harga', '$tgl')";
          $result2 = $con->query($sql2);
          $success = "Berhasil tambah Produk";

          $tambahProduk = $_POST["tambahProduk"] = "cancel";
          // echo "$sql2";  
        }        
        else{
          $flagForm = 0;
          $err = "Gagal Menambah Produk";
        }
      }
      else if($flagForm == 1 && (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "")){ 
        if($uploadImgOk == 1){
          $tgl = date('Y-m-d H:i:s');
          $kodeProduk = test_input($_POST["saveTiket"]);     
          if($filenameImg != ""){
            $sql2 = "update produk set produk = '$produk', deskripsi = '$deskripsi', image = '$filenameImg', update_at = '$tgl' where id = '$kodeProduk'";
          }
          else{            
            $sql2 = "update produk set produk = '$produk', deskripsi = '$deskripsi', update_at = '$tgl' where id = '$kodeProduk'";
          }
          $result2 = $con->query($sql2);
          $success = "Berhasil ubah Produk";

          $tambahProduk = $_POST["tambahProduk"] = "cancel";
        }        
        else{
          $flagForm = 0;
          $err = "Gagal Mengubah Produk";
        }
        // echo "$sql2";
      }
      else if($flagForm == 1 && (isset($_POST["confirm"]) && $_POST["confirm"] != "")){ 
        $kodeProduk = test_input($_POST["confirm"]);     
        $sql2 = "delete from produk where id = '$kodeProduk'";
        $result2 = $con->query($sql2);
        $success = "Berhasil hapus Produk";

        $tambahProduk = $_POST["tambahProduk"] = "cancel";
        // echo "$sql2";
      }
    }
  }
  
  $sql = "SELECT * FROM produk order by id";
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
  <title>Product</title>
  <link rel="shortcut icon" type="image/jpg" href="image/logo/logo01.jpg" />
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
  <div class="container" style="min-height: 500px;margin-top: 70px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" > 
      <form class="form-horizontal" id="produk" name="produk" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="">
        <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode;?>" placeholder="kode" readonly>
        <input type="hidden" class="form-control" id="tambahProduk" name="tambahProduk" value="<?php echo $tambahProduk;?>" placeholder="tambahProduk" readonly>
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
            <h4 style="color:white;margin-top: 15px;text-align: left;">Produk</h4>  
          </div>
          <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
          <?php 
            echo "<button type='submit' style='font-size:14px;margin-top: 8px;' class='btn btn-sm btn-success pull-right' name='tambahProduk' value='tambahProduk'><span class='glyphicon glyphicon glyphicon glyphicon-plus'>&nbsp;</span>Tambah Produk&nbsp;&nbsp;</button>";         
          ?>          
          </div>
        </div>
        <?php
            if(isset($_POST["tambahProduk"]) && $_POST["tambahProduk"] == "tambahProduk"){                                      
              echo "<div class='panel panel-success col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
              echo "<div class='panel-heading'>Konfirmasi Add</div>";          
              echo "<div class='panel-body' style='width:100%;'>";
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Nama'>Nama Produk : </label>";
                echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                echo "<input type='text' class='form-control' id='produk' name='produk' value='$produk'>";   
                echo "<span class='text-danger'>$produkErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";                
                echo "</div>";  
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Deskripsi'>Deskripsi : </label>";
                echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                echo "<textarea class='form-control' rows='5' id='deskripsi' name='deskripsi' value='$deskripsi' placeholder='add deskripsi...'>" . $deskripsi . "</textarea>";  
                echo "<span class='text-danger'>$deskripsiErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";                
                echo "</div>";        
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Harga'>Harga Produk : </label>";
                echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                echo "<input type='text' class='form-control' id='harga' name='harga' value='$harga'>";   
                echo "<span class='text-danger'>$hargaErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";                
                echo "</div>";    
                echo "<div class='form-group'>";   
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Gambar'>Gambar Produk : </label>";
                echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                echo "<input type='file' class='form-control' id='imageProduct' name='imageProduct' accept='image/*' onchange='preview_image(event)'>";
                echo "<span class='text-danger'><?php echo $image_productErr;?></span>"; 
                echo "<img id='output_image_product' class='img-responsive' style='height:200px;'/>";                      
                echo "</div>";                     
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";                 
                echo "</div>";
              echo "<div class='panel-footer clearfix'>";
                  echo "<div class='pull-right'>";                    
                    echo "<button type='submit' class='btn btn-default' name='cancelProduk' value='cancelProduk'>Cancel</button>&emsp;";
                    echo "<button type='submit' class='btn btn-primary' name='addProduk' value='addProduk'>Konfirmasi</button>&emsp;";
                  echo "</div>";
              echo "</div>";
            echo "</div>";     
            echo "</div>";
          }                      
          $jumlah = 1;
          $j = 0;
          while($row = $result->fetch_assoc()) {
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divhover" style="border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <br/>
            <div class="hidden-xs col-sm-3 col-md-2 col-lg-2" style="text-align: center;">
              <?php 
                echo "<a class='thumbnail' href='#thumb'><img class='img-responsive' style='height:100px;margin: auto;left: 0;right: 0;' src='../" . $row['image'] . "' alt='produk'><span><img src='../" . $row['image'] . "' /><br />" . $row['produk'] . "</span></a>";
                // echo "<button type='submit' style='font-size:14px;text-align' class='btn btn-sm btn-danger' name='hapus' value='$j'><span class='glyphicon glyphicon glyphicon-folder-open'>&nbsp;</span>Ganti Gambar&nbsp;&nbsp;</button>"; 
              ?>              
            </div>
            <div class="visible-xs col-xs-12">
              <?php 
                echo "<img class='img-responsive' style='height:100px;margin: auto;left: 0;right: 0;' src='../" . $row['image'] . "' alt='produk'>";
              ?>        
            </div>
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
              <p class="text-left" style="color: #034f84;"><?php echo "<a href='detailproduct.php?id=" . $row['id'] . "'>" . $row['produk'] . "</a>"; ?></p>
            </div>             
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="min-height: 100px;">
              <p class="text-left" style="font-size:12px;"><?php echo $row['deskripsi']; ?><br/></p>                            
            </div> 
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">              
              <?php
                if($row['updateharga_at'] != NULL){
              ?>
                <p class="text-left" style="font-size:12px;color: #BE1E2D;">Per <?php echo date("d M Y", strtotime($row['updateharga_at'])); ?> &emsp;&emsp;<br/></p>
                <p class="text-left" style="font-size:12px;color: #BE1E2D;">Harga Baru <?php echo "Rp " . number_format($row['hargabaru'],0,',','.'); ?>&emsp;&emsp;<br/></p>
                <p class="text-left" style="font-size:12px;color: #BE1E2D;">Harga Lama <?php echo "Rp " . number_format($row['hargalama'],0,',','.'); ?>&emsp;&emsp;<br/></p>
              <?php
                }
                else{
              ?>
                  <p class="text-left" style="font-size:12px;color: #BE1E2D;">Harga Lama <?php echo "Rp " . number_format($row['hargalama'],0,',','.'); ?>&emsp;&emsp;<br/></p>
              <?php
                }
              ?>
            </div>                           
            <div class="clearfix visible-sm-block"></div> 
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 pull-right">    
              <?php 
                echo "<button type='submit' style='font-size:14px;' class='btn btn-sm btn-danger  pull-right' name='hapus' value='" . $row['id'] . "'><span class='glyphicon glyphicon-trash'></span></button>"; 
                echo "<button type='submit' style='font-size:14px;margin-right:20px;' class='btn btn-sm btn-info  pull-right' name='editItem' value='" . $row['id'] . "'><span class='glyphicon glyphicon-pencil'></span></button>"; 
                
              ?>
            </div>          
            <?php
              if((isset($_POST["editItem"]) && $kode == $row['id']) || (isset($_POST["hapus"]) && $kode == $row['id'])){     
                echo "<div class='visible-xs col-xs-12'>";
                echo "<hr/>";
                echo "</div>";            
                if(isset($_POST["editItem"])){
                  echo "<div class='panel panel-info col-xs-12 col-sm-12 col-md-12 col-lg-12' >";
                  echo "<div class='panel-heading'>Konfirmasi Edit</div>";
                } 
                else if(isset($_POST["hapus"])){
                  echo "<div class='panel panel-danger col-xs-12 col-sm-12 col-md-12 col-lg-12' >";
                  echo "<div class='panel-heading'>Konfirmasi Delete</div>";
                } 
                  echo "<div class='panel-body' style='width:100%;'>";
                    echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Nama'>Nama Produk : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      echo "<input type='text' class='form-control' id='produk' name='produk' value='" . $row['produk'] . "' autofocus>";   
                      echo "<span class='text-danger'>$produkErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";  
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Deskripsi'>Deskripsi : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      echo "<textarea class='form-control' rows='5' id='deskripsi' name='deskripsi' value='" . $row['deskripsi'] . "' placeholder='add deskripsi...'>" . $row['deskripsi'] . "</textarea>";  
                      echo "<span class='text-danger'>$deskripsiErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                                          
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Harga'>Harga Baru : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      echo "<input type='text' class='form-control' id='harga' name='harga' value='" . $row['hargabaru'] . "'>";   
                      echo "<span class='text-danger'>$hargaErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";  
                  echo "</div>";        
                  echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>";  
                    if($row['image'] != "") {
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-4 col-md-4 col-lg-4' for='Gambar'>Gambar Produk : </label>";
                      echo "<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>";                    
                      $img = "../" . $row['image'];
                      echo "<img class='img-responsive' src='$img'>";                             
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>";
                    }
                    if((isset($_POST["editItem"]) && $kode == $row['id'])){ 
                      echo "<div class='form-group'>";   
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-4 col-md-4 col-lg-4' for='image'>Ganti Gambar : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";   
                      echo "<input type='file' class='form-control' id='imageProduct' name='imageProduct' accept='image/*' onchange='preview_image(event)'>";
                      echo "<span class='text-danger'><?php echo $image_productErr;?></span>"; 
                      echo "<img id='output_image_product' class='img-responsive' />";                      
                      echo "</div>";                     
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>"; 
                    }                         
                    echo "<div class='clearfix visible-xs-block'></div>";                 
                    echo "</div>";        
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