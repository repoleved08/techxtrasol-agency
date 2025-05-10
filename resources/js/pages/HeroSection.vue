<template>
  <section
    class="tech-hero relative overflow-hidden"
    aria-label="TechXtraSol - Technology Solutions"
  >
    <!-- Simplified background with CSS instead of DOM elements -->
    <div class="hero-background"></div>

    <!-- Main content with explicit dimensions to prevent layout shifts -->
    <div class="container relative z-10 mx-auto px-4 py-20 md:py-32">
      <div class="flex flex-col items-center lg:flex-row lg:items-start lg:justify-between">
        <!-- Left content with pre-allocated space -->
        <div class="mb-12 max-w-2xl lg:mb-0 lg:max-w-xl">
          <!-- Agency logo with explicit dimensions -->
          <div class="mb-8 inline-flex h-14">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10">
              <div class="relative h-8 w-8">
                <span class="absolute inset-0 ping-animation rounded-full bg-primary/30"></span>
                <CodeIcon class="relative h-8 w-8 text-primary" />
              </div>
            </div>
            <div class="ml-3 flex flex-col justify-center">
              <span class="text-xl font-bold tracking-tight">TechXtraSol</span>
              <span class="text-xs text-muted-foreground">Technology Solutions</span>
            </div>
          </div>

          <!-- Simplified tagline without excessive animations -->
          <h1 class="mb-6 text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
            <span>Innovate.</span>
            <span class="bg-gradient-to-r from-primary to-primary/70 bg-clip-text text-transparent">Create.</span>
            <span>Elevate.</span>
          </h1>

          <!-- Description with SEO-optimized content -->
          <p class="mb-8 text-lg text-muted-foreground">
            Transforming ideas into exceptional digital experiences. We build cutting-edge web development, mobile applications, and AI solutions that help businesses thrive in the digital landscape.
          </p>

          <!-- CTA buttons with simplified interactions -->
          <div class="flex flex-wrap gap-4">
            <Button @click="scrollToContactUs" size="lg" class="group relative overflow-hidden">
              <span class="relative z-10">Contact Us</span>
              <ArrowRightIcon class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" />
            </Button>

            <Button @click="scrollToPortfolio" size="lg" variant="outline" class="group">
              <span>Our Work</span>
              <EyeIcon class="ml-2 h-5 w-5" />
            </Button>
          </div>

          <!-- Stats with static initial values and lazy animation -->
          <div class="mt-12 grid grid-cols-3 gap-4">
            <div class="stat-item">
              <div class="text-2xl font-bold">
                <span ref="projectsCounter">100+</span>
              </div>
              <div class="text-sm text-muted-foreground">Projects</div>
            </div>

            <div class="stat-item">
              <div class="text-2xl font-bold">
                <span ref="clientsCounter">50+</span>
              </div>
              <div class="text-sm text-muted-foreground">Clients</div>
            </div>

            <div class="stat-item">
              <div class="text-2xl font-bold">
                <span ref="yearsCounter">5+</span>
              </div>
              <div class="text-sm text-muted-foreground">Years</div>
            </div>
          </div>
        </div>

        <!-- Right content with explicit dimensions -->
        <div class="feature-cards-container w-full max-w-lg">
          <div
            v-for="(feature, index) in features"
            :key="feature.title"
            class="feature-card group"
          >
            <div class="feature-icon-wrapper">
              <component :is="feature.icon" class="h-5 w-5 text-primary-foreground" />
            </div>
            <div>
              <h3 class="mb-1 text-base font-semibold">{{ feature.title }}</h3>
              <p class="text-sm text-muted-foreground">{{ feature.description }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Simplified scroll indicator -->
      <div class="absolute bottom-8 left-1/2 flex -translate-x-1/2 flex-col items-center">
        <span class="mb-2 text-sm text-muted-foreground">Scroll to explore</span>
        <ChevronDownIcon class="h-5 w-5 animate-bounce text-muted-foreground" />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { useIntersectionObserver } from '@vueuse/core';
import { Button } from '@/components/ui/button';
import {
  CodeIcon,
  ArrowRightIcon,
  EyeIcon,
  ChevronDownIcon,
  GlobeIcon,
  BrainCircuitIcon,
  RocketIcon,
  SmartphoneIcon
} from 'lucide-vue-next';

// Feature data with SEO-optimized descriptions
const features = [
  {
    title: 'Web Development',
    description: 'Custom websites and web applications built with modern technologies like Vue, React, and Node.js.',
    icon: GlobeIcon
  },
  {
    title: 'Mobile Applications',
    description: 'Native and cross-platform mobile apps for iOS and Android using React Native and Flutter.',
    icon: SmartphoneIcon
  },
  {
    title: 'AI Integration',
    description: 'Implementing artificial intelligence and machine learning solutions for business growth and automation.',
    icon: BrainCircuitIcon
  },
  {
    title: 'Digital Marketing',
    description: 'Strategic SEO, content marketing, and social media campaigns to boost your online presence.',
    icon: RocketIcon
  }
];

// Scroll functions with passive event listeners
const scrollToPortfolio = () => {
  const section = document.getElementById('portfolio-section');
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
  }
};

