const slider = document.getElementById('slider');
const sliderContainer = document.getElementById('slider-container');
const track = document.getElementById('slide-track');
const next = document.getElementById('next');
const prev = document.getElementById('prev');
const slides = document.querySelectorAll('.slide'); // Seleciona todos os slides
const transition = 'transform 0.3s ease';

let position = 0;
let slideWidth = 300;

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
  console.log('Content width:', contentWidth);
  
  if (contentWidth < slideWidth) {
    slideWidth = contentWidth; // Ajusta a largura do slide se a largura principal for menor que a largura do slide
    console.log('Adjusted slideWidth:', slideWidth);
  }
  
  // Aplica a largura para todos os slides
  slides.forEach(slide => {
    slide.style.minWidth = `${slideWidth}px`;
    slide.style.width = `${slideWidth}px`;
    slide.style.flexShrink = '0'; // Impede que os slides encolham
  });
  
  let slidesPerView = Math.floor(contentWidth / slideWidth);
  if (slidesPerView < 1) {
    slidesPerView = 1; // Ensure at least one slide is visible
  }
  const calculatedWidth = slidesPerView * slideWidth;
  sliderContainer.style.width = `${calculatedWidth}px`;
  return calculatedWidth;
};

// Clona as imagens para criar efeito de looping
function cloneSlides() {
  const originalSlides = Array.from(track.children);
  const total = originalSlides.length;
  
  // Clone all slides to the end
  for (let i = 0; i < total; i++) {
    const clone = originalSlides[i].cloneNode(true);
    // Aplica os estilos de largura aos slides clonados
    clone.style.minWidth = `${slideWidth}px`;
    clone.style.width = `${slideWidth}px`;
    clone.style.flexShrink = '0';
    track.appendChild(clone);
  }
  
  // Clone last slide before the first
  if (total > 0) {
    const lastClone = originalSlides[total - 1].cloneNode(true);
    // Aplica os estilos de largura ao último slide clonado
    lastClone.style.minWidth = `${slideWidth}px`;
    lastClone.style.width = `${slideWidth}px`;
    lastClone.style.flexShrink = '0';
    track.insertBefore(lastClone, originalSlides[0]);
  }
  
  track.style.transition = 'none';
  track.style.transform = `translateX(${ -position }px)`;
  track.style.transition = transition;
}

// Set initial slider width
calculateSliderWidth();

// Clone slides after calculating width
cloneSlides();

// Recalculate on window resize
window.addEventListener('resize', () => {
  calculateSliderWidth();
  // Recria os slides clonados com as novas dimensões
  const allSlides = track.querySelectorAll('.slide');
  const originalCount = Math.floor(allSlides.length / 2);
  
  // Remove slides clonados
  for (let i = allSlides.length - 1; i >= originalCount; i--) {
    allSlides[i].remove();
  }
  if (allSlides.length > originalCount) {
    allSlides[0].remove(); // Remove o primeiro clone
  }
  
  // Recria os clones com as novas dimensões
  cloneSlides();
});

track.style.transform = `translateX(${ -position }px)`;

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

