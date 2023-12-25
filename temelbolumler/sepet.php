<?php

if(isset($_POST['sepete_ekle'])){

   if($user_id == ''){
      header('location:user_login.php');
   }else{

      $urun_id = $_POST['urun_id'];
      $urun_id = filter_var($urun_id, FILTER_SANITIZE_STRING);
      $isim = $_POST['isim'];
      $isim = filter_var($isim, FILTER_SANITIZE_STRING);
      $fiyat = $_POST['fiyat'];
      $fiyat = filter_var($fiyat, FILTER_SANITIZE_STRING);
      $resim = $_POST['resim'];
      $resim = filter_var($resim, FILTER_SANITIZE_STRING);
      $adet = $_POST['adet'];
      $adet = filter_var($adet, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `sepet` WHERE isim = ? AND user_id = ?");
      $check_cart_numbers->execute([$isim, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'Sepete eklendi!';
      }

         $insert_cart = $conn->prepare("INSERT INTO `sepet`(user_id, urun_id, isim, fiyat, adet, resim) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $urun_id, $isim, $fiyat, $adet, $resim]);
         $message[] = 'Sepete eklendi!';
         
      }

   }

?>