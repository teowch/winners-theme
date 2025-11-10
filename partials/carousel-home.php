<div class="carousel-container">
    <div class="carousel-wrapper">
        <div class="carousel-track" id="carouselTrack">
            <div class="carousel-slide active" data-link="<?php echo home_url();?>">
                <div class="carousel-image carousel-image--slide-1" aria-label="Slide 1"></div>
            </div>
            <div class="carousel-slide" data-link="<?php echo home_url('/quem-somos');?>">
                <div class="carousel-image carousel-image--slide-2" aria-label="Slide 2"></div>
            </div>
            <div class="carousel-slide" data-link="https://www.youtube.com/@winnerstvbr">
                <div class="carousel-image carousel-image--slide-3" aria-label="Slide 3"></div>
            </div>
        </div>
        
        <!-- Navigation buttons -->
        <button class="carousel-btn carousel-btn--prev" id="prevBtn" aria-label="Previous slide">&#10094;</button>
        <button class="carousel-btn carousel-btn--next" id="nextBtn" aria-label="Next slide">&#10095;</button>
        
        <!-- Dots indicator -->
        <div class="carousel-dots">
            <button class="carousel-dot active" data-slide="0" aria-label="Go to slide 1"></button>
            <button class="carousel-dot" data-slide="1" aria-label="Go to slide 2"></button>
            <button class="carousel-dot" data-slide="2" aria-label="Go to slide 3"></button>
        </div>
    </div>
</div>