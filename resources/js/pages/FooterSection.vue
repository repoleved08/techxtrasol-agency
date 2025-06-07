<template>
  <footer class="bg-muted/30 pt-16 border-t border-border relative" role="contentinfo" aria-label="Site footer">
    <!-- Back to Top Button with improved accessibility -->
    <button
      @click="scrollToTop"
      class="back-to-top-btn absolute -top-6 left-1/2 transform -translate-x-1/2 bg-primary text-primary-foreground rounded-full p-3 shadow-lg hover:shadow-xl transition-all duration-300"
      :class="{ 'opacity-100': showBackToTop, 'opacity-0 pointer-events-none': !showBackToTop }"
      aria-label="Back to top"
      :tabindex="showBackToTop ? 0 : -1"
    >
      <ArrowUpIcon class="h-5 w-5" aria-hidden="true" />
    </button>

    <div class="container px-4 mx-auto">
      <!-- Main Footer Content -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-10">
        <!-- Company Info -->
        <div class="space-y-6">
          <div class="flex items-center">
            <div class="bg-gradient-to-r from-primary to-purple-600 p-2 rounded-md mr-2" aria-hidden="true">
              <CodeIcon class="h-6 w-6 text-white" />
            </div>
            <span class="text-xl font-bold">TechXtraSol</span>
          </div>

          <p class="text-muted-foreground">
            Innovative technology solutions for businesses of all sizes. We transform ideas into powerful digital experiences.
          </p>

          <div class="flex space-x-4" aria-label="Social media links">
            <a
              v-for="social in socialLinks"
              :key="social.name"
              :href="social.url"
              class="social-icon-btn p-2 bg-background rounded-full hover:bg-primary/10 transition-colors duration-300"
              :aria-label="`Visit our ${social.name} page`"
              rel="noopener noreferrer"
              target="_blank"
            >
              <component :is="social.icon" class="h-5 w-5 text-muted-foreground hover:text-primary transition-colors duration-300" aria-hidden="true" />
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <nav aria-labelledby="footer-quick-links">
          <h3 id="footer-quick-links" class="text-lg font-semibold mb-6 relative footer-heading">
            Quick Links
          </h3>
          <ul class="space-y-3">
            <li v-for="link in quickLinks" :key="link.name">
              <a
                :href="link.url"
                class="text-muted-foreground hover:text-primary transition-colors duration-300 flex items-center footer-link"
              >
                <ChevronRightIcon class="h-4 w-4 mr-2 text-primary/70" aria-hidden="true" />
                {{ link.name }}
              </a>
            </li>
          </ul>
        </nav>

        <!-- Services -->
        <nav aria-labelledby="footer-services">
          <h3 id="footer-services" class="text-lg font-semibold mb-6 relative footer-heading">
            Our Services
          </h3>
          <ul class="space-y-3">
            <li v-for="service in services" :key="service.name">
              <a
                :href="service.url"
                class="text-muted-foreground hover:text-primary transition-colors duration-300 flex items-center footer-link"
              >
                <component :is="service.icon" class="h-4 w-4 mr-2 text-primary/70" aria-hidden="true" />
                {{ service.name }}
              </a>
            </li>
          </ul>
        </nav>

        <!-- Newsletter -->
        <div>
          <h3 id="newsletter-heading" class="text-lg font-semibold mb-6 relative footer-heading">
            Stay Updated
          </h3>
          <p class="text-muted-foreground mb-4">
            Subscribe to our newsletter for the latest updates and insights.
          </p>

          <form
            @submit.prevent="subscribeNewsletter"
            class="space-y-3"
            aria-labelledby="newsletter-heading"
          >
            <div class="relative">
              <label for="email-input" class="sr-only">Email address</label>
              <MailIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" aria-hidden="true" />
              <input
                id="email-input"
                v-model="email"
                type="email"
                placeholder="Your email address"
                class="w-full pl-10 pr-4 py-2 rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                required
                autocomplete="email"
              />
            </div>
            <button
              type="submit"
              class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 newsletter-btn"
              :disabled="isSubscribing"
              aria-live="polite"
            >
              <span v-if="!isSubscribing">Subscribe</span>
              <div v-else class="flex items-center">
                <LoaderIcon class="h-4 w-4 mr-2 animate-spin" aria-hidden="true" />
                <span>Subscribing...</span>
              </div>
            </button>
          </form>

          <!-- Success Message -->
          <div
            v-if="showSuccess"
            class="success-message mt-3 p-2 bg-green-50 border border-green-200 rounded-md text-green-700 text-xs"
            role="status"
            aria-live="polite"
          >
            <div class="flex items-start">
              <CheckCircleIcon class="h-4 w-4 mr-1 flex-shrink-0" aria-hidden="true" />
              <span>Thank you for subscribing!</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Bar -->
      <div class="py-6 border-t border-border flex flex-wrap gap-6 justify-between items-center">
        <div class="flex flex-wrap gap-6">
          <address class="flex items-center text-sm text-muted-foreground not-italic">
            <MapPinIcon class="h-4 w-4 mr-2 text-primary" aria-hidden="true" />
            <span>907 Nakuru, Kenya, 20100</span>
          </address>
          <div class="flex items-center text-sm text-muted-foreground">
            <PhoneIcon class="h-4 w-4 mr-2 text-primary" aria-hidden="true" />
            <a href="tel:+254714000481" class="hover:text-primary transition-colors duration-300">+254714000481</a>
          </div>
          <div class="flex items-center text-sm text-muted-foreground">
            <MailIcon class="h-4 w-4 mr-2 text-primary" aria-hidden="true" />
            <a href="mailto:info@techxtrasol.com" class="hover:text-primary transition-colors duration-300">info@techxtrasol.com</a>
          </div>
        </div>

        <nav aria-label="Legal links">
          <ul class="flex flex-wrap items-center">
            <li>
              <a href="/privacy-policy" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300 mr-4">
                Privacy Policy
              </a>
            </li>
            <li>
              <a href="/terms-of-service" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-300 mr-4">
                Terms of Service
              </a>
            </li>
            
          </ul>
        </nav>
      </div>

      <!-- Copyright -->
      <div class="py-6 border-t border-border text-center text-sm text-muted-foreground">
        <p>© {{ currentYear }} TechXtraSol. All rights reserved.</p>
        <p class="mt-1 text-xs">
          Designed with <span class="sr-only">love</span><HeartIcon class="inline-block h-3 w-3 text-red-500" aria-hidden="true" /> by TechXtraSol Team
        </p>
      </div>
    </div>

    <!-- Footer Bottom Accent -->
    <div class="h-2 w-full bg-gradient-to-r from-primary via-purple-600 to-pink-500" aria-hidden="true"></div>
  </footer>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import {
  CodeIcon, ArrowUpIcon, ChevronRightIcon, MailIcon, LoaderIcon,
  CheckCircleIcon, MapPinIcon, PhoneIcon, HeartIcon,
  TwitterIcon, LinkedinIcon, GithubIcon, InstagramIcon, FacebookIcon,
  GlobeIcon, CodepenIcon, SmartphoneIcon, ServerIcon, PaletteIcon
} from 'lucide-vue-next';

