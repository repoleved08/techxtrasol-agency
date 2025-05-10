<template>
  <section
    class="py-20 bg-background relative overflow-hidden"
    aria-labelledby="testimonials-heading"
  >
    <!-- Background Elements - Simplified and optimized -->
    <div class="absolute inset-0 pointer-events-none opacity-5">
      <MessageCircleIcon class="absolute top-20 left-10 w-64 h-64" />
      <QuoteIcon class="absolute bottom-20 right-10 w-64 h-64" />
    </div>

    <div class="container px-4 mx-auto relative">
      <!-- Section Header -->
      <div class="text-center mb-16 max-w-2xl mx-auto">
        <h2 id="testimonials-heading" class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
          What Our <span class="text-primary">Clients</span> Say
        </h2>
        <p class="text-muted-foreground">
          Don't just take our word for it. Here's what our clients have to say about working with TechXtraSol.
        </p>
      </div>

      <!-- Marquee Testimonials with Intersection Observer -->
      <div
        ref="marqueeContainer"
        class="testimonial-marquee-container relative"
        @mouseenter="pauseMarquee"
        @mouseleave="resumeMarquee"
      >
        <!-- Enhanced Gradient Overlays -->
        <div class="absolute left-0 top-0 bottom-0 w-[120px] z-10 bg-gradient-to-r from-background via-background/90 to-transparent pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-[120px] z-10 bg-gradient-to-l from-background via-background/90 to-transparent pointer-events-none"></div>

        <!-- First Marquee Row (Left to Right) -->
        <div
          class="testimonial-marquee"
          :style="{ animationPlayState: isPaused ? 'paused' : 'running' }"
          aria-live="off"
        >
          <div
            v-for="(testimonial, index) in firstRowTestimonials"
            :key="`row1-${index}`"
            class="testimonial-card"
            :class="{ 'is-visible': visibleCards[0][index] }"
          >
            <div class="bg-card rounded-xl p-8 shadow-md border border-border transition-all duration-300 hover:shadow-lg hover:border-primary/20 w-[350px] md:w-[400px] mx-4 h-full">
              <!-- Quote Icon -->
              <div class="mb-6 text-primary">
                <QuoteIcon class="h-8 w-8" aria-hidden="true" />
              </div>

              <!-- Testimonial Content -->
              <div class="mb-6">
                <div class="flex mb-4" :aria-label="'Rating: ' + testimonial.rating + ' out of 5 stars'">
                  <div v-for="i in 5" :key="i" class="mr-1">
                    <StarIcon
                      class="h-4 w-4"
                      :class="i <= testimonial.rating ? 'text-yellow-500 fill-yellow-500' : 'text-muted'"
                      aria-hidden="true"
                    />
                  </div>
                </div>
                <p class="italic text-muted-foreground mb-4">{{ testimonial.content }}</p>
              </div>

              <!-- Client Info -->
              <div class="flex items-center">
                <div class="client-avatar mr-4 relative">
                  <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                    <component :is="testimonial.icon" class="h-6 w-6 text-primary" aria-hidden="true" />
                  </div>
                  <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-card p-1 flex items-center justify-center border border-border">
                    <component :is="testimonial.companyIcon" class="h-3 w-3 text-muted-foreground" aria-hidden="true" />
                  </div>
                </div>
                <div>
                  <h3 class="font-semibold text-sm">{{ testimonial.name }}</h3>
                  <p class="text-xs text-muted-foreground">{{ testimonial.position }}, {{ testimonial.company }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Second Marquee Row (Right to Left) - Reverse Direction -->
        <div
          class="testimonial-marquee-reverse mt-8"
          :style="{ animationPlayState: isPaused ? 'paused' : 'running' }"
          aria-live="off"
        >
          <div
            v-for="(testimonial, index) in secondRowTestimonials"
            :key="`row2-${index}`"
            class="testimonial-card"
            :class="{ 'is-visible': visibleCards[1][index] }"
          >
            <div class="bg-card rounded-xl p-8 shadow-md border border-border transition-all duration-300 hover:shadow-lg hover:border-primary/20 w-[350px] md:w-[400px] mx-4 h-full">
              <!-- Quote Icon -->
              <div class="mb-6 text-primary">
                <QuoteIcon class="h-8 w-8" aria-hidden="true" />
              </div>

              <!-- Testimonial Content -->
              <div class="mb-6">
                <div class="flex mb-4" :aria-label="'Rating: ' + testimonial.rating + ' out of 5 stars'">
                  <div v-for="i in 5" :key="i" class="mr-1">
                    <StarIcon
                      class="h-4 w-4"
                      :class="i <= testimonial.rating ? 'text-yellow-500 fill-yellow-500' : 'text-muted'"
                      aria-hidden="true"
                    />
                  </div>
                </div>
                <p class="italic text-muted-foreground mb-4">{{ testimonial.content }}</p>
              </div>

              <!-- Client Info -->
              <div class="flex items-center">
                <div class="client-avatar mr-4 relative">
                  <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                    <component :is="testimonial.icon" class="h-6 w-6 text-primary" aria-hidden="true" />
                  </div>
                  <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-card p-1 flex items-center justify-center border border-border">
                    <component :is="testimonial.companyIcon" class="h-3 w-3 text-muted-foreground" aria-hidden="true" />
                  </div>
                </div>
                <div>
                  <h3 class="font-semibold text-sm">{{ testimonial.name }}</h3>
                  <p class="text-xs text-muted-foreground">{{ testimonial.position }}, {{ testimonial.company }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Auto-scroll indicator -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 flex items-center gap-2 text-xs text-muted-foreground py-2 z-20">
          <span v-if="!isPaused" class="inline-flex items-center">
            <PlayIcon class="h-3 w-3 mr-1" aria-hidden="true" /> Auto-scrolling
          </span>
          <span v-else class="inline-flex items-center">
            <PauseIcon class="h-3 w-3 mr-1" aria-hidden="true" /> Paused
          </span>
        </div>
      </div>

      <!-- Call to Action -->
      <div
        class="mt-16 text-center"
        ref="ctaSection"
        :class="{ 'is-visible': isCtaVisible }"
      >
        <a
          href="#"
          class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-6 py-2 cta-button"
        >
          <MessageSquareIcon class="mr-2 h-4 w-4" aria-hidden="true" />
          Read More Success Stories
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import {
  QuoteIcon, StarIcon, ChevronLeftIcon, ChevronRightIcon,
  UserIcon, BuildingIcon, GlobeIcon, ShoppingCartIcon,
  HeartPulseIcon, BriefcaseIcon, MessageCircleIcon,
  BarChartIcon, ServerIcon, SmartphoneIcon, PlayIcon, PauseIcon,
  MessageSquareIcon
} from 'lucide-vue-next';

// Testimonials data - memoized to avoid re-renders
const testimonials = [
  {
    name: "Sarah Johnson",
    position: "CTO",
    company: "HealthTech Innovations",
    content: "TechXtraSol transformed our outdated platform into a modern, user-friendly system. Their team was professional, responsive, and delivered beyond our expectations.",
    rating: 5,
    icon: UserIcon,
    companyIcon: HeartPulseIcon
  },
  {
    name: "Michael Chen",
    position: "VP of Digital",
    company: "Global Finance Group",
    content: "Working with TechXtraSol was a game-changer for our digital transformation initiative. They understood our complex requirements and delivered a secure, scalable solution.",
    rating: 5,
    icon: UserIcon,
    companyIcon: BarChartIcon
  },
  {
    name: "Jessica Williams",
    position: "E-commerce Director",
    company: "Retail Innovations",
    content: "The e-commerce platform developed by TechXtraSol exceeded our expectations. The intuitive design and seamless checkout process have resulted in a 40% increase in conversion rates.",
    rating: 4,
    icon: UserIcon,
    companyIcon: ShoppingCartIcon
  },
  {
    name: "David Rodriguez",
    position: "CIO",
    company: "Enterprise Solutions Inc.",
    content: "TechXtraSol's expertise in cloud migration was invaluable. They helped us modernize our infrastructure while ensuring zero downtime.",
    rating: 5,
    icon: UserIcon,
    companyIcon: ServerIcon
  },
  {
    name: "Emily Zhang",
    position: "Product Manager",
    company: "MobileTech Solutions",
    content: "The mobile application developed by TechXtraSol has received outstanding feedback from our users. Their attention to detail and focus on user experience resulted in an app that performs exceptionally well.",
    rating: 5,
    icon: UserIcon,
    companyIcon: SmartphoneIcon
  },
  {
    name: "Robert Thompson",
    position: "Marketing Director",
    company: "Global Brands Inc.",
    content: "TechXtraSol's SEO and digital marketing services have transformed our online presence. Within three months, we saw a 200% increase in organic traffic.",
    rating: 4,
    icon: UserIcon,
    companyIcon: GlobeIcon
  }
];

// Split testimonials into two rows for better performance
const firstRowTestimonials = computed(() => testimonials.slice(0, 3));
const secondRowTestimonials = computed(() => [...testimonials.slice(3)].reverse());

// Marquee state
const marqueeContainer = ref(null);
const ctaSection = ref(null);
const isPaused = ref(false);
const visibleCards = ref([
  Array(firstRowTestimonials.value.length).fill(false),
  Array(secondRowTestimonials.value.length).fill(false)
]);
const isCtaVisible = ref(false);

// Marquee control functions
const pauseMarquee = () => {
  isPaused.value = true;
};

const resumeMarquee = () => {
  isPaused.value = false;
};

// Intersection Observer for performance optimization
let observers = [];

onMounted(() => {
  // Setup intersection observers for lazy animations
  setupIntersectionObservers();

  // Use requestIdleCallback for non-critical initialization
  if ('requestIdleCallback' in window) {
    window.requestIdleCallback(() => {
      initializeMarquee();
    });
  } else {
    // Fallback for browsers that don't support requestIdleCallback
    setTimeout(initializeMarquee, 200);
  }
});

onUnmounted(() => {
  // Clean up observers
  observers.forEach(observer => observer.disconnect());
  observers = [];
});

// Initialize marquee with performance optimizations
const initializeMarquee = () => {
  // Reduce DOM queries by caching elements
  const firstRowCards = document.querySelectorAll('.testimonial-marquee .testimonial-card');
  const secondRowCards = document.querySelectorAll('.testimonial-marquee-reverse .testimonial-card');

  // Clone cards for infinite scrolling without excessive DOM elements
  const firstRowContainer = document.querySelector('.testimonial-marquee');
  const secondRowContainer = document.querySelector('.testimonial-marquee-reverse');

  if (firstRowContainer && firstRowCards.length > 0) {
    // Clone only what's needed for continuous scrolling
    const clones = Array.from(firstRowCards).map(card => card.cloneNode(true));
    clones.forEach(clone => firstRowContainer.appendChild(clone));
  }

  if (secondRowContainer && secondRowCards.length > 0) {
    // Clone only what's needed for continuous scrolling
    const clones = Array.from(secondRowCards).map(card => card.cloneNode(true));
    clones.forEach(clone => secondRowContainer.appendChild(clone));
  }
};

// Setup intersection observers for lazy animations
const setupIntersectionObservers = () => {
  // Observer for first row cards
  const firstRowCards = document.querySelectorAll('.testimonial-marquee .testimonial-card');
  if (firstRowCards.length > 0) {
    const firstRowObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const index = Array.from(firstRowCards).indexOf(entry.target);
          if (index !== -1 && index < visibleCards.value[0].length) {
            visibleCards.value[0][index] = true;
          }
          firstRowObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    firstRowCards.forEach(card => {
      firstRowObserver.observe(card);
    });

    observers.push(firstRowObserver);
  }

  // Observer for second row cards
  const secondRowCards = document.querySelectorAll('.testimonial-marquee-reverse .testimonial-card');
  if (secondRowCards.length > 0) {
    const secondRowObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const index = Array.from(secondRowCards).indexOf(entry.target);
          if (index !== -1 && index < visibleCards.value[1].length) {
            visibleCards.value[1][index] = true;
          }
          secondRowObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    secondRowCards.forEach(card => {
      secondRowObserver.observe(card);
    });

    observers.push(secondRowObserver);
  }

  // Observer for CTA section
  if (ctaSection.value) {
    const ctaObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          isCtaVisible.value = true;
          ctaObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    ctaObserver.observe(ctaSection.value);
    observers.push(ctaObserver);
  }
};
</script>

<style scoped>
.testimonial-marquee-container {
  position: relative;
  overflow: hidden;
  padding: 20px 0 40px 0;
  contain: content; /* CSS containment for performance */
}

/* Optimized Marquee Animation */
.testimonial-marquee {
  display: flex;
  animation: marquee 60s linear infinite;
  will-change: transform;
  contain: layout style; /* Optimize rendering */
}

.testimonial-marquee-reverse {
  display: flex;
  animation: marquee-reverse 50s linear infinite;
  will-change: transform;
  contain: layout style; /* Optimize rendering */
}

@keyframes marquee {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%); /* Only animate to half for better performance */
  }
}

