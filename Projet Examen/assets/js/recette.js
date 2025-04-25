// Navbar
const bars = document.querySelector('.bars');
const menu = document.querySelector('.nav-items');

bars.addEventListener('click', () => {
    menu.classList.toggle('show-menu');
});

document.addEventListener('mouseup', (e) => {
    if (!menu.contains(e.target) && !bars.contains(e.target)) {
        menu.classList.remove('show-menu');
    }
});

// Main Section
document.addEventListener("DOMContentLoaded", function () {
    const backButton = document.querySelector('.recipe-details button a');
    if (backButton) {
        backButton.addEventListener('click', function(event) {
            event.preventDefault(); 
            window.location.href = this.href; 
        });
    }
});

