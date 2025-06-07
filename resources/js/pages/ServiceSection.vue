<template>
  <section id="service-section" class="py-16 sm:py-20 bg-background" aria-labelledby="services-heading">
    <div class="container px-4 mx-auto">
      <!-- Streamlined Section Header -->
      <header class="text-center mb-12 sm:mb-16">
        <h2 id="services-heading" class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
          Our <span class="text-primary">Services</span>
        </h2>
        <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
          Comprehensive technology solutions that drive business growth and digital transformation.
        </p>
      </header>

      <!-- Optimized Services Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" ref="servicesGrid">
        <article v-for="(service, index) in services" :key="service.title" class="service-card group"
          :class="{ 'is-visible': visibleCards[index] }" :style="{ '--delay': `${index * 100}ms` }">
          <div
            class="bg-card rounded-xl p-6 h-full border border-border shadow-sm transition-all duration-300 hover:shadow-lg hover:border-primary/50 hover:-translate-y-2 flex flex-col">

            <!-- Icon Section -->
            <div class="service-icon-wrapper mb-4">
              <div
                class="p-3 rounded-lg bg-primary/10 inline-block group-hover:bg-primary/20 transition-colors duration-300">
                <component :is="service.icon" class="h-6 w-6 text-primary" aria-hidden="true" />
              </div>
            </div>

            <!-- Content Section -->
            <div class="flex-1">
              <h3 class="text-xl font-semibold mb-3 group-hover:text-primary transition-colors duration-300">
                {{ service.title }}
              </h3>

              <p class="text-muted-foreground mb-4 leading-relaxed">
                {{ service.description }}
              </p>

              <!-- Simplified Feature Highlights -->
              <div class="mb-6">
                <div class="flex flex-wrap gap-2">
                  <span v-for="(feature, i) in service.highlights" :key="i"
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary">
                    {{ feature }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Single CTA Button -->
            <div class="mt-auto">
              <button @click="requestQuote(service.title)"
                class="w-full inline-flex items-center justify-center rounded-lg text-sm font-medium transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 hover:shadow-md h-10 px-4"
                :aria-label="`Get a quote for ${service.title} services`">
                <span>Get Quote</span>
                <ArrowRightIcon class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                  aria-hidden="true" />
              </button>
            </div>
          </div>
        </article>
      </div>

      <!-- Streamlined Bottom CTA -->
      <div class="mt-12 sm:mt-16 text-center" ref="bottomCta" :class="{ 'is-visible': isCtaVisible }">
        <div class="bg-card/50 backdrop-blur-sm rounded-xl p-6 sm:p-8 border border-border">
          <h3 class="text-xl font-semibold mb-3">Need a Custom Solution?</h3>
          <p class="text-muted-foreground mb-6 max-w-md mx-auto">
            Let's discuss your unique requirements and create a tailored technology strategy.
          </p>
          <button @click="scheduleConsultation"
            class="inline-flex items-center justify-center rounded-lg text-sm font-medium transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 hover:shadow-lg h-11 px-6"
            aria-label="Schedule a free consultation">
            <MessageSquareIcon class="mr-2 h-4 w-4" aria-hidden="true" />
            Schedule Free Consultation
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3';
import {
  GlobeIcon,
  SmartphoneIcon,
  PaletteIcon,
  ServerIcon,
  CodeIcon,
  BarChartIcon,
  ArrowRightIcon,
  MessageSquareIcon
} from 'lucide-vue-next'



declare global {
  interface Window {
    gtag: any;
  }
}

// Streamlined service data with concise descriptions
const services = [
  {
    icon: GlobeIcon,
    title: "Web Development",
    description: "Fast, responsive websites and web applications that convert visitors into customers.",
    highlights: ["Responsive Design", "E-commerce", "CMS", "PWA"]
  },
  {
    icon: SmartphoneIcon,
    title: "Mobile Development",
    description: "Native and cross-platform mobile apps that engage users across all devices.",
    highlights: ["iOS & Android", "Cross-Platform", "App Store", "Updates"]
  },
  {
    icon: PaletteIcon,
    title: "UI/UX Design",
    description: "User-centered design that combines beautiful aesthetics with seamless functionality.",
    highlights: ["User Research", "Prototyping", "Branding", "Testing"]
  },
  {
    icon: ServerIcon,
    title: "Cloud & DevOps",
    description: "Scalable cloud infrastructure and streamlined development workflows.",
    highlights: ["CI/CD", "Cloud Migration", "Monitoring", "Security"]
  },
  {
    icon: CodeIcon,
    title: "Custom Software",
    description: "Bespoke software solutions tailored to your specific business requirements.",
    highlights: ["Enterprise Apps", "APIs", "Integration", "Legacy Upgrade"]
  },
  {
    icon: BarChartIcon,
    title: "Digital Marketing",
    description: "Data-driven strategies that increase visibility and drive measurable growth.",
    highlights: ["SEO", "Content", "Social Media", "Analytics"]
  }
]

// Enhanced navigation functions with analytics tracking
const requestQuote = (serviceName: string) => {
  // Track the service interest for analytics
  if (typeof window.gtag !== 'undefined') {
    window.gtag('event', 'quote_request', {
      service_name: serviceName,
      event_category: 'engagement'
    })
  }

  // Navigate to contact with service pre-selected
  const contactSection = document.getElementById('contact-section')
  if (contactSection) {
    contactSection.scrollIntoView({ behavior: 'smooth', block: 'start' })

    // Optional: Pre-fill form with service selection
    setTimeout(() => {
      const serviceSelect = document.querySelector('select[name="service"]') as HTMLSelectElement
      if (serviceSelect) {
        serviceSelect.value = serviceName
        serviceSelect.dispatchEvent(new Event('change'))
      }
    }, 500)
  }
}

const scheduleConsultation = () => {
  // Track consultation interest
  router.visit('/agency/consultation')

}

// Navigate to contact section



// Optimized Intersection Observer implementation
const servicesGrid = ref<HTMLElement | null>(null)
const bottomCta = ref<HTMLElement | null>(null)
const visibleCards = ref(Array(services.length).fill(false))
const isCtaVisible = ref(false)

let observers: IntersectionObserver[] = []

onMounted(() => {
  // Optimized observer for service cards
  if (servicesGrid.value) {
    const cardElements = servicesGrid.value.querySelectorAll('.service-card')

    const cardObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const index = Array.from(cardElements).indexOf(entry.target)
            if (index !== -1) {
              visibleCards.value[index] = true
            }
            cardObserver.unobserve(entry.target)
          }
        })
      },
      {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      }
    )

    cardElements.forEach(card => {
      cardObserver.observe(card)
    })

    observers.push(cardObserver)
  }

  // Observer for bottom CTA
  if (bottomCta.value) {
    const ctaObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            isCtaVisible.value = true
            ctaObserver.unobserve(entry.target)
          }
        })
      },
      { threshold: 0.1 }
    )

    ctaObserver.observe(bottomCta.value)
    observers.push(ctaObserver)
  }
})

