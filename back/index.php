<html>
<?php 
  include 'menu.php'; 
  $urutanErr = $sejarahErr = $editSejarahErr = $noSejarahErr = $imageErr = $noMisiErr = $editMisiErr = $editVisiErr = $err = "";
  $editIsiSejarah = $editIsiMisi = $editIsiVisi = "";
  $editPemilikErr = $editNoRekErr = $editNamaBankErr = $editAlamatErr = $noBankErr = "";
  $editNamaBank = $editPemilik = $editNoRek = "";
  $flagForm = $imageLogo = 1;     
  $uploadImgOk = 0; 
  

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["cancelMisi"]) && $_POST["cancelMisi"] != ""){ 
      $tambahMisi = $_POST["tambahMisi"] = "cancel";
    }
    if(isset($_POST["cancelBank"]) && $_POST["cancelBank"] != ""){ 
      $tambahRekening = $_POST["tambahRekening"] = "cancel";
    }
    if(isset($_POST["cancelSejarah"]) && $_POST["cancelSejarah"] != ""){ 
      $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
    }
    if(isset($_POST["editMisi"]) && $_POST["editMisi"] != ""){      
      $kodeMisi = test_input($_POST["editMisi"]); 
      $tambahMisi = $_POST["tambahMisi"] = "cancel";
    }
    if(isset($_POST["hapusMisi"]) && $_POST["hapusMisi"] != ""){      
      $kodeMisi = test_input($_POST["hapusMisi"]);       
      $tambahMisi = $_POST["tambahMisi"] = "cancel";
    }
    if(isset($_POST["editSejarah"]) && $_POST["editSejarah"] != ""){      
      $kodeSejarah = test_input($_POST["editSejarah"]);     
      $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
    }
    if(isset($_POST["hapusSejarah"]) && $_POST["hapusSejarah"] != ""){      
      $kodeSejarah = test_input($_POST["hapusSejarah"]);     
      $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
    }
    if(isset($_POST["editBank"]) && $_POST["editBank"] != ""){      
      $kodeRek = test_input($_POST["editBank"]);     
      $tambahRekening = $_POST["tambahRekening"] = "cancel";
    }
    if(isset($_POST["hapusBank"]) && $_POST["hapusBank"] != ""){      
      $kodeRek = test_input($_POST["hapusBank"]);     
      $tambahRekening = $_POST["tambahRekening"] = "cancel";
    }

    if(isset($_POST["tambahRekening"]) && $_POST["tambahRekening"] == "tambahRekening"){ 
      $tambahRekening = $_POST["tambahRekening"] = "tambahRekening";   
    }
    if(isset($_POST["tambahSejarah"]) && $_POST["tambahSejarah"] == "tambahSejarah"){ 
      $tambahSejarah = $_POST["tambahSejarah"] = "tambahSejarah";   
    }
    if(isset($_POST["tambahMisi"]) && $_POST["tambahMisi"] == "tambahMisi"){ 
      $tambahMisi = $_POST["tambahMisi"] = "tambahMisi";   
    }

    if(isset($_POST["editItem"]) && $_POST["editItem"] != ""){ 
      $flagForm = 1;
      $tambahMisi = $_POST["tambahMisi"] = "cancel";
      $tambahRekening = $_POST["tambahRekening"] = "cancel";
      $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
    }
    if(isset($_POST["saveTiket"]) && $_POST["saveTiket"] != ""){ 
      $flagForm = 1;
      if (!isset($_POST["editAlamat"]) || $_POST["editAlamat"] == "") {
        $err = $editAlamatErr = "Silakan tulis alamat yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $editAlamat = addslashes($_POST["editAlamat"]); 
      }

      if($flagForm == 1){
        $sql3 = "update ukm set alamat  = '$editAlamat' where id = '1'";
        $result3 = $con->query($sql3);
      }
    }

    if(isset($_POST["editVisi"]) && $_POST["editVisi"] != ""){ 
      $flagForm = 1;
      $tambahMisi = $_POST["tambahMisi"] = "cancel";
      $tambahRekening = $_POST["tambahRekening"] = "cancel";
      $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
    }
    if(isset($_POST["saveVisi"]) && $_POST["saveVisi"] != ""){ 
      $flagForm = 1;
      if (!isset($_POST["editIsiVisi"]) || $_POST["editIsiVisi"] == "") {
        $err = $editVisiErr = "Silakan tulis visi yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $editIsiVisi = addslashes($_POST["editIsiVisi"]); 
      }

      if($flagForm == 1){
        $sql3 = "update ukm set visi = '$editIsiVisi' where id = '1'";
        $result3 = $con->query($sql3);        
      }
    }


    if((isset($_POST["addBank"]) && $_POST["addBank"] != "") || (isset($_POST["saveRek"]) && $_POST["saveRek"] != "") || (isset($_POST["confirmRek"]) && $_POST["confirmRek"] != "")) {  
      $flagForm = 1;
      if (!isset($_POST["urutan"])  || $_POST["urutan"] == "") {
        $err = $noBankErr = "Urutan tidak boleh kosong";
        $flagForm = 0;
      }
      else {
        $urutan = test_input($_POST["urutan"]);
        if (!preg_match("/^[0-9]{0,15}$/",$urutan)) {
          $err = $noBankErr = "hanya angka yang diperbolehkan";
          $flagForm = 0;
        }
      }

      if (!isset($_POST["editNamaBank"]) || $_POST["editNamaBank"] == "") {
        $err = $editNamaBankErr = "Silakan tulis nama bank yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $editNamaBank = addslashes($_POST["editNamaBank"]); 
      }

      if (!isset($_POST["editPemilik"]) || $_POST["editPemilik"] == "") {
        $err = $editPemilikErr = "Silakan tulis nama pemilik rekening yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $editPemilik = addslashes($_POST["editPemilik"]); 
      }
      if (!isset($_POST["editNoRek"]) || $_POST["editNoRek"] == "") {
        $err = $editNoRekErr = "Silakan tulis nomor rekening yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $editNoRek = addslashes($_POST["editNoRek"]); 
      }
      if($flagForm == 1 && (isset($_POST["addBank"]) && $_POST["addBank"] != "")){ 
        $sql2 = "insert into bank(urutan, nama_bank, no_rek, pemilik_rek) values ('$urutan', '$editNamaBank', '$editNoRek', '$editPemilik')";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahRekening = $_POST["tambahRekening"] = "cancel";
      }
      else if($flagForm == 1 && (isset($_POST["saveRek"]) && $_POST["saveRek"] != "")){ 
        $kodeRek = test_input($_POST["saveRek"]);     
        $sql2 = "update bank set urutan = '$urutan', nama_bank  = '$editNamaBank', no_rek  = '$editNoRek', pemilik_rek  = '$editPemilik' where id = '$kodeRek'";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahRekening = $_POST["tambahRekening"] = "cancel";
      }
      else if($flagForm == 1 && (isset($_POST["confirmRek"]) && $_POST["confirmRek"] != "")){ 
        $kodeRek = test_input($_POST["confirmRek"]);     
        $sql2 = "delete from bank where id = '$kodeRek'";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahRekening = $_POST["tambahRekening"] = "cancel";
      }
    }

    if((isset($_POST["addSejarah"]) && $_POST["addSejarah"] != "") || (isset($_POST["saveSejarah"]) && $_POST["saveSejarah"] != "") || (isset($_POST["confirmSejarah"]) && $_POST["confirmSejarah"] != "")) {      
      $flagForm = 1;
      if (!isset($_POST["urutan"])  || $_POST["urutan"] == "") {
        $err = $noSejarahErr = "Urutan tidak boleh kosong";
        $flagForm = 0;
      }
      else {
        $urutan = test_input($_POST["urutan"]);
        if (!preg_match("/^[0-9]{0,15}$/",$urutan)) {
          $err = $noSejarahErr = "hanya angka yang diperbolehkan";
          $flagForm = 0;
        }
      }

      if (!isset($_POST["editIsiSejarah"]) || $_POST["editIsiSejarah"] == "") {
        $err = $editSejarahErr = "Silakan tulis sejarah yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $editIsiSejarah = addslashes($_POST["editIsiSejarah"]); 
        // if (!preg_match("/^[a-zA-Z0-9 ?.!@_]*$/",$editIsiSejarah)) {
        //   $editSejarahErr = "Hanya huruf, angka dan spasi yang diperbolehkan";  
        //   $flagForm = 0;       
        // }
      }
      if($flagForm == 1 && (isset($_POST["addSejarah"]) && $_POST["addSejarah"] != "")){ 
        $sql2 = "insert into sejarah(urutan, sejarah) values ('$urutan', '$editIsiSejarah')";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
      }
      else if($flagForm == 1 && (isset($_POST["saveSejarah"]) && $_POST["saveSejarah"] != "")){ 
        $kodeSejarah = test_input($_POST["saveSejarah"]);     
        $sql2 = "update sejarah set urutan = '$urutan', sejarah  = '$editIsiSejarah' where id = '$kodeSejarah'";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
      }
      else if($flagForm == 1 && (isset($_POST["confirmSejarah"]) && $_POST["confirmSejarah"] != "")){ 
        $kodeSejarah = test_input($_POST["confirmSejarah"]);     
        $sql2 = "delete from sejarah where id = '$kodeSejarah'";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahSejarah = $_POST["tambahSejarah"] = "cancel";
      }
    }
    if((isset($_POST["addMisi"]) && $_POST["addMisi"] != "") || (isset($_POST["saveMisi"]) && $_POST["saveMisi"] != "") || (isset($_POST["confirmMisi"]) && $_POST["confirmMisi"] != "")) {      
      $flagForm = 1;
      if (!isset($_POST["urutan"])  || $_POST["urutan"] == "") {
        $err = $noMisiErr = "Urutan tidak boleh kosong";
        $flagForm = 0;
      }
      else {
        $urutan = test_input($_POST["urutan"]);
        if (!preg_match("/^[0-9]{0,15}$/",$urutan)) {
          $err = $noMisiErr = "hanya angka yang diperbolehkan";
          $flagForm = 0;
        }
      }

      if (!isset($_POST["editIsiMisi"]) || $_POST["editIsiMisi"] == "") {
        $err = $editMisiErr = "Silakan tulis misi yang diinginkan"; 
        $flagForm = 0; 
      } 
      else { 
        $editIsiMisi = addslashes($_POST["editIsiMisi"]); 
        // if (!preg_match("/^[a-zA-Z0-9 ?.!@_]*$/",$editIsiMisi)) {
        //   $editMisiErr = "Hanya huruf, angka dan spasi yang diperbolehkan";  
        //   $flagForm = 0;       
        // }
      }
      if($flagForm == 1 && (isset($_POST["addMisi"]) && $_POST["addMisi"] != "")){ 
        $sql2 = "insert into misi(urutan, misi) values ('$urutan', '$editIsiMisi')";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahMisi = $_POST["tambahMisi"] = "cancel";
      }
      else if($flagForm == 1 && (isset($_POST["saveMisi"]) && $_POST["saveMisi"] != "")){ 
        $kodeMisi = test_input($_POST["saveMisi"]);     
        $sql2 = "update misi set urutan = '$urutan', misi  = '$editIsiMisi' where id = '$kodeMisi'";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahMisi = $_POST["tambahMisi"] = "cancel";
      }
      else if($flagForm == 1 && (isset($_POST["confirmMisi"]) && $_POST["confirmMisi"] != "")){ 
        $kodeMisi = test_input($_POST["confirmMisi"]);     
        $sql2 = "delete from misi where id = '$kodeMisi'";
        $result2 = $con->query($sql2);
        // echo "$sql2";
        $tambahMisi = $_POST["tambahMisi"] = "cancel";
      }
    }
  }
