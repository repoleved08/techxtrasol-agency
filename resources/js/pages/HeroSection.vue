<template>
  <section
    class="hero-section relative overflow-hidden min-h-screen"
    aria-labelledby="hero-heading"
    role="banner"
  >
    <!-- Optimized background with reduced complexity -->
    <div class="hero-background" aria-hidden="true"></div>

    <!-- Skip link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Main content -->
    <div class="container relative z-10 mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center min-h-[calc(100vh-8rem)]">

        <!-- Left content -->
        <header class="space-y-6 sm:space-y-8 text-center lg:text-left">

          <!-- Company branding -->
          <div class="inline-flex items-center h-14" role="img" aria-label="TechXtraSol Technology Solutions">
            <div class="flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-xl bg-primary/10 border border-primary/20">
              <div class="relative h-6 w-6 sm:h-8 sm:w-8">
                <span class="absolute inset-0 ping-animation rounded-full bg-primary/30" aria-hidden="true"></span>
                <CodeIcon class="relative h-6 w-6 sm:h-8 sm:w-8 text-primary" aria-hidden="true" />
              </div>
            </div>
            <div class="ml-3 flex flex-col justify-center">
              <span class="text-lg sm:text-xl font-bold tracking-tight text-foreground">TechXtraSol</span>
              <span class="text-xs text-muted-foreground">Technology Solutions</span>
            </div>
          </div>

          <!-- Main headline with better SEO -->
          <h1
            id="hero-heading"
            class="text-3xl sm:text-4xl md:text-5xl lg:text-4xl xl:text-5xl 2xl:text-6xl font-extrabold tracking-tight leading-tight"
          >
            <span class="text-foreground">Transform Your Business with</span>
            <span class="block bg-gradient-to-r from-primary via-primary/80 to-purple-600 bg-clip-text text-transparent">
              Cutting-Edge Technology
            </span>
          </h1>

          <!-- Concise, professional description -->
          <p class="text-base sm:text-lg lg:text-xl text-muted-foreground leading-relaxed max-w-2xl mx-auto lg:mx-0">
            We deliver scalable web applications, mobile solutions, and AI integration that drive measurable business growth.
          </p>

          <!-- Enhanced CTA buttons with better accessibility -->
          <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
            <Button
              @click="scrollToContactUs"
              size="lg"
              class="cta-primary group"
              aria-describedby="cta-description"
            >
              <span>Start Your Project</span>
              <ArrowRightIcon class="ml-2 h-4 w-4 sm:h-5 sm:w-5 transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" />
            </Button>

            <Button
              @click="scrollToPortfolio"
              size="lg"
              variant="outline"
              class="cta-secondary group"
            >
              <span>View Our Work</span>
              <EyeIcon class="ml-2 h-4 w-4 sm:h-5 sm:w-5 transition-transform duration-300 group-hover:scale-110" aria-hidden="true" />
            </Button>
          </div>

          <!-- Hidden description for screen readers -->
          <div id="cta-description" class="sr-only">
            Contact us to discuss your technology needs and get a free consultation
          </div>

          <!-- Enhanced statistics with better semantics -->
          <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-6 sm:pt-8" role="region" aria-label="Company achievements">
            <div class="stat-item" tabindex="0">
              <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-foreground">
                <span ref="projectsCounter" aria-label="Over 500 projects completed">500+</span>
              </div>
              <div class="text-xs sm:text-sm text-muted-foreground mt-1">Projects Delivered</div>
            </div>

            <div class="stat-item" tabindex="0">
              <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-foreground">
                <span ref="clientsCounter" aria-label="Over 150 satisfied clients">150+</span>
              </div>
              <div class="text-xs sm:text-sm text-muted-foreground mt-1">Happy Clients</div>
            </div>

            <div class="stat-item" tabindex="0">
              <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-foreground">
                <span ref="yearsCounter" aria-label="12 years of experience">12+</span>
              </div>
              <div class="text-xs sm:text-sm text-muted-foreground mt-1">Years Experience</div>
            </div>
          </div>
        </header>

        <!-- Right content - Enhanced service showcase -->
        <aside class="w-full max-w-lg mx-auto lg:max-w-none lg:ml-auto" aria-label="Our core services">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
            <article
              v-for="(feature, index) in features"
              :key="feature.title"
              class="feature-card group"
              :style="{ animationDelay: `${index * 100}ms` }"
              tabindex="0"
              role="article"
            >
              <div class="feature-icon-wrapper" aria-hidden="true">
                <component :is="feature.icon" class="h-4 w-4 sm:h-5 sm:w-5 text-primary-foreground" />
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="text-sm sm:text-base font-semibold text-foreground mb-1">{{ feature.title }}</h3>
                <p class="text-xs sm:text-sm text-muted-foreground leading-relaxed">{{ feature.description }}</p>
              </div>
            </article>
          </div>
        </aside>
      </div>

      <!-- Enhanced scroll indicator -->
      <div class="absolute bottom-4 sm:bottom-8 left-1/2 transform -translate-x-1/2 flex flex-col items-center animate-fade-in-up">
        <span class="text-xs sm:text-sm text-muted-foreground mb-2 hidden sm:block">Discover More</span>
        <button
          @click="scrollToNextSection"
          class="scroll-indicator"
          aria-label="Scroll to next section"
        >
          <ChevronDownIcon class="h-4 w-4 sm:h-5 sm:w-5 animate-bounce text-muted-foreground" />
        </button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, computed } from 'vue'
