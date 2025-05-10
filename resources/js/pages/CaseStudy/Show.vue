<template>
  <PublicLayout>
    <div class="case-study-page">
      <!-- Loading Overlay -->
      <div
        v-if="isLoading"
        class="fixed inset-0 bg-background/80 backdrop-blur-sm z-50 flex items-center justify-center"
      >
        <div class="text-center">
          <div class="relative w-20 h-20 mx-auto mb-4">
            <div class="absolute inset-0 rounded-full border-4 border-primary/20"></div>
            <div
              class="absolute inset-0 rounded-full border-4 border-primary border-t-transparent animate-spin"
            ></div>
          </div>
          <p class="text-muted-foreground">Loading case study...</p>
        </div>
      </div>

      <!-- Hero Section -->
      <section class="relative bg-gradient-to-b from-primary/5 to-background pt-16 pb-12 overflow-hidden">
        <div class="container mx-auto px-4">
          <!-- Back Button -->
          <div class="mb-8">
            <Link
              href="/"
              class="inline-flex items-center text-muted-foreground hover:text-primary transition-colors group"
            >
              <ArrowLeftIcon class="w-4 h-4 mr-2 transition-transform duration-300 group-hover:-translate-x-1" />
              <span>Back to Projects</span>
            </Link>
          </div>

          <div class="max-w-5xl mx-auto">
            <!-- Category Badge -->
            <div class="mb-4">
              <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-sm font-medium rounded-full">
                {{ formatCategory(caseStudy.project_type) }}
              </span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-5xl font-bold mb-6 leading-tight">
              {{ caseStudy.title }}
            </h1>

            <!-- Client & Date -->
            <div class="flex flex-wrap items-center text-muted-foreground text-sm mb-8">
              <div class="flex items-center mr-6">
                <BuildingIcon class="h-4 w-4 mr-2 text-primary" />
                <span>{{ caseStudy.client_name }}</span>
              </div>
              <div class="flex items-center">
                <CalendarIcon class="h-4 w-4 mr-2 text-primary" />
                <span>{{ caseStudy.formatted_date || caseStudy.project_date }}</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Main Content -->
      <section class="py-12">
        <div class="container mx-auto px-4">
          <div class="max-w-5xl mx-auto">
            <!-- Featured Image -->
            <div class="mb-12 rounded-xl overflow-hidden shadow-lg">
              <img
                :src="caseStudy.image_url || caseStudy.image"
                :alt="caseStudy.title"
                class="w-full object-cover h-[300px] md:h-[500px]"
              />
            </div>

            <!-- Key Metrics -->
            <div v-if="hasKeyMetrics" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
              <div
                v-for="(metric, index) in caseStudy.key_metrics || caseStudy.highlights"
                :key="index"
                class="bg-card border border-border rounded-lg p-6 text-center"
              >
                <div class="text-2xl md:text-3xl font-bold text-primary mb-2">{{ metric.value }}</div>
                <div class="text-sm text-muted-foreground">{{ metric.label }}</div>
              </div>
            </div>

            <!-- Project Description -->
            <div class="mb-12">
              <h2 class="text-2xl font-bold mb-6">Project Overview</h2>
              <div class="prose prose-lg dark:prose-invert max-w-none">
                <p>{{ caseStudy.description }}</p>
              </div>
            </div>

            <!-- Gallery Carousel -->
            <div v-if="hasGallery" class="mb-12">
              <h2 class="text-2xl font-bold mb-6">Project Gallery</h2>
              <div class="relative">
                <!-- Main Carousel Image Container -->
                <div class="rounded-xl overflow-hidden bg-muted h-[400px] md:h-[500px] relative">
                  <!-- Carousel Images with Fade Transition -->
                  <div class="carousel-container h-full w-full relative">
                    <div
                      v-for="(image, index) in galleryImages"
                      :key="index"
                      class="carousel-slide absolute inset-0 transition-opacity duration-500"
                      :class="{ 'opacity-100 z-10': currentSlide === index, 'opacity-0 z-0': currentSlide !== index }"
                    >
                      <img
                        :src="image"
                        :alt="`${caseStudy.title} - Image ${index + 1}`"
                        class="w-full h-full object-cover"
                        @load="imageLoaded(index)"
                      />
                    </div>
                  </div>

                  <!-- Loading Indicator -->
                  <div
                    v-if="isImageLoading"
                    class="absolute inset-0 flex items-center justify-center bg-muted/50 z-20"
                  >
                    <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                  </div>

                  <!-- Swipe Indicator (Mobile) -->
                  <div class="absolute inset-x-0 bottom-4 flex justify-center md:hidden">
                    <div class="bg-black/50 text-white text-xs px-3 py-1 rounded-full">
                      Swipe to navigate
                    </div>
                  </div>
                </div>

                <!-- Navigation Arrows -->
                <button
                  @click="prevSlide"
                  class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-3 transition-all"
                  aria-label="Previous image"
                >
                  <ChevronLeftIcon class="h-6 w-6" />
                </button>

                <button
                  @click="nextSlide"
                  class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-3 transition-all"
                  aria-label="Next image"
                >
                  <ChevronRightIcon class="h-6 w-6" />
                </button>

                <!-- Progress Indicator -->


                <!-- Thumbnails -->
                <div class="flex space-x-2 mt-4 overflow-x-auto pb-2">
                  <button
                    v-for="(image, index) in galleryImages"
                    :key="index"
                    @click="goToSlide(index)"
                    class="flex-shrink-0 w-20 h-20 rounded-md overflow-hidden transition-all"
                    :class="currentSlide === index ? 'ring-2 ring-primary' : 'opacity-70 hover:opacity-100'"
                  >
                    <img
                      :src="image"
                      :alt="`Thumbnail ${index + 1}`"
                      class="w-full h-full object-cover"
                    />
                  </button>
                </div>

                <!-- Slide Counter -->
                <div class="absolute top-4 right-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm">
                  {{ currentSlide + 1 }} / {{ galleryImages.length }}
                </div>
              </div>
            </div>

            <!-- Approach -->
            <div v-if="hasApproach" class="mb-12">
              <h2 class="text-2xl font-bold mb-6">Our Approach</h2>
              <div class="space-y-6">
                <div
                  v-for="(item, index) in caseStudy.approach"
                  :key="index"
                  class="flex items-start bg-card border border-border rounded-lg p-6 transition-all hover:shadow-md"
                >
                  <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mr-4">
                    <span class="text-primary font-bold text-lg">{{ item.step }}</span>
                  </div>
                  <div>
                    <h3 class="text-lg font-semibold mb-2">{{ item.title || `Step ${item.step}` }}</h3>
                    <p class="text-muted-foreground">{{ item.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Technologies Used -->
            <div class="mb-12">
              <h2 class="text-2xl font-bold mb-6">Technologies Used</h2>
              <div class="flex flex-wrap gap-3">
                <span
                  v-for="(tech, index) in extractTechnologies(caseStudy.technologies)"
                  :key="index"
                  class="px-4 py-2 bg-secondary text-secondary-foreground rounded-full text-sm"
                >
                  {{ tech }}
                </span>
              </div>
            </div>

            <!-- Testimonial -->
            <div v-if="hasTestimonial" class="mb-12 bg-card border border-border rounded-xl p-8 relative overflow-hidden">
              <!-- Background Pattern -->
              <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
              <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/5 rounded-full translate-x-1/2 translate-y-1/2"></div>

              <div class="relative">
                <QuoteIcon class="h-12 w-12 text-primary/20 mb-6" />

                <blockquote class="text-xl md:text-2xl font-medium mb-6 relative">
                  "{{ caseStudy.testimonial_quote }}"
                </blockquote>

                <div class="flex items-center">
                  <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mr-4">
                    <UserIcon class="h-6 w-6 text-primary" />
                  </div>
                  <div>
                    <div class="font-semibold">{{ caseStudy.testimonial_name }}</div>
                    <div class="text-sm text-muted-foreground">{{ caseStudy.testimonial_title }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- CTA -->
            <div class="text-center py-8 border-t border-border">
              <h3 class="text-2xl font-bold mb-4">Ready to start your project?</h3>
              <p class="text-muted-foreground max-w-2xl mx-auto mb-8">
                Let's discuss how we can help you achieve your business goals with our custom technology solutions.
              </p>
              <Link
                href="/contact"
                class="inline-flex items-center px-6 py-3 rounded-md bg-primary text-primary-foreground font-medium relative overflow-hidden group"
              >
                <span class="relative z-10">Get in Touch</span>
                <ArrowRightIcon class="ml-2 h-5 w-5 relative z-10 transition-transform duration-300 group-hover:translate-x-1" />
                <div
                  class="absolute inset-0 bg-primary-foreground/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"
                ></div>
              </Link>
            </div>
          </div>
        </div>
      </section>
      <!-- Newsletter Subscription -->
    <Newsletter class="mt-16 md:mt-24"/>
    </div>
  </PublicLayout>
</template>

<script setup>
import Newsletter from '../Company/Newsletter.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
  ArrowLeftIcon,
  ArrowRightIcon,
  CalendarIcon,
  BuildingIcon,
  UserIcon,
  QuoteIcon,
  ChevronLeftIcon,
  ChevronRightIcon
} from 'lucide-vue-next';

// Props from the controller
const props = defineProps({
  caseStudy: {
    type: Object,
    required: true
  }
});

// Loading state
const isLoading = ref(true);
const isImageLoading = ref(false);
const loadedImages = ref(new Set());

// Carousel state
const currentSlide = ref(0);
const carouselInterval = ref(null);
const touchStartX = ref(0);
const touchEndX = ref(0);

// Initialize component
onMounted(() => {
  // Simulate loading for a smoother entry animation
  setTimeout(() => {
    isLoading.value = false;
  }, 800);

  // Start carousel auto-rotation if we have gallery images
  if (hasGallery.value) {
    startCarousel();
  }

  // Add touch event listeners for mobile swipe
  const carouselElement = document.querySelector('.carousel-container');
  if (carouselElement) {
    carouselElement.addEventListener('touchstart', handleTouchStart, { passive: true });
    carouselElement.addEventListener('touchend', handleTouchEnd, { passive: true });
  }

  // Add keyboard navigation
  window.addEventListener('keydown', handleKeyDown);

  // Preload images
  preloadImages();
});

onUnmounted(() => {
  // Clean up carousel interval
  if (carouselInterval.value) {
    clearInterval(carouselInterval.value);
  }

  // Remove touch event listeners
  const carouselElement = document.querySelector('.carousel-container');
  if (carouselElement) {
    carouselElement.removeEventListener('touchstart', handleTouchStart);
    carouselElement.removeEventListener('touchend', handleTouchEnd);
  }

  // Remove keyboard navigation
  window.removeEventListener('keydown', handleKeyDown);
});

// Watch for slide changes to preload next image
watch(currentSlide, (newSlide) => {
  // Preload next image
  const nextIndex = (newSlide + 1) % galleryImages.value.length;
  if (!loadedImages.value.has(nextIndex)) {
    preloadImage(galleryImages.value[nextIndex], nextIndex);
  }
});

// Format category for display
const formatCategory = (category) => {
  if (!category) return 'General';

  // Convert from backend format (e.g., 'web') to display format (e.g., 'Web')
  const categoryMap = {
    'web': 'Web',
    'mobile': 'Mobile',
    'ai': 'AI',
    'ecommerce': 'E-commerce',
    'finance': 'Finance'
  };

  return categoryMap[category] || category;
};

// Extract technologies from the technologies array
const extractTechnologies = (technologies) => {
  if (!technologies) return [];

  // Handle different formats that might come from the backend
  if (Array.isArray(technologies)) {
    // If technologies is an array of objects with a 'technology' property
    if (technologies.length > 0 && technologies[0] && typeof technologies[0] === 'object' && 'technology' in technologies[0]) {
      return technologies.map(tech => tech.technology);
    }

    // If technologies is an array of strings
    return technologies;
  }

  return [];
};

// Gallery carousel
const galleryImages = computed(() => {
  // Use gallery_urls if available, otherwise use gallery
  const gallery = props.caseStudy.gallery_urls || props.caseStudy.gallery || [];

  // Always include the main image as the first slide if it exists
  const mainImage = props.caseStudy.image_url || props.caseStudy.image;

  if (mainImage && !gallery.includes(mainImage)) {
    return [mainImage, ...gallery];
  }

  return gallery.length > 0 ? gallery : (mainImage ? [mainImage] : []);
});

// Preload all gallery images
const preloadImages = () => {
  if (!hasGallery.value) return;

  galleryImages.value.forEach((src, index) => {
    if (index === currentSlide.value) {
      // Current slide is already being loaded in the DOM
      return;
    }
    preloadImage(src, index);
  });
};

// Preload a single image
const preloadImage = (src, index) => {
  const img = new Image();
  img.src = src;
  img.onload = () => {
    loadedImages.value.add(index);
  };
};

// Mark image as loaded
const imageLoaded = (index) => {
  loadedImages.value.add(index);
  isImageLoading.value = false;
};

// Carousel navigation
const nextSlide = () => {
  isImageLoading.value = !loadedImages.value.has((currentSlide.value + 1) % galleryImages.value.length);
  currentSlide.value = (currentSlide.value + 1) % galleryImages.value.length;
  restartCarousel();
};

const prevSlide = () => {
  isImageLoading.value = !loadedImages.value.has((currentSlide.value - 1 + galleryImages.value.length) % galleryImages.value.length);
  currentSlide.value = (currentSlide.value - 1 + galleryImages.value.length) % galleryImages.value.length;
  restartCarousel();
};

// Go to specific slide
const goToSlide = (index) => {
  if (index === currentSlide.value) return;
  isImageLoading.value = !loadedImages.value.has(index);
  currentSlide.value = index;
  restartCarousel();
};

// Start carousel auto-rotation
const startCarousel = () => {
  carouselInterval.value = setInterval(() => {
    nextSlide();
  }, 5000);
};

// Restart carousel auto-rotation
const restartCarousel = () => {
  if (carouselInterval.value) {
    clearInterval(carouselInterval.value);
  }
  startCarousel();
};

// Touch handlers for mobile swipe
const handleTouchStart = (e) => {
  touchStartX.value = e.changedTouches[0].screenX;
};

const handleTouchEnd = (e) => {
  touchEndX.value = e.changedTouches[0].screenX;
  handleSwipe();
};

const handleSwipe = () => {
  // Minimum swipe distance (in pixels)
  const minSwipeDistance = 50;

  const swipeDistance = touchEndX.value - touchStartX.value;

  if (Math.abs(swipeDistance) > minSwipeDistance) {
    if (swipeDistance > 0) {
      // Swipe right - go to previous slide
      prevSlide();
    } else {
      // Swipe left - go to next slide
      nextSlide();
    }
  }
};

// Keyboard navigation
const handleKeyDown = (e) => {
  if (!hasGallery.value) return;

  if (e.key === 'ArrowLeft') {
    prevSlide();
  } else if (e.key === 'ArrowRight') {
    nextSlide();
  }
};

// Check if we have gallery images
const hasGallery = computed(() => {
  return galleryImages.value.length > 1; // Only show carousel if we have more than one image
});

// Check if we have key metrics
const hasKeyMetrics = computed(() => {
  return (props.caseStudy.key_metrics && props.caseStudy.key_metrics.length > 0) ||
         (props.caseStudy.highlights && props.caseStudy.highlights.length > 0);
});

// Check if we have approach steps
const hasApproach = computed(() => {
  return props.caseStudy.approach && props.caseStudy.approach.length > 0;
});

// Check if we have a testimonial
const hasTestimonial = computed(() => {
  return props.caseStudy.testimonial_quote && props.caseStudy.testimonial_name;
});
</script>

<style scoped>
/* Smooth transitions for theme changes */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Animation for spinner */
@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

/* Carousel container */
.carousel-container {
  position: relative;
  overflow: hidden;
}

/* Carousel slide */
.carousel-slide {
  transition: opacity 0.5s ease;
}

/* Reduce animations for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
  * {
    transition: none !important;
    animation: none !important;
  }

  .carousel-slide {
    transition: none !important;
  }
}
</style>
