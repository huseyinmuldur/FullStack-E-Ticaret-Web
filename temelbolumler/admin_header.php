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

      <a href="../admin/gosterge_paneli.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="../admin/gosterge_paneli.php">Anasayfa</a>
         <a href="../admin/urunler.php">Ürünler</a>
         <a href="../admin/siparisler.php">Siparişler</a>
         <a href="../admin/admin_hesabi.php">Adminler</a>
         <a href="../admin/kullanicilar.php">Kullanıcılar</a>
         <a href="../admin/mesajlar.php">Mesajlar</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `adminler` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['isim']; ?></p>
         <a href="../admin/profil_guncelleme.php" class="btn">Profili Güncelle</a>
         <div class="flex-btn">
            <a href="../admin/admin_kayit.php" class="option-btn">Kayıt Ol</a>
            <a href="../admin/admin_girisi.php" class="option-btn">Giriş Yap</a>
         </div>
         <a href="../temelbolumler/admin_cikis.php" class="delete-btn" onclick="return confirm('Çıkış yapılsın mı?');">Çıkış Yap</a> 
      </div>

   </section>

</header>