<template>
  <section class="py-20 bg-primary/5 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
      <div
        class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
      </div>
      <div
        class="absolute bottom-0 left-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
      </div>
    </div>

    <div class="container px-4 mx-auto relative">
      <div class="max-w-4xl mx-auto bg-card rounded-2xl shadow-lg border border-border overflow-hidden">
        <div class="grid md:grid-cols-2 gap-0">
          <!-- Left Section -->
          <div class="bg-muted p-8 md:p-10 flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>
            <div class="relative z-10 text-center md:text-left">
              <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary/20 mb-6 cta-icon-container">
                <RocketIcon class="h-10 w-10 text-primary" />
              </div>
              <h3 class="text-2xl font-bold mb-4">Ready to Launch?</h3>
              <p class="text-muted-foreground">
                We've helped over 200+ businesses transform their digital presence.
              </p>
            </div>
          </div>

          <!-- Right Section -->
          <div class="p-8 md:p-10 flex flex-col justify-center">
            <h2 class="text-3xl font-bold mb-4 cta-title">
              Let's Build Something <span class="text-primary">Amazing</span> Together
            </h2>
            <p class="text-muted-foreground mb-8">
              Take the first step towards transforming your business with cutting-edge technology solutions tailored to
              your needs.
            </p>

            <div class="space-y-4">
              <button @click="goTo('consultation')"
                class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-6 py-2 cta-button">
                Schedule a Free Consultation
                <CalendarIcon class="ml-2 h-5 w-5" />
              </button>

              <button @click="scrollToPortfolio"
                class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-11 px-6 py-2">
                View Our Portfolio
                <ArrowRightIcon class="ml-2 h-5 w-5" />
              </button>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { RocketIcon, CalendarIcon, ArrowRightIcon } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3'

const goTo = (routeName) => {
  switch (routeName) {
    case 'consultation':
      router.visit('/agency/consultation')
      break
    case 'case-studies':
      router.visit('/case-studies/sample-slug') // Replace with a real slug or listing page route
      break
    default:
      break
  }
}

const scrollToPortfolio = () => {
  const section = document.getElementById('portfolio-section');
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>

<style scoped>
.cta-title {
  animation: fadeInUp 0.8s ease-out forwards;
}

.cta-button {
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
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

.cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}

.cta-icon-container {
  animation: float 3s ease-in-out infinite;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes float {

  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-10px);
  }
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
</style>
