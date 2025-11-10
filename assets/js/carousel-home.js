document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.querySelectorAll('.carousel-dot');
    const slides = document.querySelectorAll('.carousel-slide');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    // Initialize carousel dimensions dynamically
    function initializeCarousel() {
        // Set track width based on number of slides
        track.style.width = `${totalSlides * 100}%`;
        
        // Set each slide width as percentage of track
        const slideWidth = 100 / totalSlides;
        slides.forEach(slide => {
            slide.style.width = `${slideWidth}%`;
        });
    }
    
    function updateCarousel() {
        // Move track - dynamic calculation based on slide width
        const slideWidth = 100 / totalSlides; // Each slide is this % of track width
        track.style.transform = `translateX(-${currentSlide * slideWidth}%)`;
        
        // Update active slide
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === currentSlide);
        });
        
        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }
    
    // Initialize the carousel
    initializeCarousel();
    
    // Slide click handlers for navigation
    slides.forEach((slide, index) => {
        slide.addEventListener('click', function(e) {
            // Only navigate if not currently animating and slide is active
            if (slide.classList.contains('active') && 
                !slide.classList.contains('slide-in-right') && 
                !slide.classList.contains('slide-in-left') && 
                !slide.classList.contains('slide-out-left') && 
                !slide.classList.contains('slide-out-right')) {
                
                const link = slide.dataset.link;
                if (link) {
                    if (link.includes('youtube.com')) {
                        window.open(link, '_blank');
                    } else {
                        window.location.href = link;
                    }
                }
            }
        });
        
        // Add cursor pointer to indicate clickable
        slide.style.cursor = 'pointer';
    });
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }
    
    function goToSlide(slideIndex) {
        currentSlide = slideIndex;
        updateCarousel();
    }
    
    // Event listeners
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });
    
    // Auto-play (optional - uncomment if desired)
    // setInterval(nextSlide, 5000);
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'ArrowRight') nextSlide();
    });
    
    // Touch/swipe support
    let startX = 0;
    let endX = 0;
    
    track.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    });
    
    track.addEventListener('touchend', function(e) {
        endX = e.changedTouches[0].clientX;
        const difference = startX - endX;
        
        if (Math.abs(difference) > 50) {
            if (difference > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    });
});