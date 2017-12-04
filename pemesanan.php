<?php include 'menu.php'; ?>
<?php
  if(isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    //print_r($cart);
    foreach ($cart as $key => $value) {
      $sql = "SELECT * FROM produk where id=".$key;
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $id = $key;
      $qty = $value;
      $produk = $row['produk'];
      $price = $row['hargabaru'];
      $berat = $row['beratbaru'];
      $image = $row['image'];
      $total = $qty * $price;
      $deskripsi = $row['deskripsi'];

      $temp = array('id'=>$id,'qty'=>$qty,'produk'=>$produk,'price'=>$price,'beratbaru'=>$berat,'image'=>$image,'total'=>$total,'deskripsi'=>$deskripsi);
      $cart2[$id] = $temp;
    }
    //echo "<pre>";print_r($cart2);echo "</pre>";
  }
  if(!isset($_POST['jasa']))
    $_POST['jasa'] = 'JNE';
  
  $err='';

  if(isset($_POST['btn_submit']))
  if(!isset($_POST['nama_penerima']) || $_POST['nama_penerima'] == "")
    $err = 'Nama Penerima harus diisi';
  else if((!isset($_POST['no_telp'])) || $_POST['no_telp'] =="")
    $err = 'No. Telepon harus diisi';
  else if(!isset($_POST['email']) || $_POST['email'] =="")
    $err = 'Email harus diisi';
  else if(!isset($_POST['alamat_lengkap']) || $_POST['alamat_lengkap'] =="")
    $err = 'Alamat Lengkap harus diisi';
  else if(!isset($_POST['province_id']) || $_POST['province_id'] =="")
    $err = 'Provinsi harus dipilih';
  else if(!isset($_POST['city_id_tujuan']) || $_POST['city_id_tujuan'] =="")
    $err = 'Kota harus dipilih';
  else if(!isset($_POST['kodepos']) || $_POST['kodepos'] =="")
    $err = 'Kode Pos harus diisi';
  else if(!isset($_POST['jasa']) || $_POST['jasa'] =="")
    $err = 'Jasa Pengiriman harus dipilih';
  else if(!isset($_POST['ongkos_id']) || $_POST['ongkos_id'] =="")
    $err = 'Tipe Pengiriman harus dipilih';
  else if(isset($_POST['btn_submit']))
  {
    $milliseconds = microtime(true);
    $seconds = $milliseconds / 1000;
    $remainder = round($seconds - ($seconds >> 0), 3) * 1000;
    $kode_pesan =  date("ymdHis").$remainder;

    if(isset($_SESSION['user_id']))
      $user_id = $_SESSION['user_id'];
    else
      $user_id = 0;
    $nama_penerima = $_POST['nama_penerima'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $alamat_lengkap = $_POST['alamat_lengkap'];
    $nama_provinsi = $_POST['nama_provinsi'];
    $nama_kota = $_POST['nama_kota'];
    $kodepos = $_POST['kodepos'];
    $jasa = $_POST['jasa'];
    $tipe_pengiriman = $_POST['tipe_pengiriman'];
    $harga_per_kg = $_POST['harga_per_kg'];
    $total_berat = ceil($_POST['total_berat']);
    $total_ongkir = $_POST['total_ongkir'];
    $total_harga = $_POST['total_harga'];
    $total_bayar = $_POST['total_bayar'];

    $sql = "INSERT INTO pemesanan(kode_pemesanan,id_user,nama_penerima,no_telp,email,alamat_lengkap,provinsi,kota,kode_pos,jasa_pengiriman,tipe_pengiriman,harga_per_kg,total_berat,total_harga,total_ongkir,total_bayar,status_kirim,status_bayar,tanggal_pesan) VALUES ('$kode_pesan','$user_id','$nama_penerima','$no_telp','$email','$alamat_lengkap','$nama_provinsi','$nama_kota','$kodepos',UPPER('$jasa'),'$tipe_pengiriman',$harga_per_kg,$total_berat,$total_harga,$total_ongkir,$total_bayar,'0','0',NOW());";
    
    $con->query($sql);
    if(isset($_SESSION['cart'])) {
      $cart = $_SESSION['cart'];
      foreach ($cart as $key => $value) {
        $sql2 = "SELECT * FROM produk where id=".$key;
        $result = $con->query($sql2);
        $row = $result->fetch_assoc();
        $id = $key;
        $qty = $value;
        $produk = $row['produk'];
        $price = $row['hargabaru'];
        $berat = $row['beratbaru'];
        $sql = "INSERT INTO pemesanan_detail(kode_pemesanan,id_barang,harga,berat,qty) VALUES('$kode_pesan',$id,$price,$berat,$qty);";      
        $con->query($sql);  
      }

      if(isset($_SESSION['cart']))
        unset($_SESSION['cart']);
      if(isset($_SESSION['jml']))
        unset($_SESSION['jml']);
      $_SESSION['kode_pesan'] = $kode_pesan;
      $con->close();

      $to = $email;
      $subject = "Segera lakukan pembayaran untuk transaksi ".$kode_pesan." sebesar Rp. ".$total_bayar;
      $message = '<head>
                  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
                  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script></head><h4>Hai '.$nama_penerima.',<br>Segera lakukan pembayaran untuk transaksi '.$kode_pesan.' sebesar Rp. '.$total_bayar.' ke rekening munafood.<br>Lakukan konfirmasi pembayaran jika sudah melakukan pembayaran. <a href="http://munafood.com/confirm.php">Konfirmasi</a>  </h4>';
      $from = 0;
      //send_email($to, $subject, $message, $from);
      header('location: emailpemesanan.php?kode='.$kode_pesan);
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
  <title>Pemesanan</title>
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
  <form method="post" action="pemesanan.php">
  <div class="container" style="margin-top:70px;min-height: 500px;">    
      <div class="container" id="grad4">                  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4 style="color:white;margin-top: 15px;text-align: left;">Email</h4>  
        </div>          
      </div>
      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='border: 1px solid gainsboro;padding: 5px;margin-right: 25px;'>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
        <?php 
          if(isset($err) && $err!='')
          {
              echo"<div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong> Error!</strong><br>$err</div>";
          }
          ?>
          <label>Nama Penerima</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <input type="text" class="form-control" name="nama_penerima" placeholder="Nama Penerima" value="<?php echo isset($_POST['nama_penerima'])? $_POST['nama_penerima'] : "" ; ?>">
          </div>
          <div class='clearfix visible-xs-block'></div><div class='clearfix visible-sm-block'></div>
      <div class='clearfix visible-md-block'></div><div class='clearfix visible-lg-block'></div> 
        </div>
      </div>
      <div class='clearfix visible-xs-block'></div><div class='clearfix visible-sm-block'></div>
      <div class='clearfix visible-md-block'></div><div class='clearfix visible-lg-block'></div>  
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>No. Telepon</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <input type="text" class="form-control" id="telp" name="no_telp" placeholder="No. Telepon" value="<?php echo isset($_POST['no_telp'])? $_POST['no_telp'] : "" ; ?>">
          </div>          
          <div class='clearfix visible-xs-block'></div><div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div><div class='clearfix visible-lg-block'></div>     
        </div>        
      </div>      
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Email</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email'])? $_POST['email'] : "" ; ?>">
          </div>          
          <div class='clearfix visible-xs-block'></div><div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div><div class='clearfix visible-lg-block'></div>      
        </div>        
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Alamat Lengkap</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <textarea type="text" class="form-control" name="alamat_lengkap" placeholder="Alamat Lengkap" rows="12"><?php echo isset($_POST['alamat_lengkap'])? $_POST['alamat_lengkap'] : '' ; ?></textarea>
          </div>
          <div class='clearfix visible-xs-block'></div><div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div><div class='clearfix visible-lg-block'></div>  
        </div>   
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Provinsi</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <?php
              $curl = curl_init();
              
              curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                  "key: c459d5b70f7aa2ad4056f6113beecc51"
                ),
              ));
              
              $response = curl_exec($curl);
              $err = curl_error($curl);
              
              curl_close($curl);
              
              if ($err) {
                echo "cURL Error #:" . $err;
              } else {
                  $arr = json_decode($response);
                  $result = $arr->rajaongkir->results;
                  $province_id = isset($_POST['province_id'])? $_POST['province_id'] : "" ;
                  foreach($result as $key)
                  {
                    if($province_id == $key->province_id)
                    {
                      echo '<input type="hidden" name="nama_provinsi" value="'.$key->province.'">';
                    }
                  }
                  ?>

                  <select id="provinsi" class="form-control input-xlarge" onchange="this.form.submit()" name="province_id">
                    <option selected value="">-Pilih Provinsi-</option>
                  <?php
                  foreach($result as $key)
                  {
                    if($province_id == $key->province_id)
                    {
                      echo '<option selected value="'.$key->province_id.'">'.$key->province.'</option>';   
                    }
                    else
                    {
                      echo '<option value="'.$key->province_id.'">'.$key->province.'</option>';
                    }
                  }
                  echo '</select>';
              }
            ?>
          </div>
          <div class='clearfix visible-xs-block'></div>
          <div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div>
          <div class='clearfix visible-lg-block'></div>
        </div>
      </div>  
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Kota</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <?php
              $curl = curl_init();
              curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$province_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                  "key: c459d5b70f7aa2ad4056f6113beecc51"
                ),
              ));
              
              $response = curl_exec($curl);
              $err = curl_error($curl);
              
              curl_close($curl);
              if ($err) {
                echo "cURL Error #:" . $err;
              } else {
                  $arr = json_decode($response);
                  $result = $arr->rajaongkir->results;
                  $city_id_asal = "151" ;
                  $city_id_tujuan = isset($_POST['city_id_tujuan'])? $_POST['city_id_tujuan'] : "" ;

                  foreach($result as $key)
                  {
                    if($city_id_tujuan == $key->city_id)
                    {
                      echo '<input type="hidden" name="nama_kota" value="'.$key->city_name.'">';
                    }
                  }
                  ?>
                  <input type="hidden" name="city_id_selected" value="<?php echo isset($_POST['city_id_tujuan'])? $_POST['city_id_tujuan'] : "" ; ?>">

                  <select id="city" class="form-control input-xlarge" onchange="this.form.submit()" name="city_id_tujuan">
                    <option value="" selected>- Pilih Kota -</option>
                  <?php
                  foreach($result as $key)
                  {
                    if($city_id_tujuan == $key->city_id)
                    {                      
                      echo '<option value="'.$key->city_id.'" selected>'.$key->city_name.'</option>';   
                    }
                    else{                      
                      echo '<option value="'.$key->city_id.'">'.$key->city_name.'</option>';   
                    }
                  }
                  echo '</select>';
              }
            ?>
          </div>
          <div class='clearfix visible-xs-block'></div>
          <div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div>
          <div class='clearfix visible-lg-block'></div> 
        </div> 
      </div>      
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Kode Pos</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <input type="kodepos" class="form-control" name="kodepos" placeholder="Kode Pos" value="<?php echo isset($_POST['kodepos'])? $_POST['kodepos'] : "" ; ?>">
          </div>          
          <div class='clearfix visible-xs-block'></div>
          <div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div>
          <div class='clearfix visible-lg-block'></div> 
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr/>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Jasa Pengiriman</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <?php
              $jasa = isset($_POST['jasa'])? $_POST['jasa'] : "jne" ;
            ?>
              
            <select id="jasa" class="form-control" name="jasa" class="input-xlarge" onchange="this.form.submit()">
            <option value="" selected>-Pilih Jasa-</option>
              <?php
                $labelJasa = ["jne", "pos", "tiki"];
                $detilJasa = ["JNE", "POS Indonesia", "TIKI"];
                for ($i=0; $i < 3; $i++) { 
                  if( $labelJasa[$i] == $jasa ){
                    echo "<option value='$labelJasa[$i]' selected>$detilJasa[$i]</option>";
                  }                  
                  else{                    
                    echo "<option value='$labelJasa[$i]' >$detilJasa[$i]</option>";
                  }
                }                
              ?>
            </select>
          </div>
          <div class='clearfix visible-xs-block'></div>
          <div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div>
          <div class='clearfix visible-lg-block'></div> 
        </div>
      </div>    
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Tipe Pengiriman</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <?php
              $curl = curl_init();
          
              curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=$city_id_asal&destination=$city_id_tujuan&weight=1&courier=$jasa",
                CURLOPT_HTTPHEADER => array(
                  "content-type: application/x-www-form-urlencoded",                  
                  "key: c459d5b70f7aa2ad4056f6113beecc51"
                ),
              ));
              
              $response = curl_exec($curl);
              $err = curl_error($curl);
                 
              $jumlah = -1;
              
              $nama = "";
              curl_close($curl);
              if ($err) {
                echo "cURL Error #:" . $err;
              } else {
                  $arr = json_decode($response);
                  // echo json_encode($arr) . " " . $jasa;
                  ?>

                  <?php
                  if(isset($arr->rajaongkir->results)){
                  $result = $arr->rajaongkir->results;

                  $service = $text = $ongkos = array();          
                  $jumlah = 0;
                  $harga_per_kg=0;
                  foreach($result as $key => $value){                      
                    $nama = $value->name;
                    foreach ($value->costs as $key => $costValue) {   
                      foreach ($costValue->cost as $key => $vals) {
                        $service[$jumlah] = $costValue->service;
                        $text[$jumlah] = $costValue->service ." - " . 'Rp. ' . number_format($vals->value,0,',','.') .'/ kg ';   
                        $ongkos[$jumlah] = $vals->value;               
                        $jumlah++;
                      }
                    }
                  }

                  // echo "<pre>";
                  // print_r($ongkos);
                  // echo "</pre>";

                  $ongkos_id = isset($_POST['ongkos_id'])? $_POST['ongkos_id'] : "" ;
                  for ($i=1; $i <= $jumlah; $i++) { 
                    if($i == $ongkos_id)
                    {
                      echo '<input type="hidden" name="tipe_pengiriman" value="'.$service[$i-1].'">';
                      echo '<input type="hidden" name="harga_per_kg" value="'.$ongkos[$i-1].'">';
                    }
                  }
                }

                $ongkos_id = isset($_POST['ongkos_id'])? $_POST['ongkos_id'] : "" ;
                // echo $ongkos_id;
                if($jumlah > 0){
                  echo '<select id="ongkos_id" class="form-control" name="ongkos_id" class="input-xlarge" onchange="this.form.submit()">';
                    echo '<option value="" selected>- Pilih Jenis -</option>';
                    for ($i=1; $i <= $jumlah; $i++) { 
                      if($i == $ongkos_id){
                        echo '<option value="'.$i.'" selected>'. $text[$i-1].'</option>';   
                      }
                      else{
                        echo '<option value="'.$i.'">'.$text[$i-1].'</option>';   
                      }
                    }
                  echo '</select>';
                }
                else if($jumlah == 0){
                  echo "$nama tidak tersedia";
                }
                else{
                  echo '<select id="ongkos_id" class="form-control" name="ongkos_id" class="input-xlarge" onchange="this.form.submit()">';
                    echo '<option value="" selected>-Pilih Jenis-</option>';                    
                  echo '</select>';
                }
              }
            ?>
          </div>
          <div class='clearfix visible-xs-block'></div>
          <div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div>
          <div class='clearfix visible-lg-block'></div> 
        </div>
      </div>    
    </div>  
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='border: 1px solid gainsboro;padding: 5px;margin-right: 25px;'>
      <br/>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>&nbsp;Ringkasan Belanja<hr/></h4>
        <?php
          $subtotal = $totalBerat = 0;
          foreach ($cart2 as $key => $value) {
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2"><img src="'.$value['image'].'"class="img-responsive" style="height:150px;"></div>';
            echo '<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4" style="">'.$value['produk'].'</div>';
            echo "<div class='clearfix visible-xs-block'></div>";
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">Rp. ' . number_format($value['price'],0,',','.') .' x '. $value['qty'].'pcs</div>';
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">@ '.$value['beratbaru'].' kg</div>';
            echo "<div class='clearfix visible-xs-block'></div>";
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">Rp. ' . number_format($value['total'],0,',','.') .'</div>';            
            echo '</div>';
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<hr/>';            
            echo '</div>';            
            $subtotal += $value['total'];
            $totalBerat += $value['beratbaru']*$value['qty'];
          }

          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";

          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
          //echo "adsf".$ongkos_id;
          if($jumlah > -1 && $ongkos_id != ""){
            echo '<div class="hidden-xs col-sm-6 col-md-6 col-lg-6" style="text-align:right;">Ongkos Kirim</div>';
            echo '<div class="visible-xs col-xs-12" style="text-align:left;">Ongkos Kirim</div>';
            $ongkir = $ongkos[$ongkos_id-1];
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">'.$ongkir.'/kg</div>';
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">'.$totalBerat.' kg ('.ceil($totalBerat).' kg)</div>';
            echo '<input type="hidden" name="total_berat" value="'.$totalBerat.'">';
            $ongkir = $ongkir * ceil($totalBerat);
            echo '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2" style="text-align:right;">Rp. ' . number_format($ongkir,0,',','.') .'</div>';
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
            $grandtotal=$ongkir+$subtotal;
            echo '<input type="hidden" name="total_ongkir" value="'.$ongkir.'">';
            echo '<input type="hidden" name="total_harga" value="'.$subtotal.'">';
            echo '<input type="hidden" name="total_bayar" value="'.$grandtotal.'">';
            echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;"><span><br/><b>Rp. ' . number_format($grandtotal,0,',','.') . '</b></span></td></div>';                 
            echo "<div class='clearfix visible-xs-block'></div>";
            echo "<div class='clearfix visible-sm-block'></div>";
            echo "<div class='clearfix visible-md-block'></div>";
            echo "<div class='clearfix visible-lg-block'></div>";   
          }       
        ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
          <a class="pull-right" href="pemesanan.php">
            <button type="submit" class="btn btn-success" name="btn_submit">
              Pesan <span class="glyphicon glyphicon-send"></span>
            </button>
          </a>
          <a class="pull-right" href="cart.php" style="margin-right: 20px;">
            <button type="button" class="btn btn-default">
              <span class="glyphicon glyphicon-shopping-cart"></span> Kembali ke Keranjang
            </button>
          </a>                     
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
    <div class="container" id="grad4" style="height: 30px;">        
      <h4 style="color:white;margin-top: 15px;text-align: center;"><?php echo " "; ?></h4>            
    </div>
  </div>
  </form>
  <?php include 'footer.php'; ?>    
</body>
</html>