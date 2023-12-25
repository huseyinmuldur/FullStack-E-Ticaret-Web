<?php

include 'temelbolumler/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:kullanici_giris.php');
};

if(isset($_POST['order'])){

   $isim = $_POST['isim'];
   $isim = filter_var($isim, FILTER_SANITIZE_STRING);
   $numara = $_POST['numara'];
   $numara = filter_var($numara, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $odeme_yontemi = $_POST['odeme_yontemi'];
   $odeme_yontemi = filter_var($odeme_yontemi, FILTER_SANITIZE_STRING);
   $adres = ''. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' ';
   $adres = filter_var($adres, FILTER_SANITIZE_STRING);
   $toplam_urun = $_POST['toplam_urun'];
   $toplam_ucret = $_POST['toplam_ucret'];

   $check_cart = $conn->prepare("SELECT * FROM `sepet` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, isim, numara, email, odeme_yontemi, adres, toplam_urun, toplam_ucret) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $isim, $numara, $email, $odeme_yontemi, $adres, $toplam_urun, $toplam_ucret]);

      $delete_cart = $conn->prepare("DELETE FROM `sepet` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Siparişiniz başarıyla verildi!';
   }else{
      $message[] = 'Sepetinizde henüz ürün bulunmamaktadır!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sipariş Bilgisi</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'temelbolumler/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Sepet Bilgisi</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `sepet` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['isim'].' ('.$fetch_cart['fiyat'].' x '. $fetch_cart['adet'].') - ';
               $toplam_urun = implode($cart_items);
               $grand_total += ($fetch_cart['fiyat'] * $fetch_cart['adet']);
      ?>
         <p> <?= $fetch_cart['isim']; ?> <span>(<?= ''.$fetch_cart['fiyat'].'TL x '. $fetch_cart['adet']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">Sepetinizde henüz ürün bulunmamaktadır!</p>';
         }
      ?>
         <input type="hidden" name="toplam_urun" value="<?= $toplam_urun; ?>">
         <input type="hidden" name="toplam_ucret" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Genel Toplam : <span><?= $grand_total; ?>TL</span></div>
      </div>

      <h3>Sipariş Bilgilerinizi Girin</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Ad Soyad :</span>
            <input type="text" name="isim" placeholder="Ad ve Soyad girin" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Telefon Numarası :</span>
            <input type="number" name="numara" placeholder="Telefon numaranızı girin" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email Adresi :</span>
            <input type="email" name="email" placeholder="Email adresinizi girin" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Ödeme Tipi :</span>
            <select name="odeme_yontemi" class="box" required>
               <option value="Kapıda Ödeme">Kapıda Ödeme</option>
               <option value="Kredi Kartı">Kredi Kartı</option>
            </select>
         </div>

         <div class="inputBox">
            <span>Adres:</span>
            <input type="text" name="street" placeholder="Tam adresinizi girin" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>İl :</span>
            <input type="text" name="city" placeholder="İlinizi girin" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>İlçe :</span>
            <input type="text" name="state" placeholder="İlçenizi girin" class="box" maxlength="50" required>
         </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Siparişi Ver">

   </form>

</section>

<?php include 'temelbolumler/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>