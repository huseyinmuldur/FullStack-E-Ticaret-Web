<?php

include '../temelbolumler/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_girisi.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `adminler` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_hesabi.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Hesabı</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../temelbolumler/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">ADMİN HESABI</h1>

   <div class="box-container">

   <div class="box">
      <p>Yeni Admin ekle</p>
      <a href="admin_kayit.php" class="option-btn">Admin Kayıt</a>
   </div>

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `adminler`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> admin ismi : <span><?= $fetch_accounts['isim']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_hesabi.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Bu hesap silinsin mi?')" class="delete-btn">Sil</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="profil_guncelleme.php" class="option-btn">Güncelle</a>';
            }
         ?>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Hesap mevcut değil!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>