const scrollToContactUs = () => {
  const section = document.getElementById('contact-section');
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
  }
};

// Optimized counter implementation with Intersection Observer
const projectsCounter = ref(null);
const clientsCounter = ref(null);
const yearsCounter = ref(null);

// Only animate counters when they're visible
onMounted(() => {
  const animateCounter = (element, endValue, duration = 2000) => {
    let startTime = null;
    const startValue = 0;

    const step = (timestamp) => {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      const currentValue = Math.floor(progress * (endValue - startValue) + startValue);

      element.textContent = `${currentValue}+`;

      if (progress < 1) {
        window.requestAnimationFrame(step);
      }
    };

    window.requestAnimationFrame(step);
  };

  // Use Intersection Observer to only animate when visible
  nextTick(() => {
    if (projectsCounter.value && clientsCounter.value && yearsCounter.value) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            if (entry.target === projectsCounter.value) {
              animateCounter(projectsCounter.value, 100);
            } else if (entry.target === clientsCounter.value) {
              animateCounter(clientsCounter.value, 50);
            } else if (entry.target === yearsCounter.value) {
              animateCounter(yearsCounter.value, 5);
            }
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      observer.observe(projectsCounter.value);
      observer.observe(clientsCounter.value);
      observer.observe(yearsCounter.value);
    }
  });
});
</script>

<style scoped>
/* Base styles with optimized CSS */
.tech-hero {
  min-height: 100vh;
  position: relative;
  overflow: hidden;
  background-color: hsl(var(--background));
  color: hsl(var(--foreground));
  contain: content; /* CSS containment for performance */
}

/* Use CSS for background instead of DOM elements */
.hero-background {
  position: absolute;
  inset: 0;
  background:
    radial-gradient(circle at 50% 50%, hsl(var(--primary) / 0.05) 0%, transparent 70%),
    linear-gradient(to right, hsl(var(--border) / 0.1) 1px, transparent 1px) 0 0 / 40px 40px,
    linear-gradient(to bottom, hsl(var(--border) / 0.1) 1px, transparent 1px) 0 0 / 40px 40px;
  mask-image: radial-gradient(circle at 50% 50%, black 0%, transparent 80%);
}

/* Optimized animation */
.ping-animation {
  animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
}

@keyframes ping {
  75%, 100% {
    transform: scale(2);
    opacity: 0;
  }
}

/* Feature cards with content-visibility optimization */
.feature-cards-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  content-visibility: auto;
  contain-intrinsic-size: 0 500px; /* Hint for browser about size */
}

.feature-card {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.25rem;
  border-radius: 0.75rem;
  background-color: hsl(var(--card));
  border: 1px solid hsl(var(--border));
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px -5px hsl(var(--primary) / 0.1),
              0 8px 10px -6px hsl(var(--primary) / 0.1);
  border-color: hsl(var(--primary) / 0.3);
}

.feature-icon-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 0.5rem;
  background-color: hsl(var(--primary));
  flex-shrink: 0;
}

/* Stats styling with fixed dimensions */
.stat-item {
  padding: 0.75rem;
  border-radius: 0.5rem;
  background-color: hsl(var(--card) / 0.5);
  border: 1px solid hsl(var(--border));
  text-align: center;
  height: 80px; /* Fixed height to prevent layout shifts */
  display: flex;
  flex-direction: column;
  justify-content: center;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
  .feature-cards-container {
    margin-top: 2rem;
  }
}

@media (max-width: 768px) {
  .feature-cards-container {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  .stat-item {
    padding: 0.5rem;
  }
}

/* Reduce animations for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
  .ping-animation,
  .animate-bounce {
    animation: none;
  }

  .feature-card:hover {
    transform: none;
  }
}
</style>