@keyframes marquee-reverse {
  0% {
    transform: translateX(-50%); /* Only animate to half for better performance */
  }
  100% {
    transform: translateX(0);
  }
}

.testimonial-card {
  flex: 0 0 auto;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  opacity: 0;
  transform: translateY(10px);
  content-visibility: auto; /* Modern browsers will optimize rendering */
  contain-intrinsic-size: 0 300px; /* Hint for browser about size */
}

.testimonial-card.is-visible {
  opacity: 1;
  transform: translateY(0);
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
}

/* Staggered animation delay */
.testimonial-marquee .testimonial-card:nth-child(1).is-visible { transition-delay: 0ms; }
.testimonial-marquee .testimonial-card:nth-child(2).is-visible { transition-delay: 100ms; }
.testimonial-marquee .testimonial-card:nth-child(3).is-visible { transition-delay: 200ms; }

.testimonial-marquee-reverse .testimonial-card:nth-child(1).is-visible { transition-delay: 100ms; }
.testimonial-marquee-reverse .testimonial-card:nth-child(2).is-visible { transition-delay: 200ms; }
.testimonial-marquee-reverse .testimonial-card:nth-child(3).is-visible { transition-delay: 300ms; }

.testimonial-card:hover {
  transform: translateY(-5px);
  z-index: 10;
}

