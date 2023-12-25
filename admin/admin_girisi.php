<?php

include '../temelbolumler/connect.php';

session_start();

if(isset($_POST['submit'])){

   $isim = $_POST['isim'];
   $isim = filter_var($isim, FILTER_SANITIZE_STRING);
   $sifre = sha1($_POST['sifre']);
   $sifre = filter_var($sifre, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `adminler` WHERE isim = ? AND sifre = ?");
   $select_admin->execute([$isim, $sifre]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:gosterge_paneli.php');
   }else{
      $message[] = 'Yanlış kullanıcı adı veya parola!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giriş Yapma</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../temelbolumler/admin_header.php'; ?>

<?php
   if(isset($mesajlar)){
      foreach($message as $mesajlar){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <form action="" method="post">
      <h3>Şimdi Giriş Yap</h3>
      <p>Varsayılan Kullanıcı Adı = <span>admin</span> & Şifre = <span>111</span></p>
      <input type="text" name="isim" required placeholder="Kullanıcı adınızı girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="sifre" required placeholder="Şifrenizi girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Şimdi Giriş Yap" class="btn" name="submit">
   </form>

</section>
   
</body>
</html>