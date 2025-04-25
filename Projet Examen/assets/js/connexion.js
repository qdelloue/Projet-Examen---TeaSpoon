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

// Form
const connexion = document.getElementById('connexion');
const signin = document.getElementById('signin');
const login = document.getElementById('login');
const signinBtn = document.getElementById('signin-button');
const loginBtn = document.getElementById('login-button');
const signinLink = signin.querySelector('a');
const loginLink = login.querySelector('a');

function showForm(formType) {
    connexion.style.display = "none";
    signin.style.display = "none";
    login.style.display = "none";

    switch(formType) {
        case 'register':
            signin.style.display = "flex";
            break;
        case 'login':
            login.style.display = "flex";
            break;
        default:
            connexion.style.display = "block";
    }
}

showForm(formToShow);

signinBtn.addEventListener('click', () => showForm('register'));
loginBtn.addEventListener('click', () => showForm('login'));
signinLink.addEventListener('click', (e) => {
    e.preventDefault();
    showForm('login');
});
loginLink.addEventListener('click', (e) => {
    e.preventDefault();
    showForm('register');
});
