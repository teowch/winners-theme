const slider = document.getElementById('slider');
const sliderContainer = document.getElementById('slider-container');
const track = document.getElementById('slide-track');
const next = document.getElementById('next');
const prev = document.getElementById('prev');
const slides = document.querySelectorAll('.slide'); // Seleciona todos os slides
const transition = 'transform 0.3s ease';

let currentSlide = 0;
let slideWidth = 300;
let slidesPerView = 1; // Track how many slides are visible
let autoPlayInterval = null;
let isAutoPlaying = true;
const totalSlides = slides.length;
const autoPlayDelay = 4000; // 4 seconds

// Calculate and set slider width based on window size
const calculateSliderWidth = () => {
  const conteudo = document.querySelector('.conteudo');
  let contentWidth = conteudo ? conteudo.offsetWidth : window.innerWidth;
  
  if (conteudo) {
    const style = window.getComputedStyle(conteudo);
    const paddingLeft = parseFloat(style.paddingLeft) || 0;
    const paddingRight = parseFloat(style.paddingRight) || 0;
    contentWidth = conteudo.offsetWidth - paddingLeft - paddingRight;
  }
  
  // Account for slide margins (10px total per slide: 5px + 5px)
  let slideMargins = 10;
  
  // Check if we're on mobile and adjust margins
  if (window.innerWidth <= 600) {
    slideMargins = 6; // 3px + 3px on mobile
  }
  
  const maxSlideWidth = 300; // Maximum slide width
  
  // Calculate how many slides can fit with max width
  slidesPerView = Math.floor(contentWidth / (maxSlideWidth + slideMargins));
  if (slidesPerView < 1) {
    slidesPerView = 1;
  }
  
  // Calculate the total available width for slides (excluding margins between them)
  const totalMarginWidth = (slidesPerView - 1) * slideMargins;
  const availableSlideWidth = contentWidth - totalMarginWidth;
  
  // Use max slide width, but adjust if screen is too small
  slideWidth = Math.min(maxSlideWidth, Math.floor(availableSlideWidth / slidesPerView));
  
  // Apply width to all slides
  slides.forEach(slide => {
    slide.style.minWidth = `${slideWidth}px`;
    slide.style.width = `${slideWidth}px`;
    slide.style.flexShrink = '0';
  });
  
  // Set slider container width to fit exactly the visible slides
  const effectiveSlideWidth = slideWidth + slideMargins;
  const calculatedWidth = (slidesPerView * slideWidth) + ((slidesPerView) * slideMargins);
  sliderContainer.style.width = `${calculatedWidth}px`;
  
  // Also set the slider element width to match
  if (slider) {
    slider.style.width = `${calculatedWidth}px`;
  }
  
  // Debug logging
  console.log('Content width:', contentWidth);
  console.log('Slides per view:', slidesPerView);
  console.log('Slide width:', slideWidth);
  console.log('Slide margins:', slideMargins);
  console.log('Calculated container width:', calculatedWidth);
  
  // Set track width to accommodate all slides with margins
  track.style.width = `${totalSlides * effectiveSlideWidth}px`;
  
  return calculatedWidth;
};

// Update slider position
function updateSlider() {
  // Account for slide margins when calculating position
  let slideMargins = 10;
  
  // Check if we're on mobile and adjust margins
  if (window.innerWidth <= 600) {
    slideMargins = 6; // 3px + 3px on mobile
  }

  prev.style.left = `10px`;
  next.style.right = `${slideMargins + 10}px`;
  
  const effectiveSlideWidth = slideWidth + slideMargins;
  const translateX = -(currentSlide * effectiveSlideWidth);
  
  track.style.transition = 'transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)'; // Smooth easing
  track.style.transform = `translateX(${translateX}px)`;
}

// Auto-play functionality
function startAutoPlay() {
  if (totalSlides <= slidesPerView) return; // Don't auto-play if all slides are visible
  
  autoPlayInterval = setInterval(() => {
    if (isAutoPlaying) {
      nextSlide();
    }
  }, autoPlayDelay);
}

function stopAutoPlay() {
  if (autoPlayInterval) {
    clearInterval(autoPlayInterval);
    autoPlayInterval = null;
  }
}

function pauseAutoPlay() {
  isAutoPlaying = false;
  setTimeout(() => {
    isAutoPlaying = true;
  }, 2000); // Resume after 2 seconds
}

// Initialize slider
function initializeSlider() {
  calculateSliderWidth();
  updateSlider();
  startAutoPlay();
}

// Next slide function
function nextSlide() {
  // Check if the last slide is already visible on screen
  const lastVisibleSlide = currentSlide + slidesPerView - 1;
  
  if (lastVisibleSlide >= totalSlides - 1) {
    // If the last slide is visible, go back to the beginning
    currentSlide = 0;
  } else {
    // Otherwise, move to next slide
    currentSlide++;
  }
  
  updateSlider();
}

// Previous slide function
function prevSlide() {
  if (currentSlide <= 0) {
    // If we're at the beginning, go to position where last slide is visible
    currentSlide = Math.max(0, totalSlides - slidesPerView);
  } else {
    // Otherwise, move to previous slide
    currentSlide--;
  }
  
  updateSlider();
}

// Touch/Swipe support
let startX = 0;
let endX = 0;
let isDragging = false;

function handleTouchStart(e) {
  startX = e.touches ? e.touches[0].clientX : e.clientX;
  isDragging = true;
  pauseAutoPlay();
}

function handleTouchMove(e) {
  if (!isDragging) return;
  e.preventDefault();
}

function handleTouchEnd(e) {
  if (!isDragging) return;
  
  endX = e.changedTouches ? e.changedTouches[0].clientX : e.clientX;
  const difference = startX - endX;
  
  if (Math.abs(difference) > 50) {
    if (difference > 0) {
      nextSlide();
    } else {
      prevSlide();
    }
  }
  
  isDragging = false;
}

// Initialize slider
initializeSlider();

// Recalculate on window resize
window.addEventListener('resize', () => {
  calculateSliderWidth();
  updateSlider();
  stopAutoPlay();
  startAutoPlay();
});

// Event listeners for navigation buttons
next.addEventListener('click', () => {
  nextSlide();
  pauseAutoPlay();
});

prev.addEventListener('click', () => {
  prevSlide();
  pauseAutoPlay();
});

// Touch/Swipe event listeners
track.addEventListener('touchstart', handleTouchStart, { passive: false });
track.addEventListener('touchmove', handleTouchMove, { passive: false });
track.addEventListener('touchend', handleTouchEnd, { passive: false });

// Mouse drag support for desktop
track.addEventListener('mousedown', handleTouchStart);
track.addEventListener('mousemove', handleTouchMove);
track.addEventListener('mouseup', handleTouchEnd);
track.addEventListener('mouseleave', handleTouchEnd);

// Pause auto-play on hover
sliderContainer.addEventListener('mouseenter', () => {
  isAutoPlaying = false;
});

sliderContainer.addEventListener('mouseleave', () => {
  isAutoPlaying = true;
});

