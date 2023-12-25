<?php

include '../temelbolumler/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_girisi.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $odeme_durumu = $_POST['odeme_durumu'];
   $odeme_durumu = filter_var($odeme_durumu, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `siparisler` SET odeme_durumu = ? WHERE id = ?");
   $update_payment->execute([$odeme_durumu, $order_id]);
   $message[] = 'Ödeme durumu güncellendi!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `siparisler` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:siparisler.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Siparişler</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../temelbolumler/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">VERİLEN SİPARİŞLER</h1>

<div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `siparisler`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Sipariş Tarihi : <span><?= $fetch_orders['siparis_tarihi']; ?></span> </p>
      <p> İsim : <span><?= $fetch_orders['isim']; ?></span> </p>
      <p> Numara : <span><?= $fetch_orders['numara']; ?></span> </p>
      <p> Adres : <span><?= $fetch_orders['adres']; ?></span> </p>
      <p> TopLam Ürün : <span><?= $fetch_orders['toplam_urun']; ?></span> </p>
      <p> Toplam Ücret : <span><?= $fetch_orders['toplam_ucret']; ?>TL</span> </p>
      <p> Ödeme Yöntemi : <span><?= $fetch_orders['odeme_yontemi']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="odeme_durumu" class="select">
            <option selected disabled></option>
            <option value="bekleme">Beklemede</option>
            <option value="completed">Tamamlandı</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="Güncelle" class="option-btn" name="update_payment">
         <a href="siparisler.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Sipariş Siliniyor...');">Sil</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Henüz Sipariş Verilmedi!</p>';
      }
   ?>

</div>

</section>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>