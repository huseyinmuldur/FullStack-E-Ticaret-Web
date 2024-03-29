<?php

include 'temelbolumler/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $sifre = sha1($_POST['sifre']);
   $sifre = filter_var($sifre, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `kullanicilar` WHERE email = ? AND sifre = ?");
   $select_user->execute([$email, $sifre]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:anasayfa.php');
   }else{
      $message[] = 'Yanlış kullanıcı adı ya da parola!';
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
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'temelbolumler/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>GİRİŞ YAPMA</h3>
      <input type="email" name="email" required placeholder="Email adresinizi girin" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="sifre" required placeholder="Şifrenizi girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Giriş Yap" class="btn" name="submit">
      <p>Hesabınız yok mu?</p>
      <a href="kullanici_kayit.php" class="option-btn">Kayıt Ol</a>
   </form>

</section>













<?php include 'temelbolumler/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>