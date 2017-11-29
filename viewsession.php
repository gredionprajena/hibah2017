<html>
<?php
session_start();
include 'connect.php';

  $db = new DB_Connect();
  $con = $db->connect();
	if(!isset($_GET['kode']))
	{ 
	    $sql = "SELECT * FROM pemesanan p 
	    JOIN pemesanan_detail pd ON p.kode_pemesanan = pd.kode_pemesanan 
	    JOIN produk pr ON pd.id_barang = pr.id
	    WHERE p.kode_pemesanan='171129173411652'";

		$result = $con->query($sql);
		for($i=0; $i < $result->num_rows; $i++)
			$data[$i] = $result->fetch_assoc();

// echo "<pre>";
// print_r($data);
// echo "</pre>";
	}

  $sql = "SELECT * FROM ukm where id = '1'";  
  $result = $con->query($sql);


  if($result->num_rows > 0 ){
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $alamat = $row['alamat'];
    $logo = $row['logo'];
    $hdcolor = $row['headercolor'];
    $ftcolor = $row['footercolor'];
    $tghcolor = $row['contentcolor'];
    $visi = $row['visi'];
  }

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
ob_start();
?>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
td { 
    padding: 2px;
}
</style>
<title>email</title>
</head>
<body>
<div class="container" style="text-align:center;">
	<?php
    if(isset($data))
    {
    	echo 'Terima kasih telah melakukan pemesanan<br>';
    	echo 'Hai '.$data[0]['nama_penerima'].', Anda telah melakukan pemesanan dengan kode transaksi<br>';
    	echo '<h4>'.$data[0]['kode_pemesanan'].'</h4><br>';
    	echo 'Total transaksi <h4>Rp. '. number_format($data[0]['total_bayar'],0,',','.').'</h4><br>';
    	echo 'Mohon segera lakukan pembayaran  ke rekening munafood.<br>';
    	echo 'Lakukan konfirmasi pembayaran jika sudah melakukan pembayaran.';
    	echo '<a href="munafood.com/confirm.php">Konfirmasi</a><br><hr>';

    $grandtotal = 0;
    $total_berat  = 0.0;

	echo '<div class="center-block">';
	echo '<table border="0">';
    foreach ($data as $key => $value) 
    {
    ?>
		<tr>
			<td style="width:5%;"></td>
			<td style="width:3%;"><a href="munafood.com/detailproduct.php?id=<?php echo $value['id']; ?>"><img style="width: 100%;" src="http://munafood.com/<?php echo $value['image'] ?>"></a></td>
			<td style="width:5%;"><a href="munafood.com/detailproduct.php?id=<?php echo $value['id']; ?>"><h4><?php echo $value['produk'] ?></h4></a></td>
			<td style="width:5%;"><?php echo "Rp " . number_format($value['harga'],0,',','.') ?> x <?php echo $value['qty'] ?></td>
			<td style="width:5%;"><?php echo $value['beratbaru'] ?> kg</td>
			<td style="width:5%;"><?php echo "Rp " . number_format($value['harga']*$value['qty'],0,',','.') ?></td>
			<td style="width:5%;"></td>
		</tr>
		<?php $grandtotal += $value['harga']*$value['qty'];
			$total_berat += $value['beratbaru']*$value['qty'];
	}
		echo '<tr><td></td><td></td>';
    	echo '<td>'.$data[0]['jasa_pengiriman'].'-'.$data[0]['tipe_pengiriman'].'</td>';
    	echo '<td colspan="2">Rp. '.number_format($data[0]['harga_per_kg'],0,',','.').' x '.$total_berat.' kg</td>';
    	//echo '<td></td>';
    	echo '<td>Rp. '.number_format($data[0]['total_ongkir'],0,',','.').'</td>';
    	echo '</tr>';
	echo "</table>Grand Total Rp. ".number_format($grandtotal+$total_berat,0,',','.')."</div><hr>";

    	echo $data[0]['no_telp'].'<br>';
    	echo $data[0]['alamat_lengkap'].'<br>';
    	echo $data[0]['kota'].'<br>';
    	echo $data[0]['provinsi'].'<br>';
    	echo $data[0]['kode_pos'].'<br>';
	}
	echo '</body>';
	//echo file_get_contents("cart.php");
	//include "footer.php";

?>
</div>
</html>
<?php

    $output = ob_get_clean( );
	//$output = ob_get_contents();
    //echo $output;
  	include "back/function.php";
// 	echo send_email("adrianto.dennise@yahoo.com", "tes", $output, 0);
	echo send_email("gredionprajena@gmail.com", "tes", $output, 0);
?>