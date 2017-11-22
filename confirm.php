<?php include 'menu.php'; ?>
<?php
  $uploadImgOk = 1;
  $flagForm = 1;
  $msg = "Masukkan Email & Kode Pemesanan"; 
  if(isset($_POST['btn_cari']) || isset($_POST['btn_konfirmasi']))
  {
    if(!isset($_POST['kode_pesan'], $_POST['email'])) 
    {
      $msg = "Masukkan Email & Kode Pemesanan";  
    }
    else
    {
      $kode_pesan = $_POST['kode_pesan'];
      $email = $_POST['email'];
      $sql_header = "SELECT * FROM pemesanan WHERE kode_pemesanan='".$kode_pesan."' AND email='".$email."'";
      $result_header = $con->query($sql_header);
      
      if($result_header->num_rows <= 0)
      {
        $msg = "Kode Pemesanan / Email Tidak Ditemukan";
      }
      else
      {
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
        $msg = "";
        // echo "<br><br><br><br><br><pre>";
        // print_r($row_detail);
        // echo "</pre>";
      }
    }

    if(isset($_POST['btn_konfirmasi']))
    {
      if(!isset($_POST['nama_pemilik_rekening']) || $_POST['nama_pemilik_rekening'] =="")
        $msg2="Nama Pemilik Rekening harus diisi";
      else if(!isset($_POST['jumlah_transfer']) || $_POST['jumlah_transfer'] =="")
        $msg2="Jumlah Transfer harus diisi";
      else if(!isset($_POST['tgl_kirim']) || $_POST['tgl_kirim'] =="")
        $msg2="Tanggal transfer harus diisi";
      else if(!empty($_FILES) && $_FILES['imageProduct']['error']!=4)
      {        
        if($_FILES["imageProduct"]['name'])
        {
          $valid_file = true;
          if(!$_FILES['imageProduct']['error'])
          {
            if($_FILES['imageProduct']['size'] > (10240000)){$valid_file = false;}
            if($valid_file)
            {
              $allowedExts = array("gif", "jpeg", "jpg", "png");
              $temp = explode(".", $_FILES["imageProduct"]["name"]);
              //$extension = end($temp);
              $extension = "jpg";
              if ((($_FILES["imageProduct"]["type"] == "image/gif") || ($_FILES["imageProduct"]["type"] == "image/jpeg") || ($_FILES["imageProduct"]["type"] == "image/jpg") || ($_FILES["imageProduct"]["type"] == "image/pjpeg") || ($_FILES["imageProduct"]["type"] == "image/x-png") || ($_FILES["imageProduct"]["type"] == "image/png")) && in_array($extension, $allowedExts))
              {
                $date = date('YmdHis');

                //ganti ini ketika ingin diubah ke hosting
                $root = $_SERVER['DOCUMENT_ROOT']."/hibahibm";
                $imgPath = "/image/01/bukti_transfer/";
                $uploadpath =  $root . $imgPath;
                // echo $uploadpath."<br>";
                if(!file_exists($uploadpath))
                {
                  mkdir ($uploadpath);
                } 
                //$filenameImg = $imgPath . "produk" . uniqid() . "." . $extension;
                $filenameImg = $imgPath . $_POST['kode_pesan']. "." . $extension;
                $fullfilename = $root . $filenameImg;
                $image = $_FILES["imageProduct"]["tmp_name"];         

                if (file_exists($fullfilename)) unlink($fullfilename);  
                $tgl_kirim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['tgl_kirim'])));  
                if(GenerateThumbnail($image, $fullfilename, 600, 800, 0.80) == 0)
                {
                  $sql_check = "SELECT * FROM list_pembayaran WHERE kode_pemesanan='".$_POST['kode_pesan']."'";
                  $result_check = $con->query($sql_check);

                  if($result_check->num_rows > 0)
                  {
                    $sql = "UPDATE list_pembayaran SET nama_pemilik_rekening='".$_POST['nama_pemilik_rekening']."', jumlah_transfer=".$_POST['jumlah_transfer'].",tanggal='".$tgl_kirim."',catatan='".$_POST['catatan']."' WHERE kode_pemesanan='".$_POST['kode_pesan']."'";
                  }
                  else
                  {
                    $sql = "INSERT INTO `list_pembayaran`(`kode_pemesanan`, `email`, `nama_pemilik_rekening`, `jumlah_transfer`, `tanggal`, `catatan`, `path_bukti`, `status_bayar`, `status_check`) VALUES ('".$_POST['kode_pesan']."','".$_POST['email']."','".$_POST['nama_pemilik_rekening']."',".$_POST['jumlah_transfer'].",'".$tgl_kirim."','".$_POST['catatan']."','".$filenameImg."',0,0);";
                  }

                  $con->query($sql);
                  $uploadImgOk = 1;
                  $success="Konfirmasi sukses";
                }
                else{$uploadImgOk = $flagForm=0;}                
              }
              else{$uploadImgOk = $flagForm=0;}                
            }
            else{$uploadImgOk = $flagForm=0;}
          }
          else{
            $uploadImgOk = $flagForm = 0;
            $msg2 = cek_error($_FILES['imageProduct']['error']);
          }
        }  
      }
      else if(empty($_FILES) || $_FILES['imageProduct']['error'] ==4)
      {
        $msg2 = "File harus dipilih";
      }
      // print_r($_FILES);
    }

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
  <title>Confirm</title>
  <link rel="shortcut icon" type="image/jpg" href="image/logo/logo01.j<?php echo $logo; ?>" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/jquery-ui-1.12.1.custom/jquery-ui.css">
  <script src="css/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
  <script src="css/jquery-ui-1.12.1.custom/jquery-ui.js"></script> 
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
    <script>
    $(function () {
      $('#datepicker').datepicker({
          dateFormat: 'dd/mm/yy',
          showButtonPanel: true,
          changeMonth: true,
          changeYear: true,
          minDate: '-2Y',
          maxDate: '+0',
          inline: true
      });
    });
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
    <form name="pengiriman" method="POST" action="confirm.php">
      <div class="container" id="grad4">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4 style="color:white;margin-top: 15px;text-align: left;">Konfirmasi Pembayaran</h4>  
        </div>          
      </div>
      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='border: 1px solid gainsboro;padding: 5px;margin-right: 25px;'>
        <br/>      
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="form-group">
            <label class="col-xs-12 col-sm-6 col-md-4 col-lg-4 control-label" for="nameoftheorganisation" style="margin-top:6px;">Kode Pemesanan : </label>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 controls">
              <input type="text" class="form-control" name="kode_pesan" placeholder="Kode Pemesanan" value="<?php echo isset($_POST['kode_pesan'])?$_POST['kode_pesan']:'';?>">
            </div>     
          </div>
          <div class='clearfix visible-xs-block'></div>
          <div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div>
          <div class='clearfix visible-lg-block'></div> 
        </div>    
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="form-group">
            <label class="col-xs-12 col-sm-5 col-md-3 col-lg-3 control-label" for="nameoftheorganisation" style="margin-top:6px;">Email : </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 controls">
              <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo isset($_POST['email'])?$_POST['email']:'';?>">
            </div>     
            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 controls pull-right" style="margin-top: 2px;">                       
              <button type="submit" class="btn btn-info pull-right" name="btn_cari">
                <span class="glyphicon glyphicon-search"></span> Cari
              </button>
            </div>
            <div class='clearfix visible-xs-block'></div>
            <div class='clearfix visible-sm-block'></div>
            <div class='clearfix visible-md-block'></div>
            <div class='clearfix visible-lg-block'></div> 
          </div>
        </div>            
      </div>
      <div class='clearfix visible-xs-block'></div>
      <div class='clearfix visible-sm-block'></div>
      <div class='clearfix visible-md-block'></div>
      <div class='clearfix visible-lg-block'></div>  
    </form>
    <?php 
      if($msg != ""){       
      }
      else
      {
    ?>
    <div class="container hidden-xs" id="grad4">        
      <div class="hidden-xs col-sm-12 col-md-12 col-lg-12">        
        <h4 style="color:white;margin-top: 15px;text-align: center;">Kode Pemesanan - 
          <?php
            echo isset($_POST['kode_pesan'])?$_POST['kode_pesan']:'';
          ?>          
        </h4>
        <div class='clearfix visible-xs-block'></div>
        <div class='clearfix visible-sm-block'></div>
        <div class='clearfix visible-md-block'></div>
        <div class='clearfix visible-lg-block'></div>  
      </div>
    </div>
    <div class="container visible-xs" id="grad4" style="height:70px;">  
      <div class="visible-xs col-xs-12">        
        <h4 style="color:white;margin-top: 15px;margin-bottom: 15px;text-align: center;">Kode Pemesanan <br/>
          <?php
            echo isset($_POST['kode_pesan'])?$_POST['kode_pesan']:'';
          ?>          
        </h4>
        <div class='clearfix visible-xs-block'></div>
        <div class='clearfix visible-sm-block'></div>
        <div class='clearfix visible-md-block'></div>
        <div class='clearfix visible-lg-block'></div>  
      </div>
    </div>
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='border: 1px solid gainsboro;padding: 5px;margin-right: 25px;'>
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
      <div class='clearfix visible-lg-block'></div>  
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
      <div class='clearfix visible-lg-block'></div>  
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-label" for="kota">Kota</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8 form-label" for="kota"><?php echo $row_head['kota']; ?></label>          
        </div> 
      </div>  
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 form-label" for="kodepos">Kode Pos</label>
          <label class="col-xs-12 col-sm-12 col-md-8 col-lg-8 form-label" for="kodepos"><?php echo $row_head['kode_pos']; ?></label>          
        </div>
      </div>
      <div class='clearfix visible-lg-block'></div>  
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
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='border: 1px solid gainsboro;padding: 5px;margin-right: 25px;'>     
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>&nbsp;Ringkasan Belanja<hr/></h4>
        <?php
          $subtotal = 0;
          for($i=0; $i<count($row_detail); $i++) {
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<div class="hidden-xs col-sm-3 col-md-2 col-lg-2"><img src="'.$row_detail[$i]['image'].'"class="img-responsive" style="height:150px;"></div>';
            echo '<div class="visible-xs col-xs-12"><img src="'.$row_detail[$i]['image'].'"class="img-responsive"></div>';
            echo '<div class="col-xs-12 col-sm-3 col-md-4 col-lg-4" style="text-align:center;">'.$row_detail[$i]['produk'].'</div>';
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">Rp. '. number_format($row_detail[$i]['harga'],0,',','.').' x '. $row_detail[$i]['qty'].' pcs </div>';
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">@ '.$row_detail[$i]['berat'].' kg</div>';
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">Rp. ' . number_format($row_detail[$i]['total'],0,',','.') .'</div>';            
            echo '</div>';
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<hr/>';            
            echo '</div>';            
            $subtotal += $row_detail[$i]['total'];
          }

          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";

          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
          echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">Ongkos Kirim</div>';
          echo '<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4" style="text-align:right;">Rp. '.number_format($row_head['harga_per_kg'],0,',','.').' x '.$row_head['total_berat'].' kg </div>';
          echo '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="text-align:right;">Rp. '.number_format($row_head['harga_per_kg']*$row_head['total_berat'],0,',','.').'</div>';
          echo '</div>';
          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
          echo '<hr/>';            
          echo '</div>';                      
          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";
          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color:WhiteSmoke;min-height:50px;">';
          echo '<div class="visible-xs col-xs-12" style="text-align:center;margin-top:5px;"><b>Total Belanja</b><br/><b>Rp. ' . number_format($row_head['total_bayar'],0,',','.') . '</b></div>';
          echo '<div class="hidden-xs col-sm-6 col-md-6 col-lg-6" style="text-align:right;"><b><br/>Total Belanja</b></div>';
          echo '<div class="hidden-xs col-sm-6 col-md-6 col-lg-6" style="text-align:right;"><span><br/><b>Rp. ' . number_format($row_head['total_bayar'],0,',','.') . '</b></span></td></div>';                   
          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";        
        ?>
      </div>
    </div>
      <form method="POST" action="confirm.php" enctype="multipart/form-data">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-top:10px;">          
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
            Nama Pemilik Rekening 
            <input type="text" class="form-control" name="nama_pemilik_rekening" placeholder="Nama Pemilik Rekening" value="<?php echo isset($_POST['nama_pemilik_rekening'])?$_POST['nama_pemilik_rekening']:'';?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
            Jumlah Transfer <input type="text" class="form-control" name="jumlah_transfer" placeholder="Jumlah Transfer" value="<?php echo isset($_POST['jumlah_transfer'])?$_POST['jumlah_transfer']:'';?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
            Tanggal <input type='text' class='form-control' id='datepicker' name='tgl_kirim' placeholder='DD / MM / YYYY' value="<?php echo isset($_POST['tgl_kirim'])?$_POST['tgl_kirim']:'';?>">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
            Catatan (opsional) <textarea class="form-control" name="catatan" placeholder="Catatan"><?php echo isset($_POST['catatan'])?$_POST['catatan']:'';?></textarea>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-top:10px;">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
            Upload Bukti Transfer 
            <input type='file' class='form-control' id='imageProduct' name='imageProduct' accept='image/*' onchange='preview_image(event)'>
            <img id='output_image_product' class='img-responsive' style='max-height:200px;'/>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
        <hr/>            
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
        <input type="hidden" name="kode_pesan" value="<?php echo $kode_pesan; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">        
          <a class="pull-right" href="confirm.php">
            <button type="submit" class="btn btn-success" name="btn_konfirmasi">
              Konfirmasi Pembayaran <span class="glyphicon glyphicon-ok"></span>
            </button>
          </a>            
        </div>
        <div class='clearfix visible-xs-block'></div>
        <div class='clearfix visible-sm-block'></div>
        <div class='clearfix visible-md-block'></div>
        <div class='clearfix visible-lg-block'></div>
        </div>
      </form>
      </div>
      <?php 
        }
      ?>    
      </div>
      <div class='clearfix visible-xs-block'></div>
      <div class='clearfix visible-sm-block'></div>
      <div class='clearfix visible-md-block'></div>
      <div class='clearfix visible-lg-block'></div>
      <div class="container" id="grad4" style="height: 30px;margin-bottom: 10px;">        
        <h4 style="color:white;margin-top: 15px;text-align: center;"><?php echo " "; ?></h4>          
      </div>      
      <div class='clearfix visible-xs-block'></div>
      <div class='clearfix visible-sm-block'></div>
      <div class='clearfix visible-md-block'></div>
      <div class='clearfix visible-lg-block'></div>
      <?php
        if($msg != ""){
           if(isset($_POST['btn_cari'])){ 
            echo"<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>$msg</div>";
          }
        }
        if(isset($msg2) && $msg2!="")
            echo"<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a>$msg2</div>";

        if(isset($success)){
          echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Success!</strong> $success </div>";
        }
        if($flagForm == 0){
          echo "<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> Error!</strong> $msg2 </div>";
        }  
      ?>
      </div>
      </form>
      </div>     
    </div>  

  <?php include 'footer.php'; ?>    
</body>
</html>