import { Button } from '@/components/ui/button'
import {
  CodeIcon,
  ArrowRightIcon,
  EyeIcon,
  ChevronDownIcon,
  GlobeIcon,
  BrainCircuitIcon,
  RocketIcon,
  SmartphoneIcon
} from 'lucide-vue-next'
import { useSeoMeta } from '@/composables/useSeoMeta' // Import your SEO composable

// Enhanced feature data with better copy
const features = [
  {
    title: 'Web Development',
    description: 'Responsive, fast-loading websites that convert visitors into customers.',
    icon: GlobeIcon
  },
  {
    title: 'Mobile Solutions',
    description: 'Native and cross-platform apps that engage users on any device.',
    icon: SmartphoneIcon
  },
  {
    title: 'AI Integration',
    description: 'Smart automation that streamlines operations and boosts efficiency.',
    icon: BrainCircuitIcon
  },
  {
    title: 'Digital Strategy',
    description: 'Data-driven approaches that accelerate your digital transformation.',
    icon: RocketIcon
  }
]

// SEO structured data - properly implemented
// This will be used by your head management solution
const structuredData = {
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "TechXtraSol",
  "description": "Technology solutions company specializing in web development, mobile applications, and AI integration",
  "url": "https://techxtrasol.com",
  "logo": "https://techxtrasol.com/logo.png",
  "foundingDate": "2024",
  "numberOfEmployees": "50-100",
  "address": {
    "@type": "PostalAddress",
    "addressCountry": "KE"
  },
  "sameAs": [
    "https://linkedin.com/company/techxtrasol",
    "https://twitter.com/techxtrasol"
  ],
  "offers": {
    "@type": "Service",
    "serviceType": ["Web Development", "Mobile App Development", "AI Integration", "Digital Strategy"]
  }
}

// Apply SEO metadata
useSeoMeta({
  title: 'TechXtraSol - Technology Solutions for Business Growth',
  description: 'We deliver scalable web applications, mobile solutions, and AI integration that drive measurable business growth.',
  structuredData: structuredData
})

// Enhanced scroll functions with error handling
const scrollToPortfolio = () => {
  const section = document.getElementById('portfolio-section')
  if (section) {
    section.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }
}

const scrollToContactUs = () => {
  const section = document.getElementById('contact-section')
  if (section) {
    section.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }
}

const scrollToNextSection = () => {
  const nextSection = document.querySelector('section:nth-of-type(2)')
  if (nextSection) {
    nextSection.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }
}

// Optimized counter animation with Intersection Observer
const projectsCounter = ref<HTMLElement | null>(null)
const clientsCounter = ref<HTMLElement | null>(null)
const yearsCounter = ref<HTMLElement | null>(null)

const animateCounter = (element: HTMLElement, endValue: number, duration = 2000) => {
  let startTime: number | null = null
  const startValue = 0

  const step = (timestamp: number) => {
    if (!startTime) startTime = timestamp
    const progress = Math.min((timestamp - startTime) / duration, 1)
    const easeOutQuart = 1 - Math.pow(1 - progress, 4)
    const currentValue = Math.floor(easeOutQuart * (endValue - startValue) + startValue)

    element.textContent = `${currentValue}+`

    if (progress < 1) {
      requestAnimationFrame(step)
    }
  }

  requestAnimationFrame(step)
}

onMounted(() => {
  nextTick(() => {
    const counters = [
      { element: projectsCounter.value, value: 50 },
      { element: clientsCounter.value, value: 10 },
      { element: yearsCounter.value, value: 3 }
    ]

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const counter = counters.find(c => c.element === entry.target)
            if (counter) {
              animateCounter(counter.element as HTMLElement, counter.value)
              observer.unobserve(entry.target)
            }
          }
        })
      },
      { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
    )

    counters.forEach(counter => {
      if (counter.element) {
        observer.observe(counter.element)
      }
    })
  })
})
</script>