// Cleanup observers
onUnmounted(() => {
  observers.forEach(observer => observer.disconnect())
  observers = []
})
</script>

<style scoped>
/* Enhanced base styles with better performance */
.service-card {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
  transition-delay: var(--delay);
  contain: layout style paint;
}

.service-card.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Enhanced hover effects */
.service-card:hover {
  will-change: transform;
}

.service-card:not(:hover) {
  will-change: auto;
}

/* Icon wrapper enhanced animation */
.service-icon-wrapper {
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.service-card:hover .service-icon-wrapper {
  transform: scale(1.1) rotate(5deg);
}

/* Bottom CTA enhanced styling */
.mt-12 {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
  transition-delay: 600ms;
}

.mt-12.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Feature highlights styling */
.service-card .flex-wrap span {
  transition: all 0.2s ease;
}

.service-card:hover .flex-wrap span {
  transform: scale(1.05);
}

/* Enhanced button animations */
.service-card button {
  position: relative;
  overflow: hidden;
}

.service-card button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
  transition: left 0.5s;
}

.service-card:hover button::before {
  left: 100%;
}

/* Responsive optimizations */
@media (max-width: 768px) {
  .service-card {
    transform: translateY(20px);
  }

  .service-icon-wrapper {
    margin-bottom: 1rem;
  }
}

/* Accessibility and reduced motion */
@media (prefers-reduced-motion: reduce) {

  .service-card,
  .mt-12,
  .service-icon-wrapper,
  .service-card button::before {
    transition: none;
    animation: none;
    transform: none;
  }

  .service-card {
    opacity: 1;
  }

  .mt-12 {
    opacity: 1;
  }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
  .service-card>div {
    border-width: 2px;
  }

  .service-card .flex-wrap span {
    border: 1px solid currentColor;
  }
}

/* Print styles */
@media print {
  .service-card {
    opacity: 1;
    transform: none;
    break-inside: avoid;
  }

  .service-card button {
    display: none;
  }
}

/* Focus styles for better accessibility */
.service-card:focus-within {
  outline: 2px solid hsl(var(--primary));
  outline-offset: 2px;
}

/* Performance optimization for animations */
.service-card:hover {
  transform: translateY(-8px);
}

/* Ensure consistent card heights */
.service-card>div {
  min-height: 280px;
}

@media (min-width: 1024px) {
  .service-card>div {
    min-height: 320px;
  }
}
</style>
