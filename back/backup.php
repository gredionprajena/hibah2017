<html>
<?php include 'menu.php'; ?>
<?php
  $flagForm = -1;
  $err = $tokoErr = $produkErr = $hargabaruErr = $image_productErr = $hargaKirimErr = $TglKirimErr = $addprodukErr = $jmlKirimErr = "";
  $hargaKirim = $pemesanan = $alamatPemesanan = $jmlKirim = $produk = "";
  $tglKirim = date('d/m/Y');
  $uploadImgOk = 1;


  if (isset($_POST["addproduk"]) && $_POST["addproduk"] != -1) { $produk = $_POST["addproduk"]; }
  
  if (isset($_POST["idToko"])){
    if($_POST["idToko"] != -1) { $idToko = $_POST["idToko"]; }  
    else{$idToko = -1;}
  } 
  else{
    if (isset($_GET["idToko"]) && $_GET["idToko"] != -1) { $idToko = $_GET["idToko"]; }
    else{$idToko = -1;}
  }

  if (isset($_POST["addtoko"]) && $_POST["addtoko"] != -1) { $toko = $_POST["addtoko"]; }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["editItem"]) && $_POST["editItem"] != ""){      
      $kode = test_input($_POST["editItem"]);     
      $tambahPemesanan = $_POST["tambahPemesanan"] = "cancel"; 
    }
    if(isset($_POST["hapus"]) && $_POST["hapus"] != ""){      
      $kode = test_input($_POST["hapus"]);       
      $tambahPemesanan = $_POST["tambahPemesanan"] = "cancel"; 
    }

    if(isset($_POST["cancelPemesanan"]) && $_POST["cancelPemesanan"] != ""){         
      $tambahPemesanan = $_POST["tambahPemesanan"] = "cancel";
    }
    if(isset($_POST["tambahPemesanan"]) && $_POST["tambahPemesanan"] == "tambahPemesanan"){ 
      $tambahPemesanan = $_POST["tambahPemesanan"] = "tambahPemesanan";   
    }
    if((isset($_POST["addPemesanan"]) && $_POST["addPemesanan"] != "") || (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "") || (isset($_POST["confirm"]) && $_POST["confirm"] != "")) {      
      $flagForm = 1;
      
      if((isset($_POST["addPemesanan"]) && $_POST["addPemesanan"] != "") || (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "")){
        if (!isset($_POST["addtoko"]) || $_POST["addtoko"] == -1) {
          $err = $tokoErr = "Silakan pilih toko yang diinginkan"; 
          $flagForm = 0; 
        } 
        else { 
          $toko = addslashes($_POST["addtoko"]); 
        }
        if (!isset($_POST["addproduk"]) || $_POST["addproduk"] == -1) {
          $err = $produkErr = "Silakan pilih produk yang diinginkan"; 
          $flagForm = 0; 
        } 
        else { 
          $produk = addslashes($_POST["addproduk"]); 
        }
        if (!isset($_POST["jmlKirim"]) || $_POST["jmlKirim"] == "") {
          $err = $produkErr = "Silakan isi jumlah kirim yang diinginkan"; 
          $flagForm = 0; 
        } 
        else { 
          $jmlKirim = addslashes($_POST["jmlKirim"]); 
        }
        if (!isset($_POST["hargaKirim"]) || $_POST["hargaKirim"] == "") {
          $err = $produkErr = "Silakan isi harga kirim yang diinginkan"; 
          $flagForm = 0; 
        } 
        else { 
          $hargaKirim = addslashes($_POST["hargaKirim"]); 
        }
        if (!isset($_POST["tglKirim"]) || $_POST["tglKirim"] == "") { $flagForm = 0;$err = $produkErr = "Silakan isi tanggal kirim2 yang diinginkan";}
        else if($_POST["tglKirim"] == "dd/mm/yyyy"){$flagForm = 0;$err = $produkErr = "Silakan isi tanggal kirim3 yang diinginkan";}
        else {
          $tglKirim = test_input($_POST["tglKirim"]);
          if(preg_match("/(\d{2})\/(\d{2})\/(\d{4})$/", $tglKirim ,$matches)){         
            $result = checkdate((int) $matches[2],(int)$matches[1],(int) $matches[3]);
            if($result == 1){
            }
            else{$flagForm = 0;$err = $produkErr = "Silakan isi tanggal kirim4 yang diinginkan"; }
          }else{$flagForm = 0;$err = $produkErr = "Silakan isi tanggal kirim5 yang diinginkan"; }        
        }

        if((isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "") || (isset($_POST["confirm"]) && $_POST["confirm"] != "")){
          if (!isset($_POST["jmlKembali"]) || $_POST["jmlKembali"] == "") {
            $err = $produkErr = "Silakan isi jumlah kembali yang diinginkan"; 
            $flagForm = 0; 
          } 
          else { 
            $jmlKembali = addslashes($_POST["jmlKembali"]); 
          }
          if (!isset($_POST["tglKembali"]) || $_POST["tglKembali"] == "") { $flagForm = 0;$err = $produkErr = "Silakan isi tanggal kembali2 yang diinginkan";}
          else if($_POST["tglKembali"] == "dd/mm/yyyy"){$flagForm = 0;$err = $produkErr = "Silakan isi tanggal kembali3 yang diinginkan";}
          else {
            $tglKembali = test_input($_POST["tglKembali"]);
            if(preg_match("/(\d{2})\/(\d{2})\/(\d{4})$/", $tglKembali ,$matches)){         
              $result = checkdate((int) $matches[2],(int)$matches[1],(int) $matches[3]);
              if($result == 1){
              }
              else{$flagForm = 0;$err = $produkErr = "Silakan isi tanggal kembali4 yang diinginkan"; }
            }else{$flagForm = 0;$err = $produkErr = "Silakan isi tanggal kembali5 yang diinginkan"; }        
          }
        }
      }
      if($flagForm == 1 && (isset($_POST["addPemesanan"]) && $_POST["addPemesanan"] != "")){ 
        $tgl = date('Y-m-d H:i:s');          
        $tglKirim = DateTime::createFromFormat('d/m/Y', $tglKirim)->format('Y-m-d');       

        $sql2 = "insert into pemesanan(idtoko, idproduct, jumlahKirim, hargaKirim, tanggalkirim, insert_at) values ('$toko', '$produk', '$jmlKirim', '$hargaKirim', '$tglKirim', '$tgl')";
        $result2 = $con->query($sql2);

        $success = "Berhasil tambah Pemesanan";
        $tambahPemesanan = $_POST["tambahPemesanan"] = "cancel";        
      }
      else if($flagForm == 1 && (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "")){ 
        $tgl = date('Y-m-d H:i:s');        
      
        $tglKirim = DateTime::createFromFormat('d/m/Y', $tglKirim)->format('Y-m-d');          
        $tglKembali = DateTime::createFromFormat('d/m/Y', $tglKembali)->format('Y-m-d');
        $kodePemesanan = test_input($_POST["saveTiket"]);     
        
        $sql2 = "update pemesanan set idtoko = '$toko', idproduct = '$produk', jumlahKirim ='$jmlKirim', hargakirim ='$hargaKirim', jumlahKembali ='$jmlKembali', tanggalKirim = '$tglKirim', tanggalKembali = '$tglKembali', update_at = '$tgl' where kode_pemesanan = '$kodePemesanan'";

        $result2 = $con->query($sql2);
        $success = "Berhasil ubah Pemesanan";

        $tambahPemesanan = $_POST["tambahPemesanan"] = "cancel";      
      }
      else if($flagForm == 1 && (isset($_POST["confirm"]) && $_POST["confirm"] != "")){ 
        $kodePemesanan = test_input($_POST["confirm"]);     
        $sql2 = "delete from pemesanan where kode_pemesanan = '$kodePemesanan'";
        $result2 = $con->query($sql2);
        $success = "Berhasil hapus Pemesanan";

        $tambahPemesanan = $_POST["tambahPemesanan"] = "cancel";
        // echo "$sql2";
      }
    }
  }
  $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];  
  
  if(isset($_POST["bulanSkrg"]) && $_POST["bulanSkrg"] != -1){$bulanSkrg = $_POST["bulanSkrg"] +1;}
  else{$bulanSkrg = date('m');}

  $sqlPemesanan = "SELECT * FROM pemesanan p join users01 u on p.id_user = u.id order by p.kode_pemesanan";
  $resultPemesanan = $con->query($sqlPemesanan);
  // echo $sqlPemesanan;
