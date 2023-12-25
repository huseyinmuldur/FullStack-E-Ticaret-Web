<?php

include 'temelbolumler/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'temelbolumler/sepet.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Detaylı Görünüm</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'temelbolumler/user_header.php'; ?>

<section class="quick-view">

   <h1 class="heading">DETAYLI GÖRÜNÜM</h1>

   <?php
     $urun_id = $_GET['urun_id'];
     $select_products = $conn->prepare("SELECT * FROM `urunler` WHERE id = ?"); 
     $select_products->execute([$urun_id]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="urun_id" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="isim" value="<?= $fetch_product['isim']; ?>">
      <input type="hidden" name="fiyat" value="<?= $fetch_product['fiyat']; ?>">
      <input type="hidden" name="resim" value="<?= $fetch_product['resim1']; ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploaded_img/<?= $fetch_product['resim1']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $fetch_product['resim1']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['resim2']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['resim3']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['isim']; ?></div>
            <div class="flex">
               <div class="fiyat"><span></span><?= $fetch_product['fiyat']; ?><span>TL</span></div>
               <input type="number" name="adet" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
            </div>
            <div class="detaylar"><?= $fetch_product['detaylar']; ?></div>
            <div class="flex-btn">
               <input type="submit" value="Sepete Ekle" class="btn" name="add_to_cart">
               <input class="option-btn" type="submit" name="add_to_wishlist" value="Favorilere Ekle">
            </div>
         </div>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Henüz ürün eklenmedi!</p>';
   }
   ?>

</section>


<?php include 'temelbolumler/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>