/* Simplified animation for client avatar */
.client-avatar {
  transition: transform 0.3s ease;
}

.testimonial-card:hover .client-avatar {
  transform: scale(1.05);
}

/* Ensure all cards have the same height */
.testimonial-card > div {
  display: flex;
  flex-direction: column;
  height: 100%;
}

/* CTA animation */
.mt-16 {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
}

.mt-16.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Optimized CTA button effect */
.cta-button {
  position: relative;
  overflow: hidden;
}

.cta-button::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 5px;
  height: 5px;
  background: rgba(255, 255, 255, 0.5);
  opacity: 0;
  border-radius: 100%;
  transform: scale(1, 1) translate(-50%);
  transform-origin: 50% 50%;
}

.cta-button:hover::after {
  animation: ripple 1s ease-out;
}

@keyframes ripple {
  0% {
    transform: scale(0, 0);
    opacity: 0.5;
  }
  100% {
    transform: scale(20, 20);
    opacity: 0;
  }
}

/* Reduce animations for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
  .testimonial-marquee,
  .testimonial-marquee-reverse {
    animation: none;
  }

  .testimonial-card,
  .mt-16 {
    transition: none;
    opacity: 1;
    transform: none;
  }

  .testimonial-card:hover {
    transform: none;
  }

  .client-avatar {
    animation: none;
  }

  .cta-button:hover::after {
    animation: none;
  }
}
</style>
