<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="anasayfa.php" class="logo">BytePazarı</a>

      <nav class="navbar">
         <a href="anasayfa.php">Anasayfa</a>
         <a href="hakkimizda.php">Hakkımızda</a>
         <a href="verilen_siparisler.php">Siparişler</a>
         <a href="magaza.php">Mağaza</a>
         <a href="iletisim.php">İletişim</a>
      </nav>

      <div class="icons">

         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="#"><i class="fas fa-search"></i></a>
         <a href="#"><i class="fas fa-heart"></i></a>
         <a href="sepetim.php"><i class="fas fa-shopping-cart"></i></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `kullanicilar` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["isim"]; ?></p>
         <a href="kullanici_güncelle.php" class="btn">Profili Güncelle</a>
         <div class="flex-btn">
            <a href="kullanici_kayit.php" class="option-btn">Kayıt Ol</a>
            <a href="kullanici_giris.php" class="option-btn">Giriş Yap</a>
         </div>
         <a href="temelbolumler/user_logout.php" class="delete-btn" onclick="return confirm('Siteden çıkış yapılıyor?');">Çıkış Yap</a> 
         <?php
            }else{
         ?>
         <p>Lütfen önce giriş yapın veya kayıt olun!</p>
         <div class="flex-btn">
            <a href="kullanici_kayit.php" class="option-btn">Kayıt Ol</a>
            <a href="kullanici_giris.php" class="option-btn">Giriş Yap</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>