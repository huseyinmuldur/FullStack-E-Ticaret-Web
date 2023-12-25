<?php

include '../temelbolumler/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_girisi.php');
}

if(isset($_POST['update'])){

   $urun_id = $_POST['urun_id'];
   $isim = $_POST['isim'];
   $isim = filter_var($isim, FILTER_SANITIZE_STRING);
   $fiyat = $_POST['fiyat'];
   $fiyat = filter_var($fiyat, FILTER_SANITIZE_STRING);
   $detaylar = $_POST['detaylar'];
   $detaylar = filter_var($detaylar, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `urunler` SET isim = ?, fiyat = ?, detaylar = ? WHERE id = ?");
   $update_product->execute([$isim, $fiyat, $detaylar, $urun_id]);

   $mesaj[] = 'Ürün başarıyla güncellendi!';

   $old_image_01 = $_POST['old_image_01'];
   $resim1 = $_FILES['resim1']['name'];
   $resim1 = filter_var($resim1, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['resim1']['size'];
   $image_tmp_name_01 = $_FILES['resim1']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$resim1;

   if(!empty($resim1)){
      if($image_size_01 > 2000000){
         $message[] = 'Resim boyutu yüksek!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `urunler` SET resim1 = ? WHERE id = ?");
         $update_image_01->execute([$resim1, $urun_id]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $mesaj[] = 'Resim 1 başarıyla güncellendi!';
      }
   }

   $old_image_02 = $_POST['old_image_02'];
   $resim2 = $_FILES['resim2']['isim'];
   $resim2 = filter_var($resim2, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['resim2']['size'];
   $image_tmp_name_02 = $_FILES['resim2']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$resim2;

   if(!empty($resim2)){
      if($image_size_02 > 2000000){
         $mesaj[] = 'Resim boyutu yüksek!';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `urunler` SET resim2 = ? WHERE id = ?");
         $update_image_02->execute([$resim2, $urun_id]);
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         unlink('../uploaded_img/'.$old_image_02);
         $mesaj[] = 'Resim 2 başarıyla güncellendi!';
      }
   }

   $old_image_03 = $_POST['old_image_03'];
   $resim3 = $_FILES['resim3']['isim'];
   $resim3 = filter_var($resim3, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['resim3']['size'];
   $image_tmp_name_03 = $_FILES['resim3']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$resim3;

   if(!empty($resim3)){
      if($image_size_03 > 2000000){
         $mesaj[] = 'Resim boyutu yüksek!';
      }else{
         $update_image_03 = $conn->prepare("UPDATE `urunler` SET resim3 = ? WHERE id = ?");
         $update_image_03->execute([$resim3, $urun_id]);
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
         unlink('../uploaded_img/'.$old_image_03);
         $mesaj[] = 'Resim 3 başarıyla güncellendi!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ürünü Güncelle</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../temelbolumler/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">Üürünü Güncelle</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `urunler` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
         </div>
      </div>
      <span>Güncel İsim</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['isim']; ?>">
      <span>Güncel Fiyat</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['fiyat']; ?>">
      <span>Güncel Detaylar</span>
      <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['detaylar']; ?></textarea>
      <span>Güncel Resim 1</span>
      <input type="file" name="resim1" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>Güncel Resim 2</span>
      <input type="file" name="resim2" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>Güncel Resim 3</span>
      <input type="file" name="resim3" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="Güncelle">
         <a href="urunler.php" class="option-btn">Geri Dön</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">Henüz Ürün Bulunmamaktadır!</p>';
      }
   ?>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>