<style scoped>
/* Enhanced base styles with better performance */
.hero-section {
  background-color: hsl(var(--background));
  color: hsl(var(--foreground));
  contain: layout style paint;
}

/* Skip link for accessibility */
.skip-link {
  position: absolute;
  top: -40px;
  left: 6px;
  background: hsl(var(--primary));
  color: hsl(var(--primary-foreground));
  padding: 8px;
  text-decoration: none;
  border-radius: 4px;
  z-index: 1000;
  transition: top 0.3s;
}

.skip-link:focus {
  top: 6px;
}

/* Optimized background with better performance */
.hero-background {
  position: absolute;
  inset: 0;
  background:
    radial-gradient(circle at 25% 25%, hsl(var(--primary) / 0.04) 0%, transparent 50%),
    radial-gradient(circle at 75% 75%, hsl(var(--primary) / 0.02) 0%, transparent 50%);
  will-change: transform;
}

/* Enhanced ping animation with better performance */
.ping-animation {
  animation: ping 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes ping {
  0% { transform: scale(1); opacity: 0.8; }
  50% { transform: scale(1.5); opacity: 0.4; }
  100% { transform: scale(2); opacity: 0; }
}

/* Enhanced CTA buttons */
.cta-primary {
  @apply w-full sm:w-auto bg-primary hover:bg-primary/90 text-primary-foreground px-6 sm:px-8 py-3 sm:py-4 shadow-lg hover:shadow-xl transition-all duration-300;
}

.cta-secondary {
  @apply w-full sm:w-auto border-border hover:bg-accent px-6 sm:px-8 py-3 sm:py-4 transition-all duration-300;
}

/* Enhanced feature cards with better animations */
.feature-card {
  @apply flex items-start gap-3 p-4 rounded-xl bg-card border border-border;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  animation: fade-in-up 0.6s ease-out forwards;
  opacity: 0;
  transform: translateY(20px);
}

.feature-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px -5px hsl(var(--primary) / 0.1);
  border-color: hsl(var(--primary) / 0.3);
}

.feature-card:focus-visible {
  outline: 2px solid hsl(var(--primary));
  outline-offset: 2px;
}

.feature-icon-wrapper {
  @apply flex items-center justify-center w-8 h-8 rounded-lg bg-primary flex-shrink-0;
  transition: transform 0.3s ease;
}

.feature-card:hover .feature-icon-wrapper {
  transform: scale(1.1) rotate(5deg);
}

/* Enhanced statistics */
.stat-item {
  @apply text-center p-3 rounded-lg bg-card/50 border border-border;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.stat-item:hover {
  transform: translateY(-2px);
  border-color: hsl(var(--primary) / 0.3);
  background-color: hsl(var(--card) / 0.8);
}

.stat-item:focus-visible {
  outline: 2px solid hsl(var(--primary));
  outline-offset: 2px;
}

/* Scroll indicator enhancement */
.scroll-indicator {
  @apply p-2 rounded-full hover:bg-accent transition-colors duration-300;
  background: none;
  border: none;
  cursor: pointer;
}

/* Animation keyframes */
@keyframes fade-in-up {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out 0.5s forwards;
  opacity: 0;
  transform: translateY(20px);
}

/* Screen reader only class */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

/* Responsive optimizations */
@media (max-width: 640px) {
  .feature-card {
    padding: 1rem;
    gap: 0.75rem;
  }

  .feature-icon-wrapper {
    width: 1.75rem;
    height: 1.75rem;
  }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  .ping-animation,
  .animate-bounce,
  .animate-fade-in-up {
    animation: none;
  }

  .feature-card {
    animation: none;
    opacity: 1;
    transform: none;
  }

  .feature-card:hover,
  .stat-item:hover,
  .feature-icon-wrapper {
    transform: none;
  }

  * {
    transition: none !important;
  }
}

/* High contrast mode */
@media (prefers-contrast: high) {
  .feature-card,
  .stat-item {
    border-width: 2px;
  }
}

/* Dark theme optimizations */
@media (prefers-color-scheme: dark) {
  .hero-background {
    background:
      radial-gradient(circle at 25% 25%, hsl(var(--primary) / 0.06) 0%, transparent 50%),
      radial-gradient(circle at 75% 75%, hsl(var(--primary) / 0.04) 0%, transparent 50%);
  }
}

/* Performance optimizations */
.feature-card:not(:hover),
.stat-item:not(:hover) {
  will-change: auto;
}

.feature-card:hover,
.stat-item:hover {
  will-change: transform;
}

/* Print styles */
@media print {
  .hero-section {
    min-height: auto;
    background: white;
    color: black;
  }

  .hero-background,
  .ping-animation,
  .scroll-indicator {
    display: none;
  }

  .cta-primary,
  .cta-secondary {
    display: none;
  }
}
</style>
