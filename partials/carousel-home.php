<div class="carousel-container">
    <div class="carousel-wrapper">
        <div class="carousel-track" id="carouselTrack">
            <div class="carousel-slide active">
                <img src="https://placehold.co/600x400?text=Hello\nWorld" alt="Slide 1" class="carousel-image">
            </div>
            <div class="carousel-slide">
                <img src="https://placehold.co/600x400?text=Hello\nWorld" alt="Slide 2" class="carousel-image">
            </div>
            <div class="carousel-slide">
                <img src="https://placehold.co/600x400?text=Hello\nWorld" alt="Slide 3" class="carousel-image">
            </div>
        </div>
        
        <!-- Navigation buttons -->
        <button class="carousel-btn carousel-btn--prev" id="prevBtn" aria-label="Previous slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
            </svg>
        </button>
        <button class="carousel-btn carousel-btn--next" id="nextBtn" aria-label="Next slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>
        </button>
        
        <!-- Dots indicator -->
        <div class="carousel-dots">
            <button class="carousel-dot active" data-slide="0" aria-label="Go to slide 1"></button>
            <button class="carousel-dot" data-slide="1" aria-label="Go to slide 2"></button>
            <button class="carousel-dot" data-slide="2" aria-label="Go to slide 3"></button>
        </div>
    </div>
</div>