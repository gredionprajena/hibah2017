<head> 
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Home</title>
  <link rel="shortcut icon" type="image/png" href="image/logo/logo01.jpg" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

<?php
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSL_VERIFYPEER => false,
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
            <form method="post" action="ongkir.php"><input type="hidden" name="prov_id_selected" value="<?php echo isset($_POST['province_id'])? $_POST['province_id'] : "" ; ?>">
            <select onchange="this.form.submit()" name="province_id">
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

            ?>

            <select name="city_id">
              <option selected>-Pilih Kota-</option>
            <?php
            foreach($result as $key)
            {
                echo '<option value="'.$key->city_id.'">'.$key->city_name.'</option>';   
            }
            echo '</select>';
        }
 