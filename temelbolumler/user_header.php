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
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i></a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="sepetim.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["name"]; ?></p>
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