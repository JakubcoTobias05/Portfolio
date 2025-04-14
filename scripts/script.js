document.addEventListener("DOMContentLoaded", function() {
    const header = document.querySelector("header");

    window.addEventListener("scroll", function() {
        header.classList.toggle("sticky", window.scrollY > 0);
    });

    let menu = document.querySelector('#menu-icon');
    let navbar = document.querySelector('.navbar');

    if (menu) {
        menu.onclick = () => {
            menu.classList.toggle('bx-x');
            navbar.classList.toggle('active');
        };
    }

    window.onscroll = () => {
        if (menu) {
            menu.classList.remove('bx-x');
            navbar.classList.remove('active');
        }
    };

    const sr = ScrollReveal({
        distance: '25px',
        duration: 250,
        reset: true
    });

    sr.reveal('.home-text', { delay: 190, origin: 'bottom' });
    sr.reveal('.about, .services, .portfolio, .contact', { delay: 200, origin: 'bottom' });
});