<html>
<?php include 'menu.php'; ?>
<?php
  $flagForm = -1;
  $err = $tglTransferErr = $resiErr = "";
  $pemesanan = $alamatPemesanan = $jmlKirim = $resi = $kodeTrans = "";
  $tglTransfer = date('d/m/Y');

  if(isset($_POST["kode"]) && $_POST["kode"] != ""){
    $kode = $_POST["kode"];
  }
  else{$kode = "";}
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["bayar"]) && $_POST["bayar"] != ""){
      $kode = test_input($_POST["bayar"]);
      $kodeTrans = $_POST["kodeTrans"] = "bayar";
    }
    if(isset($_POST["kirim"]) && $_POST["kirim"] != ""){
      $kode = test_input($_POST["kirim"]);
      $kodeTrans = $_POST["kodeTrans"] = "kirim";
    }
    if(isset($_POST["detail"]) && $_POST["detail"] != ""){
      $kode = test_input($_POST["detail"]);
      $kodeTrans = $_POST["kodeTrans"] = "detail";
    }
    if(isset($_POST["cancelTiket"]) && $_POST["cancelTiket"] != ""){
      $kodeTrans = $_POST["kodeTrans"] = "cancel";
    }
    if(isset($_POST["confirm"]) && $_POST["confirm"] != ""){
      $kodeTrans = $_POST["kodeTrans"] = "cancel";
    }
    if(isset($_POST["kodeTrans"]) && $_POST["kodeTrans"] != ""){
      $kodeTrans = $_POST["kodeTrans"];
    }

    if((isset($_POST["confKirim"]) && $_POST["confKirim"] != "") || (isset($_POST["confBayar"]) && $_POST["confBayar"] != "")){
      $flagForm = 1;
      $success = "";
      if((isset($_POST["confKirim"]) && $_POST["confKirim"] != "") || (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "")){
        if (!isset($_POST["resi"]) || $_POST["resi"] == "") {
          $err = $resiErr = "Silakan isi resi yang diinginkan"; 
          $flagForm = 0; 
        } 
        else { 
          $resi = addslashes($_POST["resi"]); 
        }        
      }
      if($flagForm == 1 && (isset($_POST["addPemesanan"]) && $_POST["addPemesanan"] != "")){ 
        $tgl = date('Y-m-d H:i:s');          
        $tglKirim = DateTime::createFromFormat('d/m/Y', $tglKirim)->format('Y-m-d');       

        $sql2 = "insert into pemesanan(idtoko, idproduct, jumlahKirim, hargaKirim, tanggalkirim, insert_at) values ('$toko', '$produk', '$jmlKirim', '$hargaKirim', '$tglKirim', '$tgl')";
        $result2 = $con->query($sql2);

        $success = "Berhasil tambah Pemesanan";
        $kodeTrans = $_POST["kodeTrans"] = "cancel";        
      }
      else if($flagForm == 1 && (isset($_POST["saveTiket"]) && $_POST["saveTiket"] != "")){ 
        $tgl = date('Y-m-d H:i:s');        
      
        $tglKirim = DateTime::createFromFormat('d/m/Y', $tglKirim)->format('Y-m-d');          
        $tglKembali = DateTime::createFromFormat('d/m/Y', $tglKembali)->format('Y-m-d');
        $kodePemesanan = test_input($_POST["saveTiket"]);     
        
        $sql2 = "update pemesanan set idtoko = '$toko', idproduct = '$produk', jumlahKirim ='$jmlKirim', hargakirim ='$hargaKirim', jumlahKembali ='$jmlKembali', tanggalKirim = '$tglKirim', tanggalKembali = '$tglKembali', update_at = '$tgl' where kode_pemesanan = '$kodePemesanan'";

        $result2 = $con->query($sql2);
        $success = "Berhasil ubah Pemesanan";

        $kodeTrans = $_POST["kodeTrans"] = "cancel";      
      }
      else if($flagForm == 1 && (isset($_POST["confirm"]) && $_POST["confirm"] != "")){ 
        $kodePemesanan = test_input($_POST["confirm"]);     
        $sql2 = "delete from pemesanan where kode_pemesanan = '$kodePemesanan'";
        $result2 = $con->query($sql2);
        $success = "";

        $kodeTrans = $_POST["kodeTrans"] = "cancel";
        // echo "$sql2";
      }
    }
  }
  $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];  
  
  if(isset($_POST["bulanSkrg"]) && $_POST["bulanSkrg"] != -1){$bulanSkrg = $_POST["bulanSkrg"] +1;}
  else{$bulanSkrg = date('m');}

  $sqlPemesanan = "SELECT * FROM pemesanan p join users u on p.id_user = u.id order by p.kode_pemesanan desc";
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
  <title>Pemesanan</title>
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
      width: 400px;
    }

    .thumbnail:hover span{ /*CSS for enlarged image on hover*/
      text-align: center;
      visibility: visible;
      top: -300px;      
      left: -350px; /*position where enlarged image should offset horizontally */
      width: 410px;      
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
  </script>
</head>
<body style="z-index: -1;">  
  <?php include 'carousel.php'; ?>
  <div class="container" style="min-height: 458px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" > 
      <form class="form-horizontal" id="pemesanan" name="pemesanan" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="">
        <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode;?>" placeholder="kode" readonly>
        <input type="hidden" class="form-control" id="kodeTrans" name="kodeTrans" value="<?php echo $kodeTrans;?>" placeholder="kodeTrans" readonly>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
          <?php
            if($flagForm == 1 && (isset($_POST["confirm"]) && $_POST["confirm"] != "")){}
            else{
              if($flagForm == 1){
                echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!</strong> $success </div>";
              }
              else if($flagForm == 0){
                echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> Error!</strong> $err </div>";
              }             
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
            <?php                            
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
          <div class="hidden-xs hidden-sm col-md-12 col-lg-12" style="background-color:white;font-size:14px;border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <div class="col-xs-12 col-sm-2 col-md-3 col-lg-2">
              <p class="text-center">Kode Pemesanan</p>
            </div>       
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-4">
              <p class="text-left">Pemesan</p>                            
            </div> 
            <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
              <p class="text-center">Status</p>                          
            </div>     
            <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
              <p class="text-center">Tagihan</p>                          
            </div>     
            <div class="visible-lg col-lg-2">
              <p class="" style="text-align: center;">Action</p>                          
            </div> 
          </div>
          <div class="visible-xs col-xs-12 visible-sm col-sm-12" style="background-color:gainsboro;font-size:14px;border: 1px solid gainsboro;padding: 5px;margin-right: 25px;">
            <p style="text-align: center;">Detail Pemesanan</p>
          </div>
        </div>
        <?php 
          $total = 0;
          while($rowPemesanan = $resultPemesanan->fetch_assoc()) { 
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="<?php echo $rowPemesanan['kode_pemesanan']; ?>">    
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divhover" style="border: 1px solid gainsboro;padding: 5px;margin-right: 25px;font-size: 14px;">
            <br/>            
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">        
              <p class="visible-sm col-sm-12" style="text-align: left;"><?php echo "Kode Pemesanan : <br/>" . $rowPemesanan['kode_pemesanan']; ?></p>
              <p class="hidden-sm" style="text-align: center;"><?php echo $rowPemesanan['kode_pemesanan']; ?><br/></p>     
              <p class="hidden-lg col-sm-12" style="text-align: center;"><?php echo "Tagihan : <br/>" . "Rp. " . number_format($rowPemesanan['total_bayar'],2,',','.'); ?></p>  
              <p class='label-success' style='color:white;'><?php echo $rowPemesanan["kode_resi"]; ?></p>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-4">        
              <p style="text-align: left;"><?php echo "<span class='glyphicon glyphicon-user'></span> : " . $rowPemesanan['name']; ?></p>              
              <p style="text-align: left;"><?php echo "<span class='glyphicon glyphicon-envelope'></span> : " . $rowPemesanan['email']; ?></p>  
            </div>   
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">    
              <?php
                if($rowPemesanan['status_bayar'] == "0"){                  
                  echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center'><p class='label-danger' style='color:white;'>Belum Dibayar</p></div>";
                }
                else{
                  echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center'><p class='label-success' style='color:white;'>Sudah Dibayar</p></div>";
                }           
                if($rowPemesanan['status_kirim'] == "0"){                  
                  echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center'><p class='label-danger' style='color:white;'>Belum Dikirim</p></div>";
                }
                else{
                  echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center'><p class='label-success' style='color:white;'>Sudah Dikirim</p></div>";
                }
              ?>
            </div>          
            <div class="visible-lg col-lg-2">     
              <p class="col-lg-12" style="text-align: center;"><?php echo "Rp. " . number_format($rowPemesanan['total_bayar'],2,',','.'); ?></p>  
            </div>         
            <div class='clearfix visible-sm-block'></div>           
            <div class='clearfix visible-xs-block'></div>   
            <?php            
              if((isset($_POST["bayar"]) && $kode == $rowPemesanan['kode_pemesanan']) || (isset($_POST["kirim"]) && $kode == $rowPemesanan['kode_pemesanan']) || (isset($_POST["detail"]) && $kode == $rowPemesanan['kode_pemesanan'])){  
              }
              else{
            ?>
              <div class="hidden-lg">    
                <?php                 
                  if($rowPemesanan['status_bayar'] == "0"){
                    echo "<div class='col-xs-12 col-sm-12 col-md-2 col-lg-12 pull-right' style='margin-top:2px;text-align:left;'>";     
                    echo "<button type='submit' style='font-size:14px;' class='btn btn-xs btn-primary' name='bayar' value='" . $rowPemesanan['kode_pemesanan'] . "'>Cek Pembayaran</button>"; 
                    echo "</div>";
                  }
                  if($rowPemesanan['status_bayar'] == "1" && $rowPemesanan['status_kirim'] == "0"){
                    echo "<div class='col-xs-12 col-sm-12 col-md-2 col-lg-12 pull-right' style='margin-top:2px;text-align:left;'>";                        
                    echo "<button type='submit' style='font-size:14px;margin-right:20px;' class='btn btn-xs btn-success' name='kirim' value='" . $rowPemesanan['kode_pemesanan'] . "'>Data Pengiriman</button>"; 
                    echo "</div>";
                  }
                  echo "<div class='col-xs-12 col-sm-12 col-md-2 col-lg-12 pull-right' style='margin-top:2px;text-align:left;'>";      
                  echo "<button type='submit' style='font-size:14px;margin-right:20px;' class='btn btn-xs btn-info' name='detail' value='" . $rowPemesanan['kode_pemesanan'] . "'>Lihat Detail</button>"; 
                  echo "</div>";
                ?>
              </div>       
              <div class="visible-lg col-lg-2">    
                <?php                 
                  if($rowPemesanan['status_bayar'] == "0"){
                    echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:2px;text-align:left;'>";     
                    echo "<button type='submit' style='font-size:14px;' class='btn btn-xs btn-primary' name='bayar' value='" . $rowPemesanan['kode_pemesanan'] . "'>Cek Pembayaran</button>"; 
                    echo "</div>";
                  }
                  if($rowPemesanan['status_bayar'] == "1" && $rowPemesanan['status_kirim'] == "0"){
                    echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:2px;text-align:left;'>";                        
                    echo "<button type='submit' style='font-size:14px;margin-right:20px;' class='btn btn-xs btn-success' name='kirim' value='" . $rowPemesanan['kode_pemesanan'] . "'>Data Pengiriman</button>"; 
                    echo "</div>";
                  }
                  echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:2px;text-align:left;'>";      
                  echo "<button type='submit' style='font-size:14px;margin-right:20px;' class='btn btn-xs btn-info' name='detail' value='" . $rowPemesanan['kode_pemesanan'] . "'>Lihat Detail</button>"; 
                  echo "</div>";
                ?>
              </div>       
            <?php              
              }
              if(((isset($_POST["bayar"]) || $kodeTrans == "bayar") && $kode == $rowPemesanan['kode_pemesanan']) || ((isset($_POST["kirim"]) || $kodeTrans == "kirim") && $kode == $rowPemesanan['kode_pemesanan']) || ((isset($_POST["detail"]) || $kodeTrans == "detail") && $kode == $rowPemesanan['kode_pemesanan'])){                     
                if(isset($_POST["bayar"]) || $kodeTrans == "bayar"){
                  echo "<div class='panel panel-primary col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:10px;'>";
                  echo "<div class='panel-heading'>Konfirmasi Pembayaran</div>";
                } 
                else if(isset($_POST["kirim"]) || $kodeTrans == "kirim"){
                  echo "<div class='panel panel-success col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:10px;'>";
                  echo "<div class='panel-heading'>Konfirmasi Pengiriman</div>";
                } 
                else if(isset($_POST["detail"]) || $kodeTrans == "detail"){
                  echo "<div class='panel panel-info col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:10px;'>";
                  echo "<div class='panel-heading'>Konfirmasi</div>";
                } 
                $sqlData = "SELECT * FROM pemesanan p join users u on p.id_user = u.id join pemesanan_detail d on p.kode_pemesanan = d.kode_pemesanan join produk pd on d.id_barang = pd.id where d.kode_pemesanan = '" . $rowPemesanan["kode_pemesanan"] . "' order by p.kode_pemesanan"; 
                // echo $sqlData;             
                $resultData = $con->query($sqlData);
              ?>
              <div class='clearfix visible-xs-block'></div>
              <div class='clearfix visible-sm-block'></div>
              <div class='clearfix visible-md-block'></div>
              <div class='clearfix visible-lg-block'></div>
              <hr/>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">        
                  <p style="text-align: left;">Penerima : <br/></p>  
                  <p style="text-align: left;margin-left: 5px;"><?php echo "<span class='glyphicon glyphicon-user'></span> : " . $rowPemesanan['nama_penerima']; ?><br/></p>  
                  <p style="text-align: left;margin-left: 5px;"><?php echo "<span class='glyphicon glyphicon-phone'></span> : " . $rowPemesanan['no_telp']; ?><br/></p>  
                  <p style="text-align: left;margin-left: 5px;"><?php echo "<span class='glyphicon glyphicon-envelope'></span> : " . $rowPemesanan['email']; ?><br/></p>  
                </div>        
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">        
                  <p style="text-align: left;"><?php echo "Alamat Lengkap :<br/>" . $rowPemesanan['alamat_lengkap'] . "<br/>" . $rowPemesanan['kota'] . ", " . $rowPemesanan['provinsi'] . "<br/>" . $rowPemesanan['kode_pos']; ?><br/></p>  
                </div>                 
                <div class="col-sm-4 col-md-2 col-lg-2">        
                  <p class="text-left" style=""><?php echo "Harga Barang  : "; ?></p>
                  <p class="text-left" style=""><?php echo "Ongkos Kirim  : "; ?></p> 
                  <p class="text-left" style=""><?php echo "Total Tagihan : "; ?></p>  
                </div>    
                <div class="col-sm-4 col-md-2 col-lg-2">        
                  <p class="text-right" style=""><?php echo number_format($rowPemesanan['total_harga'],2,',','.'); ?></p>
                  <p class="text-right" style=""><?php echo number_format($rowPemesanan['total_ongkir'],2,',','.'); ?></p> 
                  <p class="text-right" style=""><?php echo number_format($rowPemesanan['total_bayar'],2,',','.'); ?></p>  
                </div>    
              </div>                                      
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">     
                <hr/>   
                <p style="text-align: left;margin-left: 10px;">Detail Produk Pesanan<br/></p>               
              <?php
                while($rowData = $resultData->fetch_assoc()) { 
              ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">       
                  <p style="text-align: left;"><?php echo $rowData['produk']; ?><br/></p>  
                  <div class="col-sm-4 col-md-2 col-lg-5">        
                    <p class="text-left" style=""><?php echo "Jumlah : "; ?></p>
                    <p class="text-left" style=""><?php echo "Harga&nbsp;&nbsp;: "; ?></p> 
                  </div>    
                  <div class="col-sm-4 col-md-2 col-lg-7">        
                    <p class="text-left" style=""><?php echo $rowData['qty'] ?></p> 
                    <p class="text-left" style=""><?php echo number_format($rowData['harga'],2,',','.'); ?></p> 
                  </div>   
                  </div>                
                
              <?php
                }                           
                echo "</div>";
                $sqlBayar = "SELECT * FROM pemesanan p join list_pembayaran b on p.kode_pemesanan = b.kode_pemesanan where p.kode_pemesanan = '" . $rowPemesanan["kode_pemesanan"] . "' order by p.kode_pemesanan"; 
                // echo $sqlBayar;             
                $resultBayar = $con->query($sqlBayar);      
                if((isset($_POST["bayar"])  || $kodeTrans == "bayar") && $kode == $rowPemesanan['kode_pemesanan']){                   
              ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">       
                  <hr/>
                  <p style="text-align: left;margin-left: 10px;">Detail Pembayaran<br/></p>  
                  <?php
                    if($resultBayar->num_rows == 0){
                      echo "<p style='text-align: left;margin-left: 20px;'>User belum melakukan konfirmasi pembayaran<br/></p>";
                      echo "<p style='text-align: left;margin-left: 20px;'>Jika user sudah menghubungi langsung untuk konfirmasi pembayaran, masukkan data berikut:<br/></p>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-6 col-md-5 col-lg-5' for='Nama'>Terima Transfer Dari : </label>";
                      echo "<div class='col-xs-12 col-sm-6 col-md-7 col-lg-7'>";
                      echo "<input type='text' class='form-control' id='resi' name='resi' value='$resi' autofocus>";   
                      echo "<span class='text-danger'>$resiErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";     
                      echo "</div>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-6 col-md-5 col-lg-5' for='Nama'>Jumlah Transfer : </label>";
                      echo "<div class='col-xs-12 col-sm-6 col-md-7 col-lg-7'>";
                      echo "<input type='text' class='form-control' id='resi' name='resi' value='$resi' autofocus>";   
                      echo "<span class='text-danger'>$resiErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";     
                      echo "</div>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-6 col-md-5 col-lg-5' for='tglkirim'>Tanggal Transfer : </label>";
                      echo "<div class='col-xs-12 col-sm-6 col-md-7 col-lg-7'>";
                      echo "<input type='text' class='form-control' id='datepicker' name='tglTransfer' placeholder='DD / MM / YYYY' value='".$tglTransfer."'>";
                      echo "<span class='text-danger'>$tglTransferErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";
                      echo "<div class='clearfix visible-sm-block'></div>";
                      echo "<div class='clearfix visible-md-block'></div>";
                      echo "<div class='clearfix visible-lg-block'></div>";                
                      echo "</div>";                   
                    }
                    while($rowBayar = $resultBayar->fetch_assoc()) { 
                  ?>                  
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border:1px solid gainsboro;">  
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">   
                      <div class="hidden-xs col-sm-3 col-md-12 col-lg-12" style="text-align: center;">
                        <p style="text-align: left;">Bukti Pembayaran : <br/></p>  
                        <?php 
                          echo "<a class='thumbnail' href='#thumb'><img class='img-responsive' style='margin: auto;left: 0;right: 0;' src='../" . $rowBayar['path_bukti'] . "' alt='produk'><span><img src='../" . $rowBayar['path_bukti'] . "' /><br />" . $rowBayar['path_bukti'] . "</span></a>";                          
                        ?>              
                      </div>
                      <div class="visible-xs col-xs-12">
                        <?php 
                          echo "<img class='img-responsive' style='height:100px;margin: auto;left: 0;right: 0;' src='../" . $rowBayar['path_bukti'] . "' alt='produk'>";
                        ?>        
                      </div>       
                    </div>     
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">   
                      <div class="col-sm-4 col-md-12 col-lg-12" style="margin-top:10px;">                              
                        <p class="text-left" style=""><?php echo "A/n : " . $rowBayar['nama_pemilik_rekening']; ?></p>
                        <p class="text-left" style=""><?php echo "Jumlah Transfer : ". number_format($rowBayar['jumlah_transfer'],2,',','.'); ?></p>   
                        <p class="text-left" style=""><?php echo "Catatan : ". $rowBayar['catatan']; ?></p>
                        <hr/>                                 
                      </div>    
                    </div>       
                  </div>
                  <?php
                   }
                  ?>
                </div>              
              <?php                
              }                 
              else if((isset($_POST["kirim"]) || $kodeTrans == "kirim") && $kode == $rowPemesanan['kode_pemesanan']){ 
                // echo "<hr/>";
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-8' for='Nama'>Masukkan Nomor Resi : </label>";
                echo "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-4'>";
                echo "<input type='text' class='form-control' id='resi' name='resi' value='$resi' autofocus>";   
                echo "<span class='text-danger'>$resiErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";     
                echo "</div>";
              }
              // echo "</div>";
              echo"<div class='clearfix visible-xs-block'></div>";
              echo"<div class='clearfix visible-sm-block'></div>";
              echo"<div class='clearfix visible-md-block'></div>";
              echo"<div class='clearfix visible-lg-block'></div>";
              echo "<div class='panel-footer clearfix' >";
                echo "<div class='pull-right'>";                    
                  if((isset($_POST["detail"]) || $kodeTrans == "detail") && $kode == $rowPemesanan['kode_pemesanan']){ 
                    echo "<button type='submit' class='btn btn-primary' name='confirm' value='" . $row['id'] . "'>Tutup</button>&emsp;";
                  }
                  else if((isset($_POST["bayar"]) || $kodeTrans == "bayar") && $kode == $rowPemesanan['kode_pemesanan']){ 
                    echo "<button type='submit' class='btn btn-default' name='cancelTiket' value='" . $row['id'] . "'>Cancel</button>&emsp;";                  
                    echo "<button type='submit' class='btn btn-primary' name='confBayar' value='" . $row['id'] . "' autofocus>Konfirmasi Bayar</button>&emsp;";
                  }
                  else if((isset($_POST["kirim"]) || $kodeTrans == "kirim") && $kode == $rowPemesanan['kode_pemesanan']){ 
                    echo "<button type='submit' class='btn btn-default' name='cancelTiket' value='" . $row['id'] . "'>Cancel</button>&emsp;";                  
                    echo "<button type='submit' class='btn btn-primary' name='confKirim' value='" . $row['id'] . "'>Konfirmasi Resi</button>&emsp;";
                  }
                echo "</div>";
              echo "</div>"; 
              echo "</div>"; 
            }
            ?> 
          </div>
        </div>            
        <?php 
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