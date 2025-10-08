// Remove all empty <p> elements from the DOM
document.querySelectorAll('p').forEach(function(p) {
    if (!p.textContent.trim()) {
        p.parentNode.removeChild(p);
    }
});