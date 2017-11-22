<?php include 'menu.php'; ?>
<?php
  if(isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    foreach ($cart as $key => $value) {
      $sql = "SELECT * FROM produk where id=".$key;
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $id = $key;
      $qty = $value;
      $produk = $row['produk'];
      $price = $row['hargabaru'];
      $image = $row['image'];
      $total = $qty * $price;
      $deskripsi = $row['deskripsi'];

      $temp = array('id'=>$id,'qty'=>$qty,'produk'=>$produk,'price'=>$price,'image'=>$image,'total'=>$total,'deskripsi'=>$deskripsi);
      $cart2[$id] = $temp;
    }
    //echo "<pre>";print_r($cart2);echo "</pre>";
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
    <div class="container" style="border: 1px solid gainsboro;margin-top: 70px;"><br/>   
    <h4>&nbsp;&nbsp;Pengiriman<hr/></h4>      
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Nama Penerima</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <input type="name" class="form-control" id="nama_penerima" placeholder="Nama Penerima" value="">
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
            <input type="text" class="form-control" id="telp" placeholder="No. Telepon" value="">
          </div>          
          <div class='clearfix visible-xs-block'></div><div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div><div class='clearfix visible-lg-block'></div>     
        </div>        
      </div>      
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Email</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <input type="text" class="form-control" id="email" placeholder="Email" value="">
          </div>          
          <div class='clearfix visible-xs-block'></div><div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div><div class='clearfix visible-lg-block'></div>      
        </div>        
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
          <label>Alamat Lengkap</label>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 controls">
            <textarea type="text" class="form-control" id="alamatlengkap" placeholder="Alamat Lengkap" rows="8"></textarea>
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
            ?>
            <input type="hidden" name="prov_id_selected" value="<?php echo isset($_POST['province_id'])? $_POST['province_id'] : "" ; ?>">
            <select id="provinsi" class="form-control input-xlarge" onchange="this.form.submit()" name="province_id">
              <option selected>-Pilih Provinsi-</option>
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
            echo '</select></form>';
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

            ?>

            <select name="city_id" class="form-control input-xlarge">
              <option selected>-Pilih Kota-</option>
            <?php
            foreach($result as $key)
            {
                echo '<option value="'.$key->city_id.'">'.$key->city_name.'</option>';   
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
            <input type="kodepos" class="form-control" id="kodepos" placeholder="Kode Pos" value="11530">
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
            <select id="jasa" class="form-control" name="jasa" class="input-xlarge">
              <option value="" selected="selected">JNE - Reguler</option>
              <option value="">JNE - OKE</option>
              <option value="">JNE - YES</option>
            </select>
          </div>
          <div class='clearfix visible-xs-block'></div>
          <div class='clearfix visible-sm-block'></div>
          <div class='clearfix visible-md-block'></div>
          <div class='clearfix visible-lg-block'></div> 
        </div>
      </div>    
    </div>
    <div class="container" style="border-top: 1px solid gainsboro;border-bottom: 1px solid gainsboro;border-left: 1px solid gainsboro;border-right: 1px solid gainsboro;">
      <br/>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>&nbsp;Ringkasan Belanja<hr/></h4>
        <?php
          $subtotal = 0;
          foreach ($cart2 as $key => $value) {
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2"><img src="'.$value['image'].'"class="img-responsive" style="height:150px;"></div>';
            echo '<div class="col-xs-6 col-sm-3 col-md-4 col-lg-4" style="min-height:110px;">'.$value['produk'].'</div>';
            echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">'.$value['price'].' x '. $value['qty'].'pcs</div>';
            echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">Rp. ' . number_format($value['total'],0,',','.') .'</div>';            
            echo '</div>';
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo '<hr/>';            
            echo '</div>';            
            $subtotal += $value['total'];
          }

          echo "<div class='clearfix visible-xs-block'></div>";
          echo "<div class='clearfix visible-sm-block'></div>";
          echo "<div class='clearfix visible-md-block'></div>";
          echo "<div class='clearfix visible-lg-block'></div>";

          echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
          echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">Ongkos Kirim</div>';
          echo '<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">9000 x 1kg</div>';
          echo '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="text-align:right;">9000</div>';
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
          $grandtotal=9000+$subtotal;
          echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;"><span><br/><b>Rp. ' . number_format($grandtotal,0,',','.') . '</b></span></td></div>';                   
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
          <h5>Pembayaran dapat ditransfer ke rekening <br><br>BCA 527-123-456-789<br/> atas nama CV. Munafood</h5>
          <h5>Sebesar Rp. <?php echo number_format($grandtotal,0,',','.'); ?></h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <hr/>            
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
          <a class="pull-right" href="thankyou.php">
            <button type="button" class="btn btn-success">
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
  </form>
  <?php include 'footer.php'; ?>    
</body>
</html>