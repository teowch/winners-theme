document.getElementById('menu-icon').addEventListener('click', function() {
    document.getElementById('menu').classList.toggle('active');
    this.classList.toggle('active');
    document.getElementById('submenu').classList.remove('active');
});

// Mobile submenu functionality
document.addEventListener('DOMContentLoaded', function() {
    const submenuToggle = document.querySelector('.has-submenu .option');
    const submenu = document.querySelector('.submenu');
    
    if (submenuToggle && submenu) {
        submenuToggle.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                submenu.classList.toggle('active');
            }
        });
    }
});

// Ensure banner is above navbar and not hidden
const header = document.querySelector('.site-header'); // Adjust selector as needed
const main = document.querySelector('main');
const tribeEvents = document.querySelector('.tribe-common');
if (header) {
    const headerHeight = header.offsetHeight;
    if (main) {
        main.style.marginTop = `${headerHeight}px`;
    }
    if (tribeEvents) {
        tribeEvents.style.marginTop = `${headerHeight}px`;
    }
}