// Current year for copyright - memoized
const currentYear = computed(() => new Date().getFullYear());

// Newsletter subscription
const email = ref('');
const isSubscribing = ref(false);
const showSuccess = ref(false);

// Optimized newsletter subscription with debounce
let subscriptionTimeout;
const subscribeNewsletter = () => {
  if (isSubscribing.value) return;

  isSubscribing.value = true;

  // Clear any existing timeouts
  clearTimeout(subscriptionTimeout);

  // Simulate API call with reduced timeout
  subscriptionTimeout = setTimeout(() => {
    isSubscribing.value = false;
    showSuccess.value = true;
    email.value = '';

    // Hide success message after 5 seconds
    subscriptionTimeout = setTimeout(() => {
      showSuccess.value = false;
    }, 5000);
  }, 800); // Reduced from 1500ms to 800ms for better UX
};

// Back to top button with throttling
const showBackToTop = ref(false);
let scrollTimeout;
let lastScrollY = 0;

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'
  });
};

// Throttled scroll handler for better performance
const handleScroll = () => {
  if (!scrollTimeout) {
    scrollTimeout = setTimeout(() => {
      // Only update if there's a significant change
      if (Math.abs(window.scrollY - lastScrollY) > 50) {
        showBackToTop.value = window.scrollY > 500;
        lastScrollY = window.scrollY;
      }
      scrollTimeout = null;
    }, 100);
  }
};

