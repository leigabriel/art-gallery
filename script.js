// script.js

document.addEventListener('DOMContentLoaded', () => {
  // Initialize AOS (Animate On Scroll) library
  AOS.init({
    duration: 800, // slower animations
    easing: 'ease-in-out', // smoother effect
    once: false, // only animate once when scrolling down
  });

  // --- Mobile Menu Functionality ---
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const closeMenu = document.getElementById('close-menu');

  if (menuToggle && mobileMenu && closeMenu) {
    menuToggle.addEventListener('click', () => {
      // Remove 'translate-x-full' to slide the menu in
      mobileMenu.classList.remove('translate-x-full');
      // Add 'overflow-hidden' to body to prevent scrolling when menu is open (optional but good UX)
      document.body.classList.add('overflow-hidden');
    });

    closeMenu.addEventListener('click', () => {
      // Add 'translate-x-full' to slide the menu out
      mobileMenu.classList.add('translate-x-full');
      // Remove 'overflow-hidden' from body
      document.body.classList.remove('overflow-hidden');
    });

    // Close menu when a navigation link is clicked (smoother UX)
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('translate-x-full');
        document.body.classList.remove('overflow-hidden');
      });
    });
  }

  // --- Gallery Horizontal Scroll Functionality ---
  // This function is called by the onClick attributes on your gallery buttons
  window.scrollGallery = function (direction) {
    const gallery = document.querySelector('.gallery');
    if (!gallery) return; // Exit if gallery element is not found

    // Calculate scroll amount based on the width of a single card plus its gap
    // Tailwind's gap-6 translates to 24px
    const firstCard = gallery.querySelector('div.flex-none.w-64');
    const cardWidth = firstCard ? firstCard.offsetWidth + 24 : 300; // Fallback to 300px if card not found

    gallery.scrollBy({
      left: direction * cardWidth,
      behavior: 'smooth'
    });
  };


  // --- Lightbox Functionality ---
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  // Select all images within the '.gallery' section that should open in the lightbox
  const galleryImages = document.querySelectorAll('#collection .gallery img');

  if (lightbox && lightboxImg && galleryImages.length > 0) {
    galleryImages.forEach(img => {
      img.addEventListener('click', () => {
        lightboxImg.src = img.src; // Set the source of the lightbox image
        lightbox.classList.remove('hidden'); // Show the lightbox
        lightbox.classList.add('flex'); // Ensure it uses flexbox for centering
        document.body.classList.add('overflow-hidden'); // Prevent body scroll
      });
    });

    // Close lightbox when clicking anywhere on the lightbox overlay
    lightbox.addEventListener('click', (event) => {
      // Only close if clicking on the lightbox background, not the image itself
      if (event.target === lightbox || event.target === lightboxImg) {
        lightbox.classList.add('hidden'); // Hide the lightbox
        lightbox.classList.remove('flex');
        document.body.classList.remove('overflow-hidden'); // Re-enable body scroll
      }
    });
  }
});

AOS.init();

// Mobile Menu Toggle
const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const closeMenu = document.getElementById('close-menu');

menuToggle.addEventListener('click', () => {
  mobileMenu.classList.toggle('translate-x-full');
});

closeMenu.addEventListener('click', () => {
  mobileMenu.classList.add('translate-x-full');
});

// Close mobile menu when a link is clicked
mobileMenu.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    mobileMenu.classList.add('translate-x-full');
  });
});

// Gallery Scroll Buttons
function scrollGallery(direction) {
  const gallery = document.querySelector('.gallery');
  const scrollAmount = 300; // Adjust based on card width + gap
  gallery.scrollBy({
    left: direction * scrollAmount,
    behavior: 'smooth'
  });
}

// Lightbox Functionality (assuming images will be clickable)
const galleryImages = document.querySelectorAll('.gallery img');
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');

galleryImages.forEach(img => {
  img.addEventListener('click', () => {
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    lightboxImg.src = img.src;
  });
});

lightbox.addEventListener('click', () => {
  lightbox.classList.add('hidden');
  lightbox.classList.remove('flex');
});

