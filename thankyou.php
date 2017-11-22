<?php include 'menu.php'; ?>
<?php
date_default_timezone_set ("Asia/Jakarta");
  if(isset($_SESSION['kode_pesan'])) {
    $kode_pesan = $_SESSION['kode_pesan'];
    $sql_header = "SELECT * FROM pemesanan WHERE kode_pemesanan='".$kode_pesan."'";
    $result_header = $con->query($sql_header);
    
    if($result_header->num_rows <= 0)
      header('location: index.php');

    $row_head = $result_header->fetch_assoc();

    $sql_detail = "SELECT * FROM pemesanan_detail WHERE kode_pemesanan='".$kode_pesan."'";
    $result_detail = $con->query($sql_detail);

    $total_berat=0;
    for($i=0; $row_detail_temp = $result_detail->fetch_assoc(); $i++)
    {
      $sql_product = "SELECT * FROM produk WHERE id=".$row_detail_temp['id_barang'];
      $result_product = $con->query($sql_product);
      $row_product = $result_product->fetch_assoc();
      $row_detail[$i]['id'] = $row_detail_temp['id_barang'];
      $row_detail[$i]['harga'] = $row_detail_temp['harga'];
      $row_detail[$i]['berat'] = $row_detail_temp['berat'];
      $row_detail[$i]['qty'] = $row_detail_temp['qty'];
      $row_detail[$i]['image'] = $row_product['image'];
      $row_detail[$i]['produk'] = $row_product['produk'];
      $row_detail[$i]['deskripsi'] = $row_product['deskripsi'];
      $row_detail[$i]['total'] = $row_detail_temp['qty']*$row_detail_temp['harga'];
    }

    $row_head['harga_per_kg'] = $row_head['total_ongkir']/$row_head['total_berat'];

    // echo "<br><br><br><br><br><pre>";
    // print_r($row_detail);
    // echo "</pre>";
  }
  else
  {
      header('location: index.php');
  }
  
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
  <title>Thank You</title>
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
    /* Popover */
    .popover {
        border: 1px solid gainsboro;
    }
    /* Popover Header */
    .popover-title {
        top:-120px;
        background-color: gainsboro; 
        color: black; 
        font-size: 14px;
        text-align:center;
    }
    /* Popover Body */
    .popover-content {
        background-color: white;
        color: black;
        font-size: 12px;
        padding: 15px;
    }
    /* Popover Arrow */
    .arrow {
        border-right-color: gainsboro !important;
    }
  </style>
