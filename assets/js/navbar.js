document.getElementById('menu-icon').addEventListener('click', function() {
    document.getElementById('menu').classList.toggle('active');
    this.classList.toggle('active');
});

// Ensure banner is above navbar and not hidden
const header = document.querySelector('.header'); // Adjust selector as needed
const main = document.querySelector('main');
if (header) {
    const headerHeight = header.offsetHeight;
    main.style.marginTop = `${headerHeight}px`;
}