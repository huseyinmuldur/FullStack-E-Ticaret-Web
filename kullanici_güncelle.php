<?php

include 'temelbolumler/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $isim = $_POST['isim'];
   $isim = filter_var($isim, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `kullanicilar` SET isim = ?, email = ? WHERE id = ?");
   $update_profile->execute([$isim, $email, $user_id]);

   $empty_pass = '123456789';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = 'Lütfen eski şifrenizi giriniz!';
   }elseif($old_pass != $prev_pass){
      $message[] = 'Eski şifre eşleşmiyor!';
   }elseif($new_pass != $cpass){
      $message[] = 'Yeni şifreler eşleşmiyor!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `kullanicilar` SET sifre = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $message[] = 'Şifreniz başarıyla güncellendi!';
      }else{
         $message[] = 'Lütfen yeni şifrenizi girin!';
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
   <title>Profili Güncelle</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'temelbolumler/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>PROFİLİ GÜNCELLE</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["sifre"]; ?>">
      <input type="text" name="isim" required placeholder="Kullanıcı adınızı girin" maxlength="20"  class="box" value="<?= $fetch_profile["isim"]; ?>">
      <input type="email" name="email" required placeholder="Email adresinizi girin" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
      <input type="password" name="old_pass" placeholder="Eski şifreniz girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Yeni şifrenizi girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="Yeni şifrenizi tekrar girin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Güncelle" class="btn" name="submit">
   </form>

</section>



<?php include 'temelbolumler/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>