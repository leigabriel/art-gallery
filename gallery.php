<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Art Gallery - Collection</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../src/output.css">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body class="bg-white text-gray-900">

  <header class="fixed top-4 left-4 z-50">
    <div class="bg-gray-800/90 backdrop-blur-md border border-white/40 shadow-lg rounded-full px-4 py-2">
      <a href="index.html#collection"
        class="text-sm relative px-3 py-1 text-white transition duration-300 hover:text-yellow-300 hover:scale-105 group flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
          stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back
      </a>
    </div>
  </header>

  <section id="collection" class="pt-28 pb-16 px-4 sm:px-6 text-center">
    <h2 class="text-3xl sm:text-4xl font-bold mb-10" data-aos="fade-down">Lei's Gallery</h2>
    <p class="text-lg text-gray-700 mb-12 italic" data-aos="fade-up" data-aos-delay="100">Explore the full collection of
      masterpieces.</p>

    <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-6 space-y-6 max-w-7xl mx-auto">

      <?php
      $artworksFile = 'data/artworks.json';
      if (file_exists($artworksFile)) {
        $artworks = json_decode(file_get_contents($artworksFile), true);
        // Ensure artworks are valid before displaying
        if (!empty($artworks) && is_array($artworks)) {
          foreach (array_reverse($artworks) as $art) {
            // Basic validation for array keys and non-empty values
            $file = isset($art['file']) ? htmlspecialchars($art['file']) : 'placeholder.jpg';
            $title = isset($art['title']) ? htmlspecialchars($art['title']) : 'Untitled Artwork';
            $date = isset($art['date']) ? htmlspecialchars($art['date']) : 'Unknown Date';

            echo '
            <div class="artwork-card break-inside-avoid shadow-md bg-white/80 backdrop-blur-md rounded-lg overflow-hidden group transition-transform duration-300 hover:scale-[1.02] hover:shadow-xl" data-aos="zoom-in" data-aos-delay="100">
              <img src="' . $file . '" alt="' . $title . '" loading="lazy" class="w-full h-auto object-cover rounded-t cursor-pointer transition-transform group-hover:scale-105 duration-300" />
              <div class="p-4 text-left">
                <h3 class="text-lg font-semibold">' . $title . '</h3>
                <p class="text-sm text-gray-600">' . $date . '</p>
              </div>
            </div>';
          }
        } else {
          echo '<p class="text-gray-500">No artworks found in the JSON file or file is empty.</p>';
        }
      } else {
        echo '<p class="text-gray-500">No artworks data file found. Please check ' . $artworksFile . '</p>';
      }
      ?>
    </div>
  </section>

  <div id="lightbox" class="hidden fixed inset-0 bg-black bg-opacity-90 items-center justify-center z-50 p-4">
    <button id="lightbox-close"
      class="absolute top-4 right-4 text-white text-4xl font-light hover:text-red-400 transition">&times;</button>
    <img id="lightbox-img" src="" alt="Full View of Artwork"
      class="max-w-[95%] max-h-[95%] rounded-xl border-4 border-white cursor-zoom-out" />
  </div>

  <script src="script.js"></script>
  <script>
    // script.js
    document.addEventListener('DOMContentLoaded', () => {

      // --- Lightbox Functionality for Gallery Images ---
      const lightbox = document.getElementById('lightbox');
      const lightboxImg = document.getElementById('lightbox-img');
      const lightboxCloseBtn = document.getElementById('lightbox-close');

      // Select all images within the '.artwork-card' class in the '#collection' section
      const galleryImages = document.querySelectorAll('#collection .artwork-card img');

      if (lightbox && lightboxImg && lightboxCloseBtn && galleryImages.length > 0) {
        galleryImages.forEach(img => {
          img.addEventListener('click', () => {
            lightboxImg.src = img.src; // Set the source of the lightbox image
            lightbox.classList.remove('hidden'); // Show the lightbox
            lightbox.classList.add('flex'); // Ensure it uses flexbox for centering
            document.body.classList.add('overflow-hidden'); // Prevent body scroll when lightbox is open
          });
        });

        // Close lightbox when clicking the close button
        lightboxCloseBtn.addEventListener('click', () => {
          lightbox.classList.add('hidden'); // Hide the lightbox
          lightbox.classList.remove('flex');
          document.body.classList.remove('overflow-hidden'); // Re-enable body scroll
        });

        // Close lightbox when clicking on the overlay (but not on the image itself)
        lightbox.addEventListener('click', (event) => {
          if (event.target === lightbox) { // Only close if the direct target of the click is the lightbox background
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
          }
        });

        // Close lightbox with ESC key
        document.addEventListener('keydown', (event) => {
          if (event.key === 'Escape' && !lightbox.classList.contains('hidden')) {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
          }
        });
      }

    });
  </script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    // This inline script is fine for AOS initialization
    AOS.init({
      duration: 800, // Adjust duration as needed
      once: true, // Only animate once as user scrolls down
      mirror: false, // Don't animate when scrolling up
    });
  </script>
</body>
</html>