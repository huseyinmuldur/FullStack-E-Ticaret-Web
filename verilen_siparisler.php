<?php

include 'temelbolumler/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Verilen Siparişler</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'temelbolumler/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">VERİLEN SİPARİŞLER</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Siparişlerinizi görmek için lütfen giriş yapın</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `siparisler` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Sipariş tarihi : <span><?= $fetch_orders['siparis_tarihi']; ?></span></p>
      <p>Ad Soyad : <span><?= $fetch_orders['isim']; ?></span></p>
      <p>Email Adresi: <span><?= $fetch_orders['email']; ?></span></p>
      <p>Telefon Numarası : <span><?= $fetch_orders['numara']; ?></span></p>
      <p>Adres : <span><?= $fetch_orders['adres']; ?></span></p>
      <p>Ödeme Tipi : <span><?= $fetch_orders['odeme_yontemi']; ?></span></p>
      <p>Siparişlerin : <span><?= $fetch_orders['toplam_urun']; ?></span></p>
      <p>Toplam ücret : <span><?= $fetch_orders['toplam_ucret']; ?>TL</span></p>
      <p> Ödeme durumu : <span style="color: red;">Beklemede</span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">Henüz sipariş verilmedi!</p>';
      }
      }
   ?>

   </div>

</section>






<?php include 'temelbolumler/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>