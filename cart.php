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
  <title>Cart</title>
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
      width: 300px;
    }

    .thumbnail:hover span{ /*CSS for enlarged image on hover*/
      text-align: center;
      visibility: visible;
      top: -50;      
      left: 125px; /*position where enlarged image should offset horizontally */
      width: 310px;      
    }
  </style>
</head>
<body style="z-index: -1;">  
  <div class="container" style="margin-top: 70px;">
      <form class="form-horizontal" id="reminder" name="reminder" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <div class="container" id="grad4">                  
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4 style="color:white;margin-top: 15px;text-align: left;">Keranjang Belanja</h4>  
          </div>          
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
          <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='border: 1px solid gainsboro;padding: 5px;margin-right: 25px;'>
        <?php
          if(!isset($cart2)) {
            echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"> <img class="img-responsive" style="margin:0 auto;" src="image/cart-empty.png"></div>';
            echo '<div class="visible-lg col-lg-12" style="min-height:100px;"><br/></div>';
          }
          else{
        ?>  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
            <div class="visible-xs"><p><strong>Keranjang Belanja</strong></p></div> 
            <div class="hidden-xs col-sm-6 col-md-5 col-lg-5"><p><strong>Produk</strong></p></div>                  
            <div class="hidden-xs col-sm-2 col-md-1 col-lg-1"><p><strong>Jumlah</strong></p></div>        
            <div class="hidden-xs col-sm-2 col-md-2 col-lg-2"><p style="text-align: right"><strong>Harga</strong></p></div>        
            <div class="hidden-xs col-sm-2 col-md-2 col-lg-2"><p style="text-align: right"><strong>Total</strong></p></div> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="border-bottom: 2px solid grey;"></p></div>
            <?php
              $grandtotal = 0;                
              foreach ($cart2 as $key => $value) {
            ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divhover" style="padding: 10px;"> 
                  <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                    <div class="hidden-xs hidden-sm col-md-5 col-lg-4">
                      <a class="thumbnail pull-left" href="#"> <img class="img-responsive" src="<?php echo isset($value) ? $value['image'] : "" ?>" style="height: 150px;"> <span><img src="<?php echo isset($value) ? $value['image'] : "" ?>" /><br /><?php echo isset($value) ? $value['produk'] : "" ?></span></a>
                    </div>
                    <div class="visible-sm col-sm-5">
                      <a class="thumbnail pull-left" href="#"> <img class="img-responsive" src="<?php echo isset($value) ? $value['image'] : "" ?>" style="height: 130px;"> <span><img src="<?php echo isset($value) ? $value['image'] : "" ?>" /><br /><?php echo isset($value) ? $value['produk'] : "" ?></span></a>
                    </div>
                    <div class="visible-xs col-xs-6">
                      <a class="pull-left" href="#"> <img class="img-responsive" src="<?php echo isset($value) ? $value['image'] : "" ?>" style="height: 150px;"></a>
                    </div>
                    <div class="col-xs-6 col-sm-7 col-md-7 col-lg-8">
                      <p class="text-left" style="color: #034f84;"><?php echo "<a href='detailproduct.php?id=" . $value['id'] . "'>" . $value['produk'] . "</a>"; ?></p>
                    </div>      
                  </div>
                  <div class="hidden-xs col-sm-2 col-md-1 col-lg-1" style="text-align: center">
                    <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo isset($value) ? $value['qty'] : "" ?>">
                  </div>
                  <div class="hidden-xs col-sm-2 col-md-2 col-lg-2">
                    <p style="margin-top: 7px;text-align: right"><strong><?php echo isset($value) ? "Rp " . number_format($value['price'],0,',','.') : "" ?></strong></p>
                  </div>
                  <div class="hidden-xs col-sm-2 col-md-2 col-lg-2">
                    <p style="margin-top: 7px;text-align: right"><strong><?php echo isset($value) ? "Rp " . number_format($value['total'],0,',','.') : "" ?></strong></p>
                  </div>      
                  <div class="visible-xs col-xs-12">
                    <hr/>
                    <div class="col-xs-6" style="text-align: center">
                      <p style="text-align: right">Jumlah</p>
                    </div>
                    <div class="col-xs-6" style="text-align: center">
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo isset($value) ? $value['qty'] : "" ?>">
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                    <div class="col-xs-6" style="text-align: center">
                      <p style="text-align: right">Harga</p>                    
                    </div>
                    <div class="col-xs-6" style="text-align: center">
                      <p style="text-align: right"><strong><?php echo isset($value) ? "Rp " . number_format($value['price'],0,',','.') : "" ?></strong></p>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                    <div class="col-xs-6" style="text-align: center">
                      <p style="text-align: right">Total</p>
                    </div> 
                    <div class="col-xs-6" style="text-align: center">                    
                      <p style="text-align: right"><strong><?php echo isset($value) ? "Rp " . number_format($value['total'],0,',','.') : "" ?></strong></p>
                    </div>                    
                    <div class="clearfix visible-xs-block"></div>
                    <hr/>
                  </div>          
                  <div class="clearfix visible-sm-block"></div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">                
                    <button type="button" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-trash"></span></button><br/><br/>
                  </div>  
                  <div class="clearfix visible-xs-block"></div>
                  <div class="clearfix visible-sm-block"></div>
                  <div class="clearfix visible-md-block"></div>
                  <div class="clearfix visible-lg-block"></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="border-bottom: 1px solid grey;"></p></div>
            <?php
                $grandtotal += isset($value) ? $value['total'] : 0;
              }
            ?>
                     <!--  <tr>
                          <td class="col-md-6">
                          <div class="media">
                              <a class="thumbnail pull-left" href="#"> <img class="media-object" src="image/product2.jpeg" style="width: 72px; height: 72px;"> </a>
                              <div class="media-body">
                                  <p class="media-heading"><a href="#">Product name</a></p>
                                  <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                  <span>Status: </span><span class="text-warning"><strong>Leaves warehouse in 2 - 3 weeks</strong></span>
                              </div>
                          </div></td>
                          <td class="col-md-1" style="text-align: center">
                          <input type="email" class="form-control" id="exampleInputEmail1" value="2">
                          </td>
                          <td class="col-md-1 text-center"><strong>$4.99</strong></td>
                          <td class="col-md-1 text-center"><strong>$9.98</strong></td>
                          <td class="col-md-1">
                          <button type="button" class="btn btn-danger">
                              <span class="glyphicon glyphicon-remove"></span> Remove
                          </button></td>
                      </tr> -->
                    <!--   <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><h5>Subtotal</h5></td>
                          <td class="text-right"><h5><strong><?php echo $subtotal; ?></strong></h5></td>
                      </tr> -->
                     <!--  <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><h5>Ongkos Kirim</h5></td>
                          <td class="text-right"><h5><strong>9000</strong></h5></td>
                      </tr> -->
              
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: white;">           
            <div class="col-xs-6 col-sm-8 col-md-10 col-lg-10" style="margin-top: 10px;">                   
              <p style="text-align: right">Total Belanja :</p>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2" style="margin-top: 10px;">
              <p style="text-align: right"><strong><?php echo "Rp " . number_format($grandtotal,0,',','.'); ?></strong></p>
            </div>     
          </div>           
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="border-bottom: 1px solid grey;"></p></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
            <a class="pull-right" href="pemesanan.php"><button type="button" class="btn btn-success">
              Pemesanan <span class="glyphicon glyphicon-play"></span>
            </button></a>                                         
            <a class="pull-right" href="product.php" style="margin-right: 20px;"><button type="button" class="btn btn-default">
              <span class="glyphicon glyphicon-shopping-cart"></span> Belanja
            </button></a>          
          </div>
        <?php
          }
        ?> 
          </div>
        </div>
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