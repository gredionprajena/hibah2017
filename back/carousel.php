<style>
#grad1 {
    width: 100%;
    background: red; /* For browsers that do not support gradients */
    background: -webkit-linear-gradient(left, white , white); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(right, white, white); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(right, white, white); /* For Firefox 3.6 to 15 */
    background: linear-gradient(to right, white, white); /* Standard syntax */
}
#grad2 {
    margin-top: 60px;
    height: 150px; 
    width: 100%;
    background: red; /* For browsers that do not support gradients */
    background: -webkit-linear-gradient(left, #BE1E2D , #BE1E2D); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(right, #BE1E2D, #BE1E2D); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(right, #BE1E2D, #BE1E2D); /* For Firefox 3.6 to 15 */
    background: linear-gradient(to right, #BE1E2D, #BE1E2D); /* Standard syntax */
}
</style>
<!-- <div class="container visible-xs" id="grad2">
  <div class="col-xs-5 col-sm-2 col-md-2 col-lg-1">
    <img style="margin-top: 30px;" class="img-responsive" src="image/SatuBon_Red_Logo.png">
  </div>
  <div class="col-xs-12 col-sm-10 col-md-10 col-lg-11">        
    <h5 style="color:white;margin-top: 10px;">Aplikasi pintar untuk pembayaran Anda</h5>
  </div>                  
</div> -->
<div class="container visible-xs" id="grad1" style="background-color: white; width: 100%;margin-top: 50px;margin-bottom: 30px;">
  <?php
    // if($user_type == 1){
  ?>
      <!-- <h4 class="text-right" style="color:black;margin-top: 75px;">SALDO :  -->
        <?php 
          // echo "Rp " . number_format($bal,2,',','.'); 
        ?>          
      <!-- </h4> -->
  <?php  
    // }    
  ?>
</div>
<div class="container hidden-xs" style="background-color: white; width: 100%;margin-top: 50px;margin-bottom: 10px;">
<!--   <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>   
      <div class="carousel-inner">
        <div class="item active">
            <img src="image/caro1.jpg" alt="First Slide">
        </div>
        <div class="item">
            <img src="image/caro2.jpg" alt="First Slide">
        </div>
        <div class="item">
            <img src="image/caro3.jpg" alt="First Slide">
        </div>
      </div>
      <a class="carousel-control left" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
      </a>
      <a class="carousel-control right" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
      </a>
  </div> -->
  <!-- <img class="img-responsive" style="width: 100%;" src="image/banner.png" alt="Banner"> -->

  <?php
    // if($user_type == 1){
  ?>
      <!-- <h4 class="text-right" style="color:black;">SALDO :  -->
        <?php 
          // echo "Rp " . number_format($bal,2,',','.'); 
        ?>
      <!-- </h4> -->
  <?php  
    // }    
  ?>
  <!-- <hr> -->
</div> 