?>

<head>
  <meta property="og:image" itemprop="image" content="<?php echo "../" . $logo; ?>"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Partner</title>
  <link rel="shortcut icon" type="image/jpg" href="image/logo/logo01.j<?php echo "../" . $logo; ?>" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="../css/jquery-ui-1.12.1.custom/jquery-ui.css">
  <script src="../css/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
  <script src="../css/jquery-ui-1.12.1.custom/jquery-ui.js"></script> 
  <script src="../js/bootstrap.min.js"></script>
  <style> 
    #grad4 {
      /*margin-top: 60px;*/
      min-height: 50px; 
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
  </style>
  <script>
    $(function () {
      $('#datepicker').datepicker({
          dateFormat: 'dd/mm/yy',
          showButtonPanel: true,
          changeMonth: true,
          changeYear: true,
          minDate: '+0',
          maxDate: '+2Y',
          inline: true
      });
    });
    $(function () {
      $('#datepicker2').datepicker({
          dateFormat: 'dd/mm/yy',
          showButtonPanel: true,
          changeMonth: true,
          changeYear: true,
          minDate: '+0',
          maxDate: '+2Y',
          inline: true
      });
    });
  </script>
</head>
<body style="z-index: -1;margin-top: 100px;">  
  <?php include 'carousel.php'; ?>
  <div class="container" style="min-height: 458px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" > 
      <form class="form-horizontal" id="pemesanan" name="pemesanan" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?idToko=" . $idToko; ?>" style="">
        <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode;?>" placeholder="kode" readonly>
        <input type="hidden" class="form-control" id="tambahPemesanan" name="tambahPemesanan" value="<?php echo $tambahPemesanan;?>" placeholder="tambahPemesanan" readonly>
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
          <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
            <h4 style="color:white;margin-top: 15px;text-align: left;">Pemesanan Toko </h4> 
          </div>
          <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2" style="margin-top: 6px;">
            <?php              
              $sql2 = "SELECT * FROM toko01 order by id";
              $result2 = $con->query($sql2);
              echo "<select id='idToko' class='form-control input-xlarge' onchange='this.form.submit()' name='idToko'>";
                echo "<option value='-1' selected>-Pilih Toko-</option>";                
                $urut = 0;
                while($row2 = $result2->fetch_assoc()) {
                  if($row2["id"] == $idToko){
                    echo "<option value='".$row2["id"]."' selected>" . $row2["id"] . $row2["toko"] . "</option>";                
                  }
                  else{
                    echo "<option value='".$row2["id"]."'>" . $row2["id"] . $row2["toko"] . "</option>";                 
                  }
                  $urut++;
                }
              echo "</select>";
            echo '</div>';
            echo '<div class="col-xs-5 col-sm-4 col-md-2 col-lg-2" style="margin-top: 6px;">';
              echo "<select id='bulanSkrg' class='form-control input-xlarge' onchange='this.form.submit()' name='bulanSkrg'>";
                echo "<option value='-1' selected>-Pilih Bulan-</option>";              
                for ($i=0; $i < 12; $i++) {                  
                  if($i+1 == date('m') || $bulanSkrg == $i+1){
                    echo "<option value='$i' selected>" . $bulan[$i] . "</option>";                
                  }
                  else{
                    echo "<option value='$i'>" . $bulan[$i] . "</option>";                 
                  }                
                }
              echo "</select>";
            echo '</div>';
            echo '<div class="col-xs-7 col-sm-4 col-md-2 col-lg-2" style="margin-top: 6px;">';
              echo "<select id='tahun' class='form-control input-xlarge' onchange='this.form.submit()' name='tahun'>";
                echo "<option value='-1' selected>-Pilih Tahun-</option>";   
                for ($i=2016; $i <= date('Y'); $i++) {                  
                  if($i == date('Y')){
                    echo "<option value='$i' selected>" . $i . "</option>";                
                  }
                  else{
                    echo "<option value='$i'>" . $i . "</option>";                 
                  }                
                }
              echo "</select>";       
            ?> 
          </div>
        </div>        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">          
          <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="background-color:gainsboro;font-size:14px;border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="margin-top: 10px;">
              <p class="text-left">Kode Pemesanan</p>
            </div>           
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-top: 10px;">
              <p class="text-left">Id Pemesan</p>                            
            </div> 
            <div class="col-xs-12 col-sm-3 col-md-2 col-lg-3" style="margin-top: 10px;">
              <p class="text-left">Alamat Kirim</p>                          
            </div> 
            <div class="col-xs-12 col-sm-3 col-md-1 col-lg-1" style="margin-top: 10px;">
              <p class="text-right">Harga</p>                            
            </div>        
            <div class="visible-md col-md-2 visible-lg col-lg-2" style="margin-top: 10px;">
              <p class="text-right">Ongkos Kirim</p>                            
            </div>     
            <div class="visible-md col-md-2 visible-lg col-lg-1" style="margin-top: 10px;">
              <p class="text-right">Tagihan</p>                            
            </div>    
          </div>
          <div class="visible-xs col-xs-12" style="background-color:gainsboro;font-size:14px;border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <p style="text-align: center;">Detail Pemesanan</p>
          </div>
        </div>
        <?php 
          $total = 0;
          while($rowPemesanan = $resultPemesanan->fetch_assoc()) { 
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">    
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divhover" style="border: 1px solid gainsboro;padding: 5px;margin-right: 25px;font-size: 14px;">
            <br/>            
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">              
              <p style="text-align: left;"><?php echo $rowPemesanan['kode_pemesanan']; ?><br/></p>  
            </div>            
            <div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">        
              <p style="text-align: left;"><?php echo "Id Pemesan : " . $rowPemesanan['id_user'] . "<br/>Nama : " . $rowPemesanan['name']. "<br/>Email : " . $rowPemesanan['email']; ?><br/></p>  
            </div>            
            <div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">        
              <p style="text-align: left;"><?php echo "Nama Penerima : " . $rowPemesanan['nama_penerima'] . "<br/>No Telp : " . $rowPemesanan['no_telp']. "<br/>Email : " . $rowPemesanan['email']. "<br/>Alamat Lengkap :<br/>" . $rowPemesanan['alamat_lengkap'] . "<br/>" . $rowPemesanan['provinsi'] . "<br/>" . $rowPemesanan['provinsi'] . $rowPemesanan['kode_pos']; ?><br/></p>  
            </div>            
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">                               
              <p class="text-right" style=""><?php echo number_format($rowPemesanan['total_harga'],2,',','.'); ?><br/></p>                   
            </div>        
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">                 
              <p class="text-right" style=""><?php echo number_format($rowPemesanan['total_ongkir'],2,',','.'); ?><br/></p>      
            </div>     
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">                 
              <p class="text-right" style=""><?php echo number_format($rowPemesanan['total_bayar'],2,',','.'); ?><br/></p>      
            </div> 
            <?php
              $sqlData = "SELECT * FROM pemesanan p join users01 u on p.id_user = u.id join pemesanan_detail d on p.kode_pemesanan = d.kode_pemesanan join produk01 pd on d.id_barang = pd.id where d.kode_pemesanan = '" . $rowPemesanan["kode_pemesanan"] . "' order by p.kode_pemesanan"; 
              // echo $sqlData;             
              $resultData = $con->query($sqlData);
            ?>
            <div class='clearfix visible-xs-block'></div>
            <div class='clearfix visible-sm-block'></div>
            <div class='clearfix visible-md-block'></div>
            <div class='clearfix visible-lg-block'></div>
            <hr/>
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">        
              <p style="text-align: left;">Detail Produk Pesanan<br/></p>  
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">        
            <?php
              while($rowData = $resultData->fetch_assoc()) { 
            ?>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3" style="border:1px solid gainsboro;">       
                <p style="text-align: left;"><?php echo "Id Barang : " . $rowData['id_barang'] . "<br/>Nama : " . $rowData['produk'] . "<br/>Jumlah : " . $rowData['qty']; ?><br/></p>  
              </div>
            <?php
              } 
            ?>
            </div>                         
            <div class="col-xs-12 col-sm-4 col-md-12 col-lg-12 pull-right">    
              <?php 
                echo "<button type='submit' style='font-size:14px;' class='btn btn-sm btn-danger pull-right' name='hapus' value='" . $rowPemesanan['kode_pemesanan'] . "'><span class='glyphicon glyphicon-trash'></span></button>"; 
                echo "<button type='submit' style='font-size:14px;margin-right:20px;' class='btn btn-sm btn-info pull-right' name='editItem' value='" . $rowPemesanan['kode_pemesanan'] . "'><span class='glyphicon glyphicon-pencil'></span></button>"; 
              ?>
            </div>
            <?php      
              if((isset($_POST["editItem"]) && $kode == $rowPemesanan['kode_pemesanan']) || (isset($_POST["hapus"]) && $kode == $rowPemesanan['kode_pemesanan'])){     
                echo "<div class='visible-xs col-xs-12'>";
                echo "<hr/>";
                echo "</div>";            
                if(isset($_POST["editItem"])){
                  echo "<div class='panel panel-success col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                  echo "<div class='panel-heading'>Konfirmasi Edit</div>";
                } 
                else if(isset($_POST["hapus"])){
                  echo "<div class='panel panel-danger col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                  echo "<div class='panel-heading'>Konfirmasi Delete</div>";
                } 
                  echo "<div class='panel-body' style='width:100%;'>";
                    echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Nama'>Nama Pemesanan : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";                
                      $sql6 = "SELECT * FROM toko01 order by id";
                      $result6 = $con->query($sql6);
                      echo "<select id='addtoko' class='form-control input-xlarge' name='addtoko'>";
                        echo "<option value='-1' selected>-Pilih Toko-</option>";                                  
                        while($row6 = $result6->fetch_assoc()) {
                          if($row6["id"] == $rowPemesanan["idToko"]){
                            echo "<option value='".$row6["id"]."' selected>" . $row6["toko"] . "</option>";                
                          }
                          else{
                            echo "<option value='".$row6["id"]."'>" . $row6["toko"] . "</option>";                 
                          }
                        }
                      echo "</select>";
                      echo "<span class='text-danger'>$tokoErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";  
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Produk'>Produk : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      $sql7 = "SELECT * FROM produk01 order by id";
                      $result7 = $con->query($sql7);                
                      echo "<select id='addproduk' class='form-control input-xlarge' name='addproduk'>";
                        echo "<option value='-1' selected>-Pilih Produk-</option>";                
                        while($row7 = $result7->fetch_assoc()) {
                          if($row7["id"] == $rowPemesanan["idProduct"]){
                            echo "<option value='".$row7["id"]."' selected>" . $row7["produk"] . "</option>";                
                          }
                          else{
                            echo "<option value='".$row7["id"]."'>" . $row7["produk"] . "</option>";                  
                          }
                        }
                      echo "</select>";
                      echo "<span class='text-danger'>$addprodukErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                             
                      if($produk != ""){   
                        $sql8 = "SELECT * FROM produk01 where id = '".$rowPemesanan["idProduct"]."' order by id";
                        $result8 = $con->query($sql8);        
                        $row8 = $result8->fetch_assoc();       
                        echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for=''></label>";
                        echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                        echo "Harga Lama : Rp. " . number_format($row8["hargalama"],2,',','.') . "&emsp;"; 
                        echo "Harga Baru : Rp. " . number_format($row8["hargabaru"],2,',','.') ; 
                        echo "</div>";
                        echo "<div class='visible-xs col-xs-12'>";
                        echo "Harga Lama : Rp. " . number_format($row8["hargalama"],2,',','.') . "&emsp;"; 
                        echo "Harga Baru : Rp. " . number_format($row8["hargabaru"],2,',','.') ; 
                        echo "</div>";
                        echo "<div class='clearfix visible-xs-block'></div>";
                        echo "<div class='clearfix visible-sm-block'></div>";
                        echo "<div class='clearfix visible-md-block'></div>";
                        echo "<div class='clearfix visible-lg-block'></div>";    
                      }
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='tglkirim'>Harga Kirim : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      echo "<input type='text' class='form-control' id='hargaKirim' name='hargaKirim' placeholder='Harga Kirim' value='".$rowPemesanan['hargaKirim']."'>";
                      echo "<span class='text-danger'>$hargaKirimErr</span>";                        
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";          
                      echo "</div>";           
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='tglkirim'>Jumlah Kirim : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      echo "<input type='text' class='form-control' id='jmlKirim' name='jmlKirim' placeholder='Jumlah Kirim' value='".$rowPemesanan['jumlahKirim']."'>";
                      echo "<span class='text-danger'>$jmlKirimErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                          
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='tglkirim'>Tanggal Kirim : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      $tglKirim2 = DateTime::createFromFormat('Y-m-d', $rowPemesanan['tanggalKirim'])->format('d/m/Y');    
                      echo "<input type='text' class='form-control' id='datepicker' name='tglKirim' placeholder='DD / MM / YYYY' value='".$tglKirim2."'>";
                      echo "<span class='text-danger'>$TglKirimErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                   
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='tglkirim'>Jumlah Kembali : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";
                      echo "<input type='text' class='form-control' id='jmlKembali' name='jmlKembali' placeholder='Jumlah Kembali' value='".$rowPemesanan['jumlahKembali']."'>";
                      echo "<span class='text-danger'>$jmlKirimErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                    
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='tglKembali'>Tanggal Kembali : </label>";
                      echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";      
                      if($rowPemesanan['tanggalKembali']){
                        $tglKembali2 = DateTime::createFromFormat('Y-m-d', $rowPemesanan['tanggalKembali'])->format('d/m/Y');
                      }
                      else{$tglKembali2 = "dd/mm/yyyy";}
                      echo "<input type='text' class='form-control' id='datepicker2' name='tglKembali' placeholder='DD / MM / YYYY' value='".$tglKembali2."'>";
                      echo "<span class='text-danger'>$TglKirimErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                                   
                      echo "</div>";                              
                    echo "</div>";
                  echo "<div class='panel-footer clearfix'>";
                      echo "<div class='pull-right'>";                    
                          echo "<button type='submit' class='btn btn-default' name='cancelTiket' value='" . $rowPemesanan['kode_pemesanan'] . "'>Cancel</button>&emsp;";
                          if((isset($_POST["hapus"]) && $kode == $rowPemesanan['kode_pemesanan'])){ 
                            echo "<button type='submit' class='btn btn-primary' name='confirm' value='" . $rowPemesanan['kode_pemesanan'] . "'>Konfirmasi</button>&emsp;";
                          }
                          else{
                            echo "<button type='submit' class='btn btn-primary' name='saveTiket' value='" . $rowPemesanan['kode_pemesanan'] . "'>Konfirmasi</button>&emsp;";
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
        <?php if($total != 0){ ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">          
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color:gainsboro;font-size:14px;border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7" style="margin-top: 10px;text-align: right;">
              <p class="">Total Tagihan&emsp;:&emsp; </p>
            </div>        
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="margin-top: 10px;">
              <p class="text-right">Rp. <?php echo number_format($total,2,',','.'); ?></p>
            </div>        
          </div>
        </div>
        <?php } ?>
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