</head>
<body style="z-index: -1;">  
  <form name="pengiriman">
    <div class="container" style="border: 1px solid gainsboro;margin-top: 53px;">
      <br/>      
      <div class="container" id="grad4">        
        <h4 style="color:white;margin-top: 15px;text-align: center;">Kode Pemesanan - 

        <?php
        echo isset($_SESSION['kode_pesan'])?$_SESSION['kode_pesan']:'';
        ?>
        <span class=" glyphicon glyphicon-info-sign" data-toggle="popover" title="Kode Pemesanan" data-content="Kode Pemesanan ini digunakan untuk mengkonfirmasi pembayaran Anda di halaman konfirmasi pembayaran"></span></h4>
      </div>
      <script>
      $(document).ready(function(){
          $('[data-toggle="popover"]').popover();   
      });
      </script>
      <br/>             
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr/>
      </div>
      <div class='clearfix visible-xs-block'></div>
      <div class='clearfix visible-sm-block'></div>
      <div class='clearfix visible-md-block'></div>
      <div class='clearfix visible-lg-block'></div> 
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 control-label" for="nameoftheorganisation">Nama Penerima</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8"><?php echo $row_head['nama_penerima']; ?></label>          
        </div>
      </div>
      <div class='clearfix visible-xs-block'></div>
      <div class='clearfix visible-sm-block'></div>
      <div class='clearfix visible-md-block'></div>
      <div class='clearfix visible-lg-block'></div>  
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-12 col-lg-4 form-label" for="telp">No. Telepon</label>
          <label class="col-xs-12 col-sm-12 col-md-12 col-lg-8 form-label" for="telp"><?php echo $row_head['nama_penerima']; ?></label>
        </div>        
      </div>      
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-12 col-lg-4 form-label" for="email">Email</label>
          <label class="col-xs-12 col-sm-12 col-md-12 col-lg-8 form-label" for="email"><?php echo $row_head['email']; ?></label>          
        </div>        
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-label" for="alamat_lengkap">Alamat Lengkap</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8 form-label" for="alamat_lengkap"><?php echo $row_head['alamat_lengkap']; ?></label>          
        </div>   
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-label" for="provinsi">Provinsi</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8 form-label" for="provinsi"><?php echo $row_head['provinsi']; ?></label>          
        </div>
      </div>  
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-label" for="kota">Kota</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8 form-label" for="kota"><?php echo $row_head['kota']; ?></label>          
        </div> 
      </div>  
      <div class="col-xs-offset-0 col-xs-12 col-sm-offset-6 col-sm-6 col-md-offset-6 col-md-6 col-lg-offset-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-label" for="kodepos">Kode Pos</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8 form-label" for="kodepos"><?php echo $row_head['kode_pos']; ?></label>          
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr/>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-label" for="jasa">Jasa Pengiriman</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8 form-label" for="jasa"><?php echo $row_head['jasa_pengiriman'].' - '.$row_head['tipe_pengiriman']; ?></label>           
        </div>
      </div>    
    </div>
    <div class="container" style="border-bottom: 1px solid gainsboro;border-left: 1px solid gainsboro;border-right: 1px solid gainsboro;">
      <br/>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>&nbsp;Ringkasan Belanja<hr/></h4>
        <?php
          $subtotal = 0;
          $berat=0;
          for($i=0; $i<count($row_detail); $i++) {
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2"><img src="'.$row_detail[$i]['image'].'"class="img-responsive" style="height:150px;"></div>';
            echo '<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4" style="min-height:110px;">'.$row_detail[$i]['produk'].'</div>';
            echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">Rp. '. number_format($row_detail[$i]['harga'],0,',','.').' x '. $row_detail[$i]['qty'].' pcs (@'.$row_detail[$i]['berat'].' kg)</div>';
            echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">Rp. ' . number_format($row_detail[$i]['total'],0,',','.') .'</div>';            
            echo '</div>';
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<hr/>';            
            echo '</div>';            
            $subtotal += $row_detail[$i]['total'];
            $berat+=$row_detail[$i]['berat'];
          }

          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";

          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
          echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">Ongkos Kirim</div>';
          echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">Rp. '.number_format($row_head['harga_per_kg'],0,',','.').' x '.$berat.' ('.$row_head['total_berat'].' kg)</div>';
          echo '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">Rp. '.number_format($row_head['harga_per_kg']*$row_head['total_berat'],0,',','.').'</div>';
          echo '</div>';
          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
          echo '<hr/>';            
          echo '</div>';                      
          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";
          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color:WhiteSmoke;min-height:50px;">';
          echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;"><b><br/>Total Belanja</b></div>';
          echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;"><span><br/><b>Rp. ' . number_format($row_head['total_bayar'],0,',','.') . '</b></span></td></div>';                   
          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";        
        ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr/>            
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
          <h5>Pembayaran dapat ditransfer ke rekening <br><br></h5>
          <?php 
            $sqlBank = "SELECT * FROM bank order by urutan";
            $resultBank = $con->query($sqlBank);

            while($rowBank = $resultBank->fetch_assoc()) {
              echo "<h5><b>".$rowBank["nama_bank"] . " " . $rowBank["no_rek"] . " atas nama " . $rowBank["pemilik_rek"] "</b><br></h5>";
            }
          ?>
          <h5>Sebesar Rp. <?php echo number_format($row_head['total_bayar'],0,',','.'); ?></h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr/>            
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
          <a class="pull-right" href="confirm.php">
            <button type="button" class="btn btn-success">
              Konfirmasi Pembayaran <span class="glyphicon glyphicon-ok"></span>
            </button>
          </a>            
        </div>
        <div class='clearfix visible-xs-block'></div>
        <div class='clearfix visible-sm-block'></div>
        <div class='clearfix visible-md-block'></div>
        <div class='clearfix visible-lg-block'></div> l
      </div>      
    </div>
  </form>
  <?php include 'footer.php'; ?>    
</body>
</html>