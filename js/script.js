// It selects the navbar element and assigns it to the variable "navbar".
// It assigns a function to be executed when the "menu-btn" is clicked, which toggles the "active" class on the navbar and removes the "active" class from the profile element.
// It selects the profile element and assigns it to the variable "profile".
// It assigns a function to be executed when the "user-btn" is clicked, which toggles the "active" class on the profile and removes the "active" class from the navbar element.
// It assigns a function to be executed when the window is scrolled, which removes the "active" class from the navbar and profile elements.
// It defines two functions: "loader" and "fadeOut" which work together to create an image loader effect.
// It selects all input elements with type="number" and assigns a function to be executed when the input value changes. This function checks the length of the input value and ensures it does not exceed the maximum length.
// It defines a function "rate" which takes a number argument and changes the CSS class of rating stars accordingly.




navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    profile.classList.remove('active');
}

profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}

window.onscroll = () => {
        navbar.classList.remove('active');
        profile.classList.remove('active');
    }
    // the image loader effect
function loader() {
    document.querySelector('.loader').style.display = 'none';
}

function fadeOut() {
    setInterval(loader, 100);
}

window.onload = fadeOut;

document.querySelectorAll('input[type="number"]').forEach(numberInput => {
    numberInput.oninput = () => {
        if (numberInput.value.length > numberInput.maxLength) numberInput.value = numberInput.value.slice(0, numberInput.maxLength);
    };
});

function rate(num) {
    for (let i = 1; i <= 5; i++) {
        const star = document.querySelector(`#rating i:nth-child(${i})`);
        if (i <= num) {
            star.classList.add("rated");
        } else {
            star.classList.remove("rated");
        }
    }
}




// login form
let form = document.querySelecter('form');

form.addEventListener('submit', (e) => {
  e.preventDefault();
  return false;
});