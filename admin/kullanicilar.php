<?php

include '../temelbolumler/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_girisi.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `kullanicilar` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `urunler` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `mesajlar` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `sepet` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:kullanicilar.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Kullanıcı Hesapları</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../temelbolumler/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">Kullanıcı Hesapları</h1>

   <div class="box-container">

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `kullanicilar`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> Kullanıcı id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Kullanıcı Adı : <span><?= $fetch_accounts['isim']; ?></span> </p>
      <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="kullanicilar.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Bu hesap silinsin mi? Kullanıcıyla ilgili tüm bilgiler de silinecektir!')" class="delete-btn">Sil</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Henüz kullanıcı bulunmamaktadır!</p>';
      }
   ?>

   </div>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>