// Lifecycle hooks with proper cleanup
onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true });

  // Initial check for scroll position (e.g., on page refresh)
  showBackToTop.value = window.scrollY > 500;
  lastScrollY = window.scrollY;

  // Check for reduced motion preference
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.classList.add('reduced-motion');
  }
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
  clearTimeout(scrollTimeout);
  clearTimeout(subscriptionTimeout);
});

// Social links - memoized to avoid re-renders
const socialLinks = [
  { name: 'Twitter', url: 'https://x.com/techxtrasol', icon: TwitterIcon },
  { name: 'LinkedIn', url: '#', icon: LinkedinIcon },
  { name: 'GitHub', url: 'https://github.com/techxtrasol', icon: GithubIcon },
  { name: 'Instagram', url: '#', icon: InstagramIcon },
  { name: 'Facebook', url: 'https://www.facebook.com/profile.php?id=100064183236955', icon: FacebookIcon }
];

// Quick links - memoized to avoid re-renders
const quickLinks = [
  { name: 'Home', url: '/' },
  { name: 'About Us', url: '/about-us' },
  { name: 'Portfolio', url: '/portfolio' },
  { name: 'Blog', url: '/agency/blog' },
  { name: 'Careers', url: '/careers' },
  { name: 'Contact Us', url: '/contact' }
];

// Services - memoized to avoid re-renders
const services = [
  { name: 'Web Development', url: '/services/web-development', icon: GlobeIcon },
  { name: 'Mobile App Development', url: '/services/mobile-development', icon: SmartphoneIcon },
  { name: 'UI/UX Design', url: '/services/ui-ux-design', icon: PaletteIcon },
  { name: 'Custom Software', url: '/services/custom-software', icon: CodepenIcon },
  { name: 'Cloud Solutions', url: '/services/cloud-solutions', icon: ServerIcon }
];
</script>

<style scoped>
.back-to-top-btn {
  transition: opacity 0.3s ease, transform 0.3s ease;
  z-index: 10;
  will-change: transform, opacity;
}

.back-to-top-btn:hover {
  transform: translate(-50%, -3px);
}

.footer-heading::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 40px;
  height: 2px;
  background: linear-gradient(to right, hsl(var(--primary)), transparent);
}

.footer-link {
  position: relative;
  padding-left: 0;
  transition: padding-left 0.3s ease, color 0.3s ease;
}

.footer-link:hover {
  padding-left: 5px;
}

.social-icon-btn {
  transition: transform 0.3s ease, background-color 0.3s ease;
}

.social-icon-btn:hover {
  transform: translateY(-3px);
}

.newsletter-btn {
  position: relative;
  overflow: hidden;
}

.success-message {
  opacity: 0;
  transform: translateY(10px);
  animation: fadeInUp 0.5s ease-out forwards;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  .back-to-top-btn,
  .footer-link,
  .social-icon-btn,
  .newsletter-btn,
  .success-message {
    transition: none;
    animation: none;
    transform: none;
  }

  .back-to-top-btn:hover,
  .footer-link:hover,
  .social-icon-btn:hover {
    transform: none;
  }

  .success-message {
    opacity: 1;
    transform: none;
  }

  .newsletter-btn::after {
    display: none;
  }
}

/* For JS detection of reduced motion preference */
:root.reduced-motion * {
  transition-duration: 0.001ms !important;
  animation-duration: 0.001ms !important;
}
</style>
