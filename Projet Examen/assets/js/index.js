// No scrolling during loading page animation
document.body.classList.add('no-scroll');
// Hide section during loading page animation
document.querySelector('#section').classList.add('hidden');

// Loading page
if (!sessionStorage.getItem('loadingPlayed')) {
    gsap.fromTo(
        ".loading-page",
        { opacity: 1 },
        {
            opacity: 0,
            display: "none",
            duration: 1.5,
            delay: 3.5,
            onComplete: () => {
                document.body.classList.remove('no-scroll');
                document.querySelector('#section').classList.remove('hidden');
                sessionStorage.setItem('loadingPlayed', true);
            }
        }
    );
} else {
    document.querySelector('.loading-page').style.display = 'none';
    document.body.classList.remove('no-scroll');
    document.querySelector('#section').classList.remove('hidden');
}

gsap.fromTo(
    ".logo-name",
    {
        y: 50,
        opacity: 0,
    },
    {
        y: 0,
        opacity: 1,
        duration: 2,
        delay: 0.5,
    }
);

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

// Slider Section

const swiper = new Swiper('.swiper-container', {
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    slidesPerView: 1, 
    spaceBetween: 10, 
    breakpoints: {
        768: {
            slidesPerView: 2, 
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3, 
            spaceBetween: 30,
        },
    },
    autoplay: {
        delay: 3000, 
        disableOnInteraction: false, 
    },
});

const slides = document.querySelectorAll('.swiper-slide');

slides.forEach((slide) => {
    slide.addEventListener('mouseenter', () => {
        swiper.autoplay.stop(); 
    });

    slide.addEventListener('mouseleave', () => {
        swiper.autoplay.start(); 
    });
});

