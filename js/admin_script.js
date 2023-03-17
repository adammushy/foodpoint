// The first part of the code sets up event listeners for two buttons, 
// #user-btn and #menu-btn, which toggle the active class on the .profile and .navbar elements, respectively.

// The second part of the code sets up an event listener for when the window is scrolled, 
// which removes the active class from both .profile and .navbar elements.

// The third part of the code selects some images and sets up an event listener for when one of them is clicked.
//  When a sub-image is clicked, the src attribute of the main image is changed to the src attribute of the clicked sub-image.



let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active')
   navbar.classList.remove('active');
}

let navbar = document.querySelector('.header .flex .navbar');

const menu_btn = document.getElementById('menuBtn');
const sideMenu = document.querySelector('.side-menu');

menu_btn.addEventListener('click', () => {
  sideMenu.classList.toggle('hide');
});


document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
   navbar.classList.remove('active');
}

subImages = document.querySelectorAll('.update-product .image-container .sub-images img');
mainImage = document.querySelector('.update-product .image-container .main-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      let src = images.getAttribute('src');
      mainImage.src = src;
   }
});