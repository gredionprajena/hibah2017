<?php
  include '../connect.php';
  include '../session.php';
  include 'function.php';

  if(!isset($_SESSION['user_id'])){header("Location: ../login.php");}
  if($_SESSION['role'] != 2){header("Location: ../login.php");}

  $db = new DB_Connect();
  $con = $db->connect();

  $sql = "SELECT * FROM ukm where id = '1'";  
  $result = $con->query($sql);
  
  if(isset($_SESSION['jml'])) $jml = $_SESSION['jml'];
  else {$jml = 0;}

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
?>

<style type="text/css">
  /* unvisited link */
  a.linkmenu {color:white;}
  a.linkmenu:link  {text-decoration: none; color: white;}
  a.linkmenu:visited {text-decoration: none; color: white;}
  a.linkmenu:hover {text-decoration: underline; color: black;}
  a.linkmenu:active {text-decoration: none; color: black;}

  a.linksubmenu {color:black;}
  a.linksubmenu:link  {text-decoration: none; color: black;}
  a.linksubmenu:visited {text-decoration: none; color: black;}
  a.linksubmenu:hover {text-decoration: underline; color: blue;}
  a.linksubmenu:active {text-decoration: none; color: blue;}
</style>

<div class="container" style="color: white;font-size: 16px;">
  <nav role="navigation" class="navbar navbar-fixed-top">
    <div >
      <div class="navbar-header" style="background-color: <?php echo $hdcolor; ?>;">
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="pull-left navbar-toggle">
          <span class="glyphicon glyphicon-menu-hamburger"></span>
          <span> <?php echo $name; ?></span>
        </button>
          
      </div>
      <!-- Collection of nav links, forms, and other content for toggling -->
      <div id="navbarCollapse" class="collapse navbar-collapse" style="background-color: <?php echo $hdcolor; ?>;">
        <?php     
          echo "<ul class='nav navbar-nav'>";
          echo "<li><a class='linkmenu hidden-xs' href='index.php' style='border-right:1px solid grey;margin-right:50px;'>$name</a></li>";    
          echo "<li><a class='linkmenu' href='addProduct.php'>Produk</a></li>";           
          echo "<li><a class='linkmenu' href='toko.php'>Toko</a></li>";            
          echo "<li><a class='linkmenu' href='konsinyasi.php'>Konsinyasi</a></li>";    
          echo "<li><a class='linkmenu' href='pesanan.php'>Pesanan</a></li>";      
          echo "<li><a class='linkmenu' href='email.php'>Email</a></li>";      
          echo "<li class='divider visible-xs'></li>";   
          echo "<li><a class='linkmenu visible-xs' href='changePassword.php'>Ganti Password</a></li>";      
          echo "<li><a class='linkmenu visible-xs' href='logout.php'>Logout</a></li>";                    
          echo "</ul>";
        ?>
        <ul class="nav navbar-nav navbar-right" style="margin-right: 50px;"> 
          <?php          
            if(isset($_SESSION['email'])){
          ?>
              <li class="dropdown">
                <a class="linkmenu hidden-xs" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["name"]; ?> <span class="caret"></span></a>
                <ul role="menu" class="dropdown-menu">              
                  <li><a class="linksubmenu hidden-xs" href="changePassword.php">Ganti Password</a></li>
                  <li class="divider hidden-xs"></li>
                  <li><a class="linksubmenu hidden-xs" href="../logout.php">Logout</a></li>
                </ul>
              </li>
          <?php             
            }
            else
              echo "<li><a class='linkmenu' href='../login.php' >Login / Daftar</a></li>";
          ?>
          
        </ul>
      </div>                  
    </div>
  </nav>
</div>
