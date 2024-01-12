const bottoneTop = document.querySelector('.bottonetop');

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' }); // Smooth scrolling to top
}

bottoneTop.addEventListener('click', scrollToTop);