?>

<head>
  <meta property="og:image" itemprop="image" content="<?php echo "../" . $logo; ?>"/>  
  <meta property="og:title" content=""/>  
  <meta property="og:description" content=""/>  
  <meta property="og:type" content="website" />
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <meta itemprop="name" content=""> 
  <title>Home</title>
  <link rel="shortcut icon" type="image/jpg" href="image/logo/logo01.j<?php echo "../" . $logo; ?>" />
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
  </style>  
<body style="z-index: -1;">  
  <?php include 'carousel.php'; ?>
  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">       
      <form class="form-horizontal" id="profile" name="profile" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "#profile"; ?>" style="min-height: 250px;">       
        <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $kode;?>" placeholder="kode" readonly>
        <input type="hidden" class="form-control" id="add" name="add" value="<?php echo $add;?>" placeholder="add" readonly>
        <div class="container" id="grad4">                  
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4 style="color:white;margin-top: 15px;text-align: center;">Profil Perusahaan</h4>  
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 200px;">   
          <br/>
          <?php
            $sql = "SELECT * FROM ukm where id = '1'";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {            
              $row = $result->fetch_assoc();              
              echo "<div class='col-xs-12 col-sm-3 col-md-2 col-lg-2'>";
              echo "<p style=''><strong>Nama Perusahaan</strong> :</p>";    
              echo "</div>";            
              echo "<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>";
              echo "<p style='margin-left:30px;'>" . $row['name'] . " </p>";    
              echo "</div>";
              echo "<div class='col-xs-12 col-sm-3 col-md-4 col-lg-4'>";                
                echo "<button type='submit' class='btn btn-sm btn-info pull-right' name='editItem' value='profile'><span class='glyphicon glyphicon-edit'></span></button>";
              echo "</div>";                
              echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";                
                echo "<hr/>";              
              echo "</div>";

              echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>"; 
                echo "<div class='form-group'>";        
                echo "<div class='col-xs-7 col-sm-4 col-md-4 col-lg-4'>";
                echo "<p style=''><strong>Warna Header</strong> :</p>";    
                echo "</div>";            
                echo "<div class='col-xs-5 col-sm-4 col-md-4 col-lg-4'>";
                echo "<p style='background-color:" . $row['headercolor'] . ";color:" . $row['headercolor'] . ";'>" . $row['headercolor'] . " </p>";   
                echo "</div>";
                echo "<div class='col-xs-offset-7 col-xs-5 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4 col-lg-offset-0 col-lg-4'>";
                echo "<p style=''>" . $row['headercolor'] . " </p>";    
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";                
                echo "</div>";
                echo "<div class='form-group'>";        
                echo "<div class='col-xs-7 col-sm-4 col-md-4 col-lg-4'>";
                echo "<p style=''><strong>Warna Footer</strong> :</p>";    
                echo "</div>";
                echo "<div class='col-xs-5 col-sm-4 col-md-4 col-lg-4'>";
                echo "<p style='background-color:" . $row['footercolor'] . ";color:" . $row['footercolor'] . ";'>" . $row['footercolor'] . " </p>";   
                echo "</div>";
                echo "<div class='col-xs-offset-7 col-xs-5 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4 col-lg-offset-0 col-lg-4'>";
                echo "<p style=''>" . $row['footercolor'] . " </p>";    
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";   
                echo "</div>";
                echo "<div class='form-group'>";        
                echo "<div class='col-xs-7 col-sm-4 col-md-4 col-lg-4'>";
                echo "<p style=''><strong>Warna Content</strong> :</p>";    
                echo "</div>";
                echo "<div class='col-xs-5 col-sm-4 col-md-4 col-lg-4'>";
                echo "<p style='background-color:" . $row['contentcolor'] . ";color:" . $row['contentcolor'] . ";'>" . $row['contentcolor'] . " </p>";   
                echo "</div>";
                echo "<div class='col-xs-offset-7 col-xs-5 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4 col-lg-offset-0 col-lg-4'>";
                echo "<p style=''>" . $row['contentcolor'] . " </p>";    
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";   
                echo "</div>";
              echo "</div>";
              echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>"; 
                echo "<div class='form-group'>";  
                echo "<div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>";
                echo "<p style=''><strong>Alamat</strong> :</p>";    
                echo "</div>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<p style='margin-left:30px;'>" . $row['alamat'] . " </p>";  
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";   
                echo "</div>";                
              echo "</div>";

              if((isset($_POST["editItem"]) && $_POST["editItem"] == "profile")){     
                // echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";                
                  echo "<div class='clearfix visible-xs-block'></div>";
                  echo "<div class='clearfix visible-sm-block'></div>";
                  echo "<div class='clearfix visible-md-block'></div>";
                  echo "<div class='clearfix visible-lg-block'></div>"; 
                  // echo "<div class='panel panel-info col-xs-12 col-sm-12 col-md-12 col-lg-12' >";
                echo "<div class='panel panel-info col-xs-12 col-sm-12 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6' >";
                  echo "<div class='panel-heading'>Konfirmasi Edit</div>";
                    echo "<div class='panel-body' style='width:100%;'>";
                  //   echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>";
                  //     echo "<div class='form-group'>";        
                  //     echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-4 col-lg-3' for='Header'>Header Color : </label>";
                  //     echo "<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>";
                  //     echo "<input type='color' class='form-control' id='headercolor' name='headercolor' value='" . $row['headercolor'] . "''>";   
                  //     echo "<span class='text-danger'>$editHeaderErr</span>";
                  //     echo "</div>";
                  //     echo "<div class='clearfix visible-xs-block'></div>";
                  //     echo "<div class='clearfix visible-sm-block'></div>";
                  //     echo "<div class='clearfix visible-md-block'></div>";
                  //     echo "<div class='clearfix visible-lg-block'></div>";                
                  //     echo "</div>";  
                  //     echo "<div class='form-group'>";        
                  //     echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-4 col-lg-3' for='Footer'>Footer Color : </label>";
                  //     echo "<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>";
                  //     echo "<input type='color' class='form-control' id='footercolor' name='footercolor' value='" . $row['footercolor'] . "''>";   
                  //     echo "<span class='text-danger'>$editFooterErr</span>";
                  //     echo "</div>";
                  //     echo "<div class='clearfix visible-xs-block'></div>";
                  //     echo "<div class='clearfix visible-sm-block'></div>";
                  //     echo "<div class='clearfix visible-md-block'></div>";
                  //     echo "<div class='clearfix visible-lg-block'></div>";                
                  //     echo "</div>";  
                  //     echo "<div class='form-group'>";        
                  //     echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-4 col-lg-3' for='Content'>Content Color : </label>";
                  //     echo "<div class='col-xs-12 col-sm-4 col-md-4 col-lg-4'>";
                  //     echo "<input type='color' class='form-control' id='contentcolor' name='contentcolor' value='" . $row['contentcolor'] . "''>";   
                  //     echo "<span class='text-danger'>$editContentErr</span>";
                  //     echo "</div>";
                  //     echo "<div class='clearfix visible-xs-block'></div>";
                  //     echo "<div class='clearfix visible-sm-block'></div>";
                  //     echo "<div class='clearfix visible-md-block'></div>";
                  //     echo "<div class='clearfix visible-lg-block'></div>";                
                  //     echo "</div>";                                    
                  // echo "</div>";        
                  // echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>";  
                  echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";                              
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-4 col-lg-3' for='Alamat'>Alamat : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<textarea class='form-control' rows='5' id='editAlamat' name='editAlamat' value='" . $row['alamat'] . "' placeholder='Alamat...'>" . $row['alamat'] . "</textarea>";   
                      echo "<span class='text-danger'>$editAlamatErr</span>";
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
                            echo "<button type='submit' class='btn btn-default' name='CancelTiket' value='profile'>Cancel</button>&emsp;";
                            echo "<button type='submit' class='btn btn-primary' name='saveTiket' value='profile'>Konfirmasi</button>&emsp;";
                        echo "</div>";
                    echo "</div>";
                  echo "</div>";     
                  echo "</div>";  
                // echo "</div>";   
              }                
              echo "<div class='clearfix visible-xs-block'></div>";
              echo "<div class='clearfix visible-sm-block'></div>";
              echo "<div class='clearfix visible-md-block'></div>";
              echo "<div class='clearfix visible-lg-block'></div>";
            }
          ?>
          <br/>          
        </div>
        <div class="clearfix visible-xs-block"></div>
        <div class="clearfix visible-sm-block"></div>
        <div class="clearfix visible-md-block"></div>
        <div class="clearfix visible-lg-block"></div>
      </form>  
    </div>      
  </div>

  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <form class="form-horizontal" id="rekening" name="rekening" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "#rekening"; ?>" style="min-height: 160px;">  
        <input type="hidden" class="form-control" id="tambahRekening" name="tambahRekening" value="<?php echo $tambahRekening;?>" placeholder="tambahRekening" readonly>  
        <div class="container" id="grad4">                  
          <div class="col-xs-6 col-sm-8 col-md-8 col-lg-6">
            <h4 style="color:white;margin-top: 15px;text-align: left;">Rekening</h4>  
          </div>
          <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
          <?php 
            echo "<button type='submit' style='font-size:14px;margin-top: 8px;' class='btn btn-sm btn-success pull-right' id='tambahRekening' name='tambahRekening' value='tambahRekening'><span class='glyphicon glyphicon-plus'>&nbsp;</span>Tambah Rekening&nbsp;</button>";         
          ?>          
          </div>
        </div>
          <?php
            if(isset($_POST["tambahRekening"]) && $_POST["tambahRekening"] == "tambahRekening"){                            
              $sql1 = "SELECT urutan FROM bank order by urutan desc";
              $result1 = $con->query($sql1);

              if ($result1->num_rows > 0) {   
                $row1 = $result1->fetch_assoc();
                $urutan = $row1['urutan'] + 1;
              }
              else{$urutan = 1;}
              echo "<div class='panel panel-success col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
              echo "<div class='panel-heading'>Konfirmasi Add</div>";          
              echo "<div class='panel-body' style='width:100%;'>";
                echo "<div class='form-group'>";
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='urutan'>Urutan : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<input type='text' class='form-control' id='urutan' name='urutan' value='$urutan' placeholder='' readonly>";
                echo "<span class='text-danger'>$noBankErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='nama'>Nama Bank : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<input type='text' class='form-control' id='editNamaBank' name='editNamaBank' value='$editNamaBank' placeholder='add Nama Bank...'>";   
                echo "<span class='text-danger'>$editNamaBankErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";        
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='norek'>Nomor Rekening : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<input type='text' class='form-control' id='editNoRek' name='editNoRek' value='$editNoRek' placeholder='add No Rekening...'>";   
                echo "<span class='text-danger'>$editNoRekErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";     
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='an'>Atas Nama : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<input type='text' class='form-control' id='editPemilik' name='editPemilik' value='$editPemilik' placeholder='add Atas Nama...'>";     
                echo "<span class='text-danger'>$editPemilikErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";                     
              echo "<div class='panel-footer clearfix'>";
                  echo "<div class='pull-right'>";                    
                    echo "<button type='submit' class='btn btn-default' name='cancelBank' value='cancelRek'>Cancel</button>&emsp;";
                    echo "<button type='submit' class='btn btn-primary' name='addBank' value='addBank'>Konfirmasi</button>&emsp;";
                  echo "</div>";
              echo "</div>";
            echo "</div>";     
            echo "</div>";
          }              
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 150px;">   
          <br/>
          <?php
            $sql = "SELECT * FROM bank order by urutan";
            $result = $con->query($sql);
            echo "<div class='hidden-xs col-sm-1 col-md-1 col-lg-1'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>Urutan</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-2 col-md-3 col-lg-3'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>Nama Bank</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-3 col-md-3 col-lg-3'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>No Rekening</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-3 col-md-3 col-lg-3'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>Atas Nama</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-3 col-md-2 col-lg-2'>";
            echo "<p style='margin-top:10px;text-align:center;'><strong>Edit</strong></p>";    
            echo "</div>";
            echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            echo "<hr/>";
            echo "</div>";

            if ($result->num_rows > 0) {            
              $i=0;
              while($row2 = $result->fetch_assoc()) {
                echo "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
                echo "<p style='margin-left: 30px;'>" . $row2['urutan'] . "</p>";    
                echo "</div>";
                echo "<div class='hidden-xs col-sm-3 col-md-3 col-lg-3'>";
                echo "<p style='margin-left: 30px;'>" . $row2['nama_bank'] . "</p>";    
                echo "</div>";
                echo "<div class='hidden-xs col-sm-3 col-md-3 col-lg-3'>";
                echo "<p style='margin-left: 30px;'>" . $row2['no_rek'] . "</p>";    
                echo "</div>";
                echo "<div class='hidden-xs col-sm-3 col-md-3 col-lg-3'>";
                echo "<p style='margin-left: 30px;'>" . $row2['pemilik_rek'] . "</p>";    
                echo "</div>";
                echo "<div class='col-xs-12 col-sm-3 col-md-2 col-lg-2'>";                
                echo "<button type='submit' class='btn btn-sm btn-danger pull-right' name='hapusBank' value='" . $row2['id'] . "'><span class='glyphicon glyphicon-trash'></span></button>";
                echo "<button type='submit' class='btn btn-sm btn-info pull-right' style='margin-right:20px;' name='editBank' value='" . $row2['id'] . "'><span class='glyphicon glyphicon-edit'></span></button>";
                echo "</div>";                
                echo "<div class='visible-xs col-xs-12'>";
                echo "<hr/>";
                echo "</div>";
                if((isset($_POST["editBank"]) && $kodeRek == $row2['id']) || (isset($_POST["hapusBank"]) && $kodeRek == $row2['id'])){
                  if(isset($_POST["editBank"])){
                    echo "<div class='panel panel-info col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                    echo "<div class='panel-heading'>Konfirmasi Edit</div>";
                  } 
                  else if(isset($_POST["hapusBank"])){
                    echo "<div class='panel panel-danger col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                    echo "<div class='panel-heading'>Konfirmasi Delete</div>";
                  } 
                    echo "<div class='panel-body' style='width:100%;'>";
                      echo "<div class='form-group'>";
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='noFaq'>Urutan : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<input type='text' class='form-control' id='urutan' name='urutan' value='" . $row2['urutan'] . "' placeholder='" . $row2['urutan'] . "'>";
                      echo "<span class='text-danger'>$noBankErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Sejarah'>Nama Bank : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";                      
                      echo "<input type='text' class='form-control' id='editNamaBank' name='editNamaBank' value='" . $row2['nama_bank'] . "' placeholder='" . $row2['nama_bank'] . "'>"; 
                      echo "<span class='text-danger'>$editNamaBankErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";    
                      echo "</div>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='pemilik'>No Rekening : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";                      
                      echo "<input type='text' class='form-control' id='editNoRek' name='editNoRek' value='" . $row2['no_rek'] . "' placeholder='" . $row2['no_rek'] . "'>"; 
                      echo "<span class='text-danger'>$editNoRekErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Sejarah'>Atas Nama : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";                      
                      echo "<input type='text' class='form-control' id='editPemilik' name='editPemilik' value='" . $row2['pemilik_rek'] . "' placeholder='" . $row2['pemilik_rek'] . "'>"; 
                      echo "<span class='text-danger'>$editPemilikErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";       
                      echo "</div>";        
                      echo "<div class='panel-footer clearfix'>";
                        echo "<div class='pull-right'>";                    
                          echo "<button type='submit' class='btn btn-default' name='cancelRek' value='" . $row2['id'] . "'>Cancel</button>&emsp;";
                          if((isset($_POST["hapusBank"]) && $kodeRek == $row2['id'])){ 
                            echo "<button type='submit' class='btn btn-primary' name='confirmRek' value='" . $row2['id'] . "'>Konfirmasi</button>&emsp;";
                          }
                          else{
                            echo "<button type='submit' class='btn btn-primary' name='saveRek' value='" . $row2['id'] . "'>Konfirmasi</button>&emsp;";
                          }
                        echo "</div>";
                    echo "</div>";
                echo "</div>";     
                echo "</div>";     
                }                
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";
              }
            }
          ?>
        </div>
        <div class="clearfix visible-xs-block"></div>
        <div class="clearfix visible-sm-block"></div>
        <div class="clearfix visible-md-block"></div>
        <div class="clearfix visible-lg-block"></div>

        </div>
      </form>  
    </div>      
  </div>
  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <form class="form-horizontal" id="sejarah" name="sejarah" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "#sejarah"; ?>" style="min-height: 460px;">    
        <input type="hidden" class="form-control" id="tambahSejarah" name="tambahSejarah" value="<?php echo $tambahSejarah;?>" placeholder="tambahSejarah" readonly>  
        <div class="container" id="grad4">                  
          <div class="col-xs-6 col-sm-8 col-md-8 col-lg-6">
            <h4 style="color:white;margin-top: 15px;text-align: left;">Sejarah</h4>  
          </div>
          <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
          <?php 
            echo "<button type='submit' style='font-size:14px;margin-top: 8px;' class='btn btn-sm btn-success pull-right' id='tambahSejarah' name='tambahSejarah' value='Sejarah'><span class='glyphicon glyphicon-plus'>&nbsp;</span>Tambah Sejarah&nbsp;</button>";         
          ?>          
          </div>
        </div>
          <?php
            if(isset($_POST["tambahSejarah"]) && $_POST["tambahSejarah"] == "tambahSejarah"){        
              $sql1 = "SELECT urutan FROM sejarah order by urutan desc";
              $result1 = $con->query($sql1);

              if ($result1->num_rows > 0) {   
                $row3 = $result1->fetch_assoc();
                $urutan = $row3['urutan'] + 1;
              }
              echo "<div class='panel panel-success col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
              echo "<div class='panel-heading'>Konfirmasi Add</div>";          
              echo "<div class='panel-body' style='width:100%;'>";
                echo "<div class='form-group'>";
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='noFaq'>Urutan : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<input type='text' class='form-control' id='urutan' name='urutan' value='$urutan' placeholder='' readonly>";
                echo "<span class='text-danger'>$noSejarahErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Sejarah'>Sejarah : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<textarea class='form-control' rows='5' id='editIsiSejarah' name='editIsiSejarah' value='$editIsiSejarah' placeholder='add Sejarah...'>" . $editIsiSejarah . "</textarea>";   
                echo "<span class='text-danger'>$editSejarahErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";        
              echo "<div class='panel-footer clearfix'>";
                  echo "<div class='pull-right'>";                    
                    echo "<button type='submit' class='btn btn-default' name='cancelSejarah' value='cancelSejarah'>Cancel</button>&emsp;";
                    echo "<button type='submit' class='btn btn-primary' name='addSejarah' value='addSejarah'>Konfirmasi</button>&emsp;";
                  echo "</div>";
              echo "</div>";
            echo "</div>";     
            echo "</div>";
          }              
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 350px;">   
          <br/>
          <?php
            $sql = "SELECT * FROM sejarah order by urutan";
            $result = $con->query($sql);
            echo "<div class='hidden-xs col-sm-1 col-md-1 col-lg-1'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>Urutan</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-8 col-md-9 col-lg-9'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>Sejarah</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-3 col-md-2 col-lg-2'>";
            echo "<p style='margin-top:10px;text-align:center;'><strong>Edit</strong></p>";    
            echo "</div>";
            echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            echo "<hr/>";
            echo "</div>";

            if ($result->num_rows > 0) {            
              $i=0;
              while($row4 = $result->fetch_assoc()) {
                echo "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
                echo "<p style='margin-left: 30px;'>" . $row4['urutan'] . "</p>";    
                echo "</div>";
                echo "<div class='col-xs-9 col-sm-8 col-md-9 col-lg-9'>";
                echo "<p style='margin-left: 30px;'>" . $row4['sejarah'] . "</p>";    
                echo "</div>";
                echo "<div class='col-xs-12 col-sm-3 col-md-2 col-lg-2'>";                
                echo "<button type='submit' class='btn btn-sm btn-danger pull-right' name='hapusSejarah' value='" . $row4['id'] . "'><span class='glyphicon glyphicon-trash'></span></button>";
                echo "<button type='submit' class='btn btn-sm btn-info pull-right' style='margin-right:20px;' name='editSejarah' value='" . $row4['id'] . "'><span class='glyphicon glyphicon-edit'></span></button>";
                echo "</div>";                
                echo "<div class='visible-xs col-xs-12'>";
                echo "<hr/>";
                echo "</div>";
                if((isset($_POST["editSejarah"]) && $kodeSejarah == $row4['id']) || (isset($_POST["hapusSejarah"]) && $kodeSejarah == $row4['id'])){
                  if(isset($_POST["editSejarah"])){
                    echo "<div class='panel panel-info col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                    echo "<div class='panel-heading'>Konfirmasi Edit</div>";
                  } 
                  else if(isset($_POST["hapusSejarah"])){
                    echo "<div class='panel panel-danger col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                    echo "<div class='panel-heading'>Konfirmasi Delete</div>";
                  } 
                    echo "<div class='panel-body' style='width:100%;'>";
                      echo "<div class='form-group'>";
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='noFaq'>Urutan : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<input type='text' class='form-control' id='urutan' name='urutan' value='" . $row4['urutan'] . "' placeholder='" . $row4['urutan'] . "'>";
                      echo "<span class='text-danger'>$noSejarahErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Sejarah'>Sejarah : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<textarea class='form-control' rows='5' id='editIsiSejarah' name='editIsiSejarah' value='" . $row4['sejarah'] . "' placeholder='add Sejarah...'>" . $row4['sejarah'] . "</textarea>";   
                      echo "<span class='text-danger'>$editSejarahErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>";        
                    echo "<div class='panel-footer clearfix'>";
                        echo "<div class='pull-right'>";                    
                            echo "<button type='submit' class='btn btn-default' name='cancelSejarah' value='" . $row4['id'] . "'>Cancel</button>&emsp;";
                            if((isset($_POST["hapusSejarah"]) && $kodeSejarah == $row4['id'])){ 
                              echo "<button type='submit' class='btn btn-primary' name='confirmSejarah' value='" . $row4['id'] . "'>Konfirmasi</button>&emsp;";
                            }
                            else{
                              echo "<button type='submit' class='btn btn-primary' name='saveSejarah' value='" . $row4['id'] . "'>Konfirmasi</button>&emsp;";
                            }
                        echo "</div>";
                    echo "</div>";
                  echo "</div>";     
                  echo "</div>";     
                }                
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";
              }
            }
          ?>
          <br/>          
        </div>
        <div class="clearfix visible-xs-block"></div>
        <div class="clearfix visible-sm-block"></div>
        <div class="clearfix visible-md-block"></div>
        <div class="clearfix visible-lg-block"></div>
      </form>  
    </div>      
  </div>
  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
      <form class="form-horizontal" id="visi" name="visi" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "#visi"; ?>" style="min-height: 460px;">  
        <input type="hidden" class="form-control" id="tambahMisi" name="tambahMisi" value="<?php echo $tambahMisi;?>" placeholder="tambahMisi" readonly>
        <div class="container" id="grad4">                  
          <div class="col-xs-6 col-sm-8 col-md-8 col-lg-6">
            <h4 style="color:white;margin-top: 15px;text-align: left;">Visi dan Misi</h4>  
          </div>
          <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
          <?php 
            echo "<button type='submit' style='font-size:14px;margin-top: 8px;' class='btn btn-sm btn-success pull-right' id='tambahMisi' name='tambahMisi' value='Misi'><span class='glyphicon glyphicon-plus'>&nbsp;</span>Tambah Misi&nbsp;</button>";         
          ?>          
          </div>
        </div>        
          <?php
            if(isset($_POST["tambahMisi"]) && $_POST["tambahMisi"] == "tambahMisi"){      
              $sql1 = "SELECT urutan FROM misi order by urutan desc";
              $result1 = $con->query($sql1);

              if ($result1->num_rows > 0) {   
                $row5 = $result1->fetch_assoc();
                $urutan = $row5['urutan'] + 1;
              }
              echo "<div class='panel panel-success col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
              echo "<div class='panel-heading'>Konfirmasi Add</div>";          
              echo "<div class='panel-body' style='width:100%;'>";
                echo "<div class='form-group'>";
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='noFaq'>Urutan : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<input type='text' class='form-control' id='urutan' name='urutan' value='$urutan' placeholder='' readonly>";
                echo "<span class='text-danger'>$noSejarahErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";
                echo "<div class='form-group'>";        
                echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Sejarah'>Sejarah : </label>";
                echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                echo "<textarea class='form-control' rows='5' id='editIsiMisi' name='editIsiMisi' value='$editIsiMisi' placeholder='add Misi...'>" . $editIsiMisi . "</textarea>";   
                echo "<span class='text-danger'>$editSejarahErr</span>";
                echo "</div>";
                echo "<div class='clearfix visible-xs-block'></div>";                 
                echo "</div>";        
              echo "<div class='panel-footer clearfix'>";
                  echo "<div class='pull-right'>";                    
                    echo "<button type='submit' class='btn btn-default' name='cancelMisi' value='cancelMisi'>Cancel</button>&emsp;";
                    echo "<button type='submit' class='btn btn-primary' name='addMisi' value='addMisi'>Konfirmasi</button>&emsp;";
                  echo "</div>";
              echo "</div>";
            echo "</div>";     
            echo "</div>";
          }              
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 350px;">  
          <br/>          
          <?php 
            echo "<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>";
            echo "<p style=''><strong>Visi : </strong>&emsp;" . $row['visi'] . "</p>";    
            echo "</div>";
            echo "<div class='col-xs-12 col-sm-2 col-md-2 col-lg-2'>";                            
            echo "<button type='submit' class='btn btn-sm btn-info pull-right' style='margin-right:20px;' name='editVisi' value='$visi'><span class='glyphicon glyphicon-edit'></span></button>";
            echo "</div>";
            if(isset($_POST["editVisi"])){                       
              if(isset($_POST["editVisi"])){
                echo "<div class='panel panel-info col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                echo "<div class='panel-heading'>Konfirmasi Edit</div>";
              } 
              else if(isset($_POST["hapus"])){
                echo "<div class='panel panel-danger col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                echo "<div class='panel-heading'>Konfirmasi Delete</div>";
              } 
                echo "<div class='panel-body' style='width:100%;'>";
                  echo "<div class='form-group'>";        
                  echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Visi'>Visi : </label>";
                  echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                  echo "<textarea class='form-control' rows='5' id='editIsiVisi' name='editIsiVisi' value='" . $row['visi'] . "' placeholder='Visi...'>" . $row['visi'] . "</textarea>";   
                  echo "<span class='text-danger'>$editVisiErr</span>";
                  echo "</div>";
                  echo "<div class='clearfix visible-xs-block'></div>";                 
                  echo "</div>";        
                echo "<div class='panel-footer clearfix'>";
                    echo "<div class='pull-right'>";                    
                        echo "<button type='submit' class='btn btn-default' name='CancelVisi' value='visi'>Cancel</button>&emsp;";
                        echo "<button type='submit' class='btn btn-primary' name='saveVisi' value='visi'>Konfirmasi</button>&emsp;";
                    echo "</div>";
                echo "</div>";
              echo "</div>";     
              echo "</div>";     
            }          
            echo "<div class='clearfix visible-xs-block'></div>";
            echo "<div class='clearfix visible-sm-block'></div>";
            echo "<div class='clearfix visible-md-block'></div>";
            echo "<div class='clearfix visible-lg-block'></div>";
          ?>
          <br/>
          <p style="margin-left: 15px;"><b>Misi :</b></p>          
          <?php
            $sql = "SELECT * FROM misi order by urutan";
            $result = $con->query($sql);

            echo "<div class='hidden-xs col-sm-1 col-md-1 col-lg-1'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>Urutan</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-8 col-md-9 col-lg-9'>";
            echo "<p style='margin-left: 30px;margin-top:10px;'><strong>Misi</strong></p>";    
            echo "</div>";
            echo "<div class='hidden-xs col-sm-3 col-md-2 col-lg-2'>";
            echo "<p style='margin-top:10px;text-align:center;'><strong>Edit</strong></p>";    
            echo "</div>";
            echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            echo "<hr/>";
            echo "</div>";                

            if ($result->num_rows > 0) {            
              $i=0;
              while($row6 = $result->fetch_assoc()) {
                echo "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
                echo "<p style='margin-left: 30px;'>" . $row6['urutan'] . "</p>";    
                echo "</div>";
                echo "<div class='col-xs-9 col-sm-8 col-md-9 col-lg-9'>";
                echo "<p style='margin-left: 30px;'>" . $row6['misi'] . "</p>";    
                echo "</div>";
                echo "<div class='col-xs-12 col-sm-3 col-md-2 col-lg-2'>";                
                echo "<button type='submit' class='btn btn-sm btn-danger pull-right' name='hapusMisi' value='" . $row6['id'] . "'><span class='glyphicon glyphicon-trash'></span></button>";
                echo "<button type='submit' class='btn btn-sm btn-info pull-right' style='margin-right:20px;' name='editMisi' value='" . $row6['id'] . "'><span class='glyphicon glyphicon-edit'></span></button>";
                echo "</div>";                
                echo "<div class='visible-xs col-xs-12'>";
                echo "<hr/>";
                echo "</div>";
                if((isset($_POST["editMisi"]) && $kodeMisi == $row6['id']) || (isset($_POST["hapusMisi"]) && $kodeMisi == $row6['id'])){                       
                  if(isset($_POST["editMisi"])){
                    echo "<div class='panel panel-info col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                    echo "<div class='panel-heading'>Konfirmasi Edit</div>";
                  } 
                  else if(isset($_POST["hapusMisi"])){
                    echo "<div class='panel panel-danger col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-8 col-lg-offset-2 col-lg-8' >";
                    echo "<div class='panel-heading'>Konfirmasi Delete</div>";
                  } 
                    echo "<div class='panel-body' style='width:100%;'>";
                      echo "<div class='form-group'>";
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='noFaq'>Urutan : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<input type='text' class='form-control' id='urutan' name='urutan' value='" . $row6['urutan'] . "' placeholder='" . $row6['urutan'] . "'>";
                      echo "<span class='text-danger'>$noMisiErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>";
                      echo "<div class='form-group'>";        
                      echo "<label style='font-size:12px;' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3' for='Misi'>Misi : </label>";
                      echo "<div class='col-xs-12 col-sm-8 col-md-8 col-lg-8'>";
                      echo "<textarea class='form-control' rows='5' id='editIsiMisi' name='editIsiMisi' value='" . $row6['misi'] . "' placeholder='add Misi...'>" . $row6['misi'] . "</textarea>";   
                      echo "<span class='text-danger'>$editMisiErr</span>";
                      echo "</div>";
                      echo "<div class='clearfix visible-xs-block'></div>";                 
                      echo "</div>";        
                    echo "<div class='panel-footer clearfix'>";
                        echo "<div class='pull-right'>";                    
                            echo "<button type='submit' class='btn btn-default' name='cancelMisi' value='" . $row6['id'] . "'>Cancel</button>&emsp;";
                            if((isset($_POST["hapusMisi"]) && $kodeMisi == $row6['id'])){ 
                              echo "<button type='submit' class='btn btn-primary' name='confirmMisi' value='" . $row6['id'] . "'>Konfirmasi</button>&emsp;";
                            }
                            else{
                              echo "<button type='submit' class='btn btn-primary' name='saveMisi' value='" . $row6['id'] . "'>Konfirmasi</button>&emsp;";
                            }
                        echo "</div>";
                    echo "</div>";
                  echo "</div>";     
                  echo "</div>";     
                }                
                echo "<div class='clearfix visible-xs-block'></div>";
                echo "<div class='clearfix visible-sm-block'></div>";
                echo "<div class='clearfix visible-md-block'></div>";
                echo "<div class='clearfix visible-lg-block'></div>";
              }
            }
          ?>          
          </ul>
          <br/>
        </div>
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