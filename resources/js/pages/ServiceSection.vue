<template>
  <section
    class="py-20 bg-background"
    aria-labelledby="services-heading"
  >
    <div class="container px-4 mx-auto">
      <!-- Section Header with semantic HTML -->
      <div class="text-center mb-16">
        <h2 id="services-heading" class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
          Our <span class="text-primary">Services</span>
        </h2>
        <p class="text-muted-foreground max-w-2xl mx-auto">
          We offer a comprehensive range of technology solutions to help your business thrive in the digital landscape.
        </p>
      </div>

      <!-- Services Grid with Intersection Observer for performance -->
      <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
        ref="servicesGrid"
      >
        <div
          v-for="(service, index) in services"
          :key="service.title"
          class="service-card"
          :class="{ 'is-visible': visibleCards[index] }"
        >
          <div class="bg-card rounded-lg p-6 h-full border border-border shadow-sm transition-all duration-300 hover:shadow-md hover:border-primary/50 hover:-translate-y-1">
            <!-- Icon with explicit dimensions to prevent layout shifts -->
            <div class="service-icon-wrapper mb-6">
              <div class="p-4 rounded-lg bg-primary/10 inline-block">
                <component :is="service.icon" class="h-8 w-8 text-primary" aria-hidden="true" />
              </div>
            </div>

            <!-- Semantic heading with proper hierarchy -->
            <h3 class="text-xl font-semibold mb-3 group-hover:text-primary transition-colors duration-300">
              {{ service.title }}
            </h3>

            <p class="text-muted-foreground mb-6">
              {{ service.description }}
            </p>

            <!-- Feature list with semantic markup -->
            <ul class="mb-6 space-y-2" aria-label="Features">
              <li
                v-for="(feature, i) in service.features"
                :key="i"
                class="flex items-start"
              >
                <CheckIcon class="h-5 w-5 text-primary mr-2 flex-shrink-0 mt-0.5" aria-hidden="true" />
                <span class="text-sm">{{ feature }}</span>
              </li>
            </ul>

            <!-- Action buttons with proper accessibility -->
            <div class="mt-auto pt-4 flex space-x-3">
              <button
                @click="goToConsult"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 py-2"
                aria-label="Get a quote for {{ service.title }}"
              >
                Get a Quote
              </button>
              <button
                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2"
                aria-label="Learn more about {{ service.title }}"
              >
                Learn More
                <ArrowRightIcon class="ml-2 h-4 w-4" aria-hidden="true" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom CTA with semantic markup -->
      <div
        class="mt-16 text-center"
        ref="bottomCta"
        :class="{ 'is-visible': isCtaVisible }"
      >
        <h3 class="text-xl font-semibold mb-4">Need a custom solution?</h3>
        <button
          @click="goToConsult"
          class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-6 py-2"
        >
          <MessageSquareIcon class="mr-2 h-4 w-4" aria-hidden="true" />
          Schedule a Consultation
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import {
  GlobeIcon, SmartphoneIcon, PaletteIcon, ServerIcon,
  CodeIcon, BarChartIcon, CheckIcon, ArrowRightIcon,
  MessageSquareIcon
} from 'lucide-vue-next';

// Navigation function
const goToConsult = () => {
  window.location.href = '/consultation';
};

// Service data with structured content for SEO
const services = [
  {
    icon: GlobeIcon,
    title: "Web Development",
    description: "We create responsive, high-performance websites and web applications tailored to your business needs.",
    features: [
      "Custom website development",
      "Progressive web applications",
      "E-commerce solutions",
      "CMS implementation"
    ]
  },
  {
    icon: SmartphoneIcon,
    title: "Mobile App Development",
    description: "Native and cross-platform mobile applications that deliver exceptional user experiences across all devices.",
    features: [
      "iOS and Android development",
      "Cross-platform solutions",
      "App maintenance and updates",
      "Performance optimization"
    ]
  },
  {
    icon: PaletteIcon,
    title: "UI/UX Design",
    description: "User-centered design that combines aesthetics with functionality to create engaging digital experiences.",
    features: [
      "User research and testing",
      "Wireframing and prototyping",
      "Visual design and branding",
      "Interaction design"
    ]
  },
  {
    icon: ServerIcon,
    title: "DevOps & Cloud Solutions",
    description: "Streamline your development workflow and optimize your cloud infrastructure for performance and cost.",
    features: [
      "CI/CD pipeline setup",
      "Cloud migration and management",
      "Infrastructure as code",
      "Performance monitoring"
    ]
  },
  {
    icon: CodeIcon,
    title: "Custom Software Development",
    description: "Bespoke software solutions designed to address your specific business challenges and requirements.",
    features: [
      "Enterprise applications",
      "Legacy system modernization",
      "API development and integration",
      "Database design and optimization"
    ]
  },
  {
    icon: BarChartIcon,
    title: "Digital Marketing & SEO",
    description: "Data-driven strategies to increase your online visibility, drive traffic, and convert visitors into customers.",
    features: [
      "Search engine optimization",
      "Content marketing",
      "Social media management",
      "Analytics and reporting"
    ]
  }
];

// Intersection Observer for performance optimization
const servicesGrid = ref(null);
const bottomCta = ref(null);
const visibleCards = ref(Array(services.length).fill(false));
const isCtaVisible = ref(false);

let observers = [];

onMounted(() => {
  // Create observer for service cards
  if (servicesGrid.value) {
    const cardElements = servicesGrid.value.querySelectorAll('.service-card');

    const cardObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const index = Array.from(cardElements).indexOf(entry.target);
          if (index !== -1) {
            visibleCards.value[index] = true;
          }
          cardObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px 50px 0px' });

    cardElements.forEach(card => {
      cardObserver.observe(card);
    });

    observers.push(cardObserver);
  }

  // Create observer for bottom CTA
  if (bottomCta.value) {
    const ctaObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          isCtaVisible.value = true;
          ctaObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    ctaObserver.observe(bottomCta.value);
    observers.push(ctaObserver);
  }
});

// Clean up observers on component unmount
onUnmounted(() => {
  observers.forEach(observer => observer.disconnect());
  observers = [];
});
</script>

<style scoped>
/* Base styles for service cards */
.service-card {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
  contain: content; /* CSS containment for performance */
}

/* Apply animation only when card becomes visible */
.service-card.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Staggered animation delay based on card index */
.service-card:nth-child(1).is-visible { transition-delay: 0ms; }
.service-card:nth-child(2).is-visible { transition-delay: 100ms; }
.service-card:nth-child(3).is-visible { transition-delay: 200ms; }
.service-card:nth-child(4).is-visible { transition-delay: 300ms; }
.service-card:nth-child(5).is-visible { transition-delay: 400ms; }
.service-card:nth-child(6).is-visible { transition-delay: 500ms; }

/* Icon wrapper transition */
.service-icon-wrapper {
  transition: transform 0.3s ease;
  will-change: transform; /* Hint for browser optimization */
}

.service-card:hover .service-icon-wrapper {
  transform: scale(1.1);
}

/* Bottom CTA animation */
.mt-16 {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
  transition-delay: 600ms;
}

.mt-16.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Ensure all cards have the same height */
.service-card > div {
  display: flex;
  flex-direction: column;
  height: 100%;
}

/* Reduce animations for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
  .service-card,
  .mt-16 {
    transition: none;
    opacity: 1;
    transform: none;
  }

  .service-card:hover .service-icon-wrapper {
    transform: none;
  }
}
</style>
