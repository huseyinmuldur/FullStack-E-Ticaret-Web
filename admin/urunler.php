<?php

include '../temelbolumler/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_girisi.php');
};

if(isset($_POST['add_product'])){

   $isim = $_POST['isim'];
   $isim = filter_var($isim, FILTER_SANITIZE_STRING);
   $fiyat = $_POST['fiyat'];
   $fiyat = filter_var($fiyat, FILTER_SANITIZE_STRING);
   $detaylar = $_POST['detaylar'];
   $detaylar = filter_var($detaylar, FILTER_SANITIZE_STRING);

   $resim1 = $_FILES['resim1']['isim'];
   $resim1 = filter_var($resim, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['resim1']['size'];
   $image_tmp_name_01 = $_FILES['resim1']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$resim1;

   $resim2 = $_FILES['resim2']['isim'];
   $resim2 = filter_var($resim2, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['resim2']['size'];
   $image_tmp_name_02 = $_FILES['resim2']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$resim2;

   $resim3 = $_FILES['resim3']['isim'];
   $resim3 = filter_var($resim3, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['resim3']['size'];
   $image_tmp_name_03 = $_FILES['resim3']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$resim3;

   $select_products = $conn->prepare("SELECT * FROM `urunler` WHERE isim = ?");
   $select_products->execute([$isim]);

   if($select_products->rowCount() > 0){
      $message[] = 'ürün adı zaten mevcut!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `urunler`(isim, detaylar, fiyat, resim1, resim2, resim3) VALUES(?,?,?,?,?,?)");
      $insert_products->execute([$isim, $detaylar, $fiyat, $resim1, $resim2, $resim3]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'resim boyutu yüksek!!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'Yeni ürün eklendi';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `urunler` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['resim1']);
   unlink('../uploaded_img/'.$fetch_delete_image['resim2']);
   unlink('../uploaded_img/'.$fetch_delete_image['resim3']);
   $delete_product = $conn->prepare("DELETE FROM `urunler` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `sepet` WHERE urun_id = ?");
   $delete_cart->execute([$delete_id]);
   header('location:urunler.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ürünler</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../temelbolumler/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">Ürün Ekle</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Ürün İsmi (Zorunlu)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Ürün ismini girin" name="isim">
         </div>
         <div class="inputBox">
            <span>Ürün Fiyatı (Zorunlu)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="Ürünün fiyatını girin" onkeypress="if(this.value.length == 10) return false;" name="fiyat">
         </div>
        <div class="inputBox">
            <span>Resim 1 (Zorunlu)</span>
            <input type="file" name="resim1" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Resim 2 (Zorunlu)</span>
            <input type="file" name="resim2" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Resim 3 (Zorunlu)</span>
            <input type="file" name="resim3" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>Ürün Detayları (Zorunlu)</span>
            <textarea name="detaylar" placeholder="Ürünün detaylarını girin" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      
      <input type="submit" value="Ürünü Ekle" class="btn" name="urun_ekle">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">Eklenen Ürünler</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `urunler`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['resim1']; ?>" alt="">
      <div class="name"><?= $fetch_products['isim']; ?></div>
      <div class="price"><span><?= $fetch_products['fiyat']; ?></span>TL</div>
      <div class="details"><span><?= $fetch_products['detaylar']; ?></span></div>
      <div class="flex-btn">
         <a href="urun_guncelleme.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Güncelle</a>
         <a href="urunler.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Ürün silinsin mi?');">Sil</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Henüz Ürün Eklenmedi!</p>';
      }
   ?>
   
   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>