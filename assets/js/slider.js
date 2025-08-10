const slider = document.getElementById('slider');
const sliderContainer = document.getElementById('slider-container');
const track = document.getElementById('slide-track');
const next = document.getElementById('next');
const prev = document.getElementById('prev');
const transition = 'transform 0.3s ease';

let position = 300;
const slideWidth = 300;

// Calculate and set slider width based on window size
const calculateSliderWidth = () => {
  const windowWidth = window.innerWidth;
  const slidesPerView = Math.floor(windowWidth / slideWidth);
  const calculatedWidth = slidesPerView * slideWidth;
  sliderContainer.style.width = `${calculatedWidth}px`;
  return calculatedWidth;
};

// Set initial slider width
calculateSliderWidth();

// Recalculate on window resize
window.addEventListener('resize', calculateSliderWidth);

track.style.transform = `translateX(${ -slideWidth }px)`;




// Clona as imagens para criar efeito de looping
function cloneSlides() {
  const slides = Array.from(track.children);
  const total = slides.length;
  // Clone all slides to the end
  for (let i = 0; i < total; i++) {
    const clone = slides[i].cloneNode(true);
    track.appendChild(clone);
  }
  // Clone last slide before the first
  if (total > 0) {
    const lastClone = slides[total - 1].cloneNode(true);
    track.insertBefore(lastClone, slides[0]);
  }
  track.style.transition = 'none';
  track.style.transform = `translateX(${ -slideWidth }px)`;
  track.style.transition = transition;
}
cloneSlides();

// Botão "Próximo"
next.addEventListener('click', () => {
  position += slideWidth;
  if (position >= track.scrollWidth / 2) {
    position = 0; // volta ao início
    track.style.transition = 'none';
    track.style.transform = `translateX(${ -position }px)`;
    // força reflow
    void track.offsetWidth;
    track.style.transition = transition;
    position += slideWidth;
  }
  track.style.transform = `translateX(${ -position }px)`;
});

// Botão "Anterior"
prev.addEventListener('click', () => {
  position -= slideWidth;
  if (position < 0) {
    position = track.scrollWidth / 2 - slideWidth / 2;
    track.style.transition = 'none';
    track.style.transform = `translateX(${-position}px)`;
    void track.offsetWidth;
    track.style.transition = transition;
    position -= slideWidth;
  }
  track.style.transform = `translateX(${-position}px)`;
});

