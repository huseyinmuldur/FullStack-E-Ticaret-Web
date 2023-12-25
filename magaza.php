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
   <title>Mağaza</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'temelbolumler/user_header.php'; ?>

<section class="products">

   <h1 class="heading">SON YÜKLENEN ÜRÜNLER</h1>

   <div class="box-container">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `urunler`"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="urun_id" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="isim" value="<?= $fetch_product['isim']; ?>">
      <input type="hidden" name="fiyat" value="<?= $fetch_product['fiyat']; ?>">
      <input type="hidden" name="resim" value="<?= $fetch_product['resim1']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="urun_detay.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['resim1']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span></span><?= $fetch_product['fiyat']; ?><span>TL</span></div>
         <input type="number" name="adet" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Sepete Ekle" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Henüz ürün bulunmamaktadır!</p>';
   }
   ?>

   </div>

</section>



<?php include 'temelbolumler/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>