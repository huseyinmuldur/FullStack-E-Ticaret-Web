<?php

include 'temelbolumler/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $isim = $_POST['isim'];
   $isim = filter_var($isim, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $numara = $_POST['numara'];
   $numara = filter_var($numara, FILTER_SANITIZE_STRING);
   $mesaj = $_POST['mesaj'];
   $mesaj = filter_var($mesaj, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `mesajlar` WHERE isim = ? AND email = ? AND numara = ? AND message = ?");
   $select_message->execute([$isim, $email, $numara, $mesaj]);

   if($select_message->rowCount() > 0){

   }else{

      $insert_message = $conn->prepare("INSERT INTO `mesajlar`(user_id, isim, email, numara, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $isim, $email, $numara, $mesaj]);

      $message[] = 'Mesajınız başarıyla gönderilmiştir!';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>İletişim</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'temelbolumler/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>İletişime Geç</h3>
      <input type="text" name="name" placeholder="Adınızı girin" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Emailinizi girin" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="Telefon numaranızı girin" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Mesajınızı girin" cols="30" rows="10"></textarea>
      <input type="submit" value="Mesajı Gönder" name="send" class="btn">
   </form>

</section>

<?php include 'temelbolumler/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>