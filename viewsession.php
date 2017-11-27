<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
session_start();

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";


include 'connect.php';

  $db = new DB_Connect();
  $con = $db->connect();
if(isset($_SESSION['cart']))
  { 
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
}

	echo '<body>';
	
    $grandtotal = 0;                
    foreach ($cart2 as $key => $value) 
    {
    ?>
		<div class="panel-body">
		<img style="height: 150px;" src="<?php echo isset($value) ? $value['image'] : "" ?>"></a>
		<?php echo isset($value) ? $value['produk'] : "" ?> <?php echo isset($value) ? $value['id'] : "" ?> <?php echo isset($value) ? "Rp " . number_format($value['price'],0,',','.') : "" ?>x<?php echo isset($value) ? $value['qty'] : "" ?>		Total <?php echo isset($value) ? "Rp " . number_format($value['total'],0,',','.') : "" ?><br><br><br><br><br>
		</div>
		<?php $grandtotal += isset($value) ? $value['total'] : 0;
	}
	echo "Grand Total Rp. ".number_format($grandtotal,0,',','.');
	echo '</body>';
	//echo file_get_contents("cart.php");
?>