// Navbar ve profil elementlerini seç
let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

// Menü butonuna tıklandığında
document.querySelector('#menu-btn').onclick = () =>{
   // Navbar'ın görünürlük durumunu tersine çevir (aktifse kapat, kapalıysa aç)
   navbar.classList.toggle('active');
   // Profil menüsünü kapat
   profile.classList.remove('active');
}

// Kullanıcı butonuna tıklandığında
document.querySelector('#user-btn').onclick = () =>{
   // Profil menüsünün görünürlük durumunu tersine çevir (aktifse kapat, kapalıysa aç)
   profile.classList.toggle('active');
   // Navbar'ı kapat
   navbar.classList.remove('active');
}

// Sayfa scroll edildiğinde
window.onscroll = () =>{
   // Navbar ve profil menülerini kapat
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

// Ürün güncelleme sayfasındaki ana ve alt görüntüler arasında geçiş yapma
let mainImage = document.querySelector('.update-product .image-container .main-image img');
let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');

// Her bir alt görüntüye tıklandığında
subImages.forEach(images =>{
   images.onclick = () =>{
      // Tıklanan alt görüntünün kaynak (src) değerini al
      src = images.getAttribute('src');
      // Ana görüntünün kaynak değerini tıklanan alt görüntünün kaynak değeri ile değiştir
      mainImage.src = src;
   }
});
