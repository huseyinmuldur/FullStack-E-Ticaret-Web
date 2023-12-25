<?php

include '../temelbolumler/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_girisi.php');
}

if(isset($_POST['submit'])){

   $isim = $_POST['isim'];
   $isim = filter_var($isim, FILTER_SANITIZE_STRING);
   $sifre = sha1($_POST['sifre']);
   $sifre = filter_var($sifre, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `adminler` WHERE isim = ?");
   $select_admin->execute([$isim]);

   if($select_admin->rowCount() > 0){
      $message[] = 'Kullanıcı Adı Zaten Mevcut';
   }else{
      if($pass != $cpass){
         $message[] = 'Şifreler aynı değil!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `adminler`(isim, sifre) VALUES(?,?)");
         $insert_admin->execute([$isim, $sifre]);
         $message[] = 'Yeni Admin Başarıyla Kayıt Edildi!';
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
   <title>Admin Kayıt Olma</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../temelbolumler/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>ŞİMDİ Kayıt OL</h3>
      <input type="text" name="isim" required placeholder="Kullanıcı adınızı girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="sifre" required placeholder="Şifrenizi girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Şifrenizi tekrar girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Kayıt Olun" class="btn" name="submit">
   </form>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>