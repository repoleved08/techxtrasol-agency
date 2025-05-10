<template>

  <Head title="About Us" />
  <PublicLayout>
    <div class="bg-background min-h-screen relative">
      <!-- Animated background with 3D particles -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particles-container" ref="particlesContainer"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-background/0 via-background/50 to-background"></div>
      </div>

      <!-- Hero Section with 3D Card Effect -->
      <section class="relative py-20 md:py-32 overflow-hidden">
        <div class="container mx-auto px-4 relative">
          <div class="max-w-4xl mx-auto">
            <!-- 3D Tilt Card with Glassmorphism -->
            <div ref="tiltCard"
              class="tilt-card bg-card/60 backdrop-blur-xl border border-border/50 rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden">
              <!-- Animated Glow Effects -->
              <div class="absolute -top-20 -left-20 w-40 h-40 bg-primary/20 rounded-full blur-3xl animate-pulse-slow">
              </div>
              <div
                class="absolute -bottom-20 -right-20 w-40 h-40 bg-secondary/20 rounded-full blur-3xl animate-pulse-slow animation-delay-1000">
              </div>

              <div class="relative z-10">
                <!-- Company Logo with Morphing Animation -->
                <div class="flex justify-center mb-8">
                  <div class="relative w-20 h-20">
                    <div class="absolute inset-0 bg-primary/20 rounded-2xl blur-xl animate-pulse-slow"></div>
                    <div
                      class="morph-logo relative bg-gradient-to-br from-primary to-secondary rounded-2xl p-5 shadow-lg">
                      <CodeIcon class="h-full w-full text-white" />
                    </div>
                  </div>
                </div>

                <!-- Redesigned Text Animation Section -->
                <div class="animated-heading-container text-center mb-12">
                  <!-- Main Heading with Letter-by-Letter Animation -->
                  <h1 class="relative mb-6">
                    <span class="sr-only">Innovate. Create. Elevate.</span>
                    <span aria-hidden="true" class="heading-wrapper block overflow-hidden">
                      <span class="word-container inline-block relative">
                        <span v-for="(letter, i) in 'Innovate.'" :key="`i-${i}`" class="letter-animate inline-block"
                          :style="{ animationDelay: `${i * 60 + 100}ms` }">
                          {{ letter }}
                        </span>
                      </span>
                      <span class="word-container inline-block relative mx-2">
                        <span v-for="(letter, i) in 'Create.'" :key="`c-${i}`"
                          class="letter-animate inline-block gradient-text"
                          :style="{ animationDelay: `${i * 60 + 600}ms` }">
                          {{ letter }}
                        </span>
                      </span>
                      <span class="word-container inline-block relative">
                        <span v-for="(letter, i) in 'Elevate.'" :key="`e-${i}`" class="letter-animate inline-block"
                          :style="{ animationDelay: `${i * 60 + 1100}ms` }">
                          {{ letter }}
                        </span>
                      </span>
                    </span>
                  </h1>

                  <!-- Paragraph with Line-by-Line Animation -->
                  <div class="paragraph-container relative max-w-2xl mx-auto overflow-hidden">
                    <p class="sr-only">
                      At TechXtraSol, we empower local businesses in Kenya and across the globe to achieve digital
                      excellence through innovative, scalable web solutions that drive growth and recognition.
                    </p>

                    <div aria-hidden="true" class="line-container overflow-hidden mb-2">
                      <span class="line-animate block">
                        At TechXtraSol, we empower local businesses in Kenya
                      </span>
                    </div>
                    <div aria-hidden="true" class="line-container overflow-hidden mb-2">
                      <span class="line-animate block" style="animation-delay: 200ms">
                        and across the globe to achieve digital excellence
                      </span>
                    </div>
                    <div aria-hidden="true" class="line-container overflow-hidden">
                      <span class="line-animate block" style="animation-delay: 400ms">
                        through innovative, scalable web solutions that drive growth.
                      </span>
                    </div>
                  </div>

                  <!-- Animated Accent Line -->
                  <div class="accent-line-container">
                    <div class="accent-line"></div>
                  </div>
                </div>


                <!-- Interactive Stats with Counting Animation -->
                <div class="grid grid-cols-3 gap-4 mt-10">
                  <div v-for="(stat, index) in stats" :key="index"
                    class="stat-card bg-background/50 backdrop-blur-sm border border-border/50 rounded-xl p-4 text-center hover:bg-background/80 transition-all duration-300 hover:scale-105 hover:shadow-lg"
                    @mouseenter="startCounting(index)">
                    <div class="text-2xl md:text-3xl font-bold text-primary mb-1">
                      <span ref="countRefs">0</span>{{ stat.suffix }}
                    </div>
                    <div class="text-xs text-muted-foreground">{{ stat.label }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="flex justify-center mt-12">
              <div class="scroll-indicator">
                <div class="scroll-dot"></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Core Values Section with Interactive Cards -->
      <section class="py-20 relative">
        <div class="container mx-auto px-4">
          <div class="max-w-5xl mx-auto">
            <!-- Section Header with Animated Underline -->
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold relative inline-block">
                Our Core <span class="text-primary">Values</span>
                <div class="animated-underline"></div>
              </h2>
            </div>

            <!-- Interactive 3D Cards -->
            <div class="grid md:grid-cols-3 gap-8">
              <div v-for="(value, index) in coreValues" :key="index" class="value-card-wrapper">
                <div class="value-card relative h-full">
                  <!-- Card Front -->
                  <div
                    class="value-card-front bg-card border border-border rounded-2xl p-6 h-full flex flex-col items-center text-center">
                    <div class="icon-container mb-6">
                      <div class="icon-background"></div>
                      <component :is="value.icon" class="h-8 w-8 text-primary relative z-10" />
                    </div>
                    <h3 class="text-xl font-semibold mb-3">{{ value.title }}</h3>
                    <p class="text-muted-foreground text-sm">{{ value.description }}</p>
                    <div class="mt-4 text-primary text-sm font-medium cursor-pointer hover:underline">Learn more</div>
                  </div>

                  <!-- Card Back -->
                  <div
                    class="value-card-back bg-gradient-to-br from-primary/10 to-secondary/10 backdrop-blur-sm border border-primary/20 rounded-2xl p-6 h-full flex flex-col items-center justify-center text-center">
                    <component :is="value.icon" class="h-10 w-10 text-primary mb-4" />
                    <h3 class="text-xl font-semibold mb-3">{{ value.title }}</h3>
                    <p class="text-muted-foreground">{{ value.extendedDescription }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Vision Section with Parallax Scrolling -->
      <section class="vision-section py-20 relative overflow-hidden">
        <!-- Parallax Background Elements -->
        <div class="parallax-container">
          <div class="parallax-layer layer-1"></div>
          <div class="parallax-layer layer-2"></div>
          <div class="parallax-layer layer-3"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
          <div class="grid md:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">
            <!-- Left: Vision Content -->
            <div class="vision-content">
              <div class="inline-flex items-center mb-4 bg-primary/10 px-3 py-1.5 rounded-full">
                <EyeIcon class="h-4 w-4 text-primary mr-2 eye-blink" />
                <span class="text-sm font-medium text-primary">Our Vision</span>
              </div>

              <h2 class="text-3xl md:text-4xl font-bold mb-6 vision-title">
                Bridging the Digital Divide
              </h2>

              <p class="text-muted-foreground mb-8 vision-text">
                We envision a world where businesses of all sizes have access to world-class digital solutions that
                drive growth and foster innovation, regardless of their location.
              </p>

              <!-- Interactive Globe Counter -->
              <div class="globe-counter flex items-center">
                <div class="globe-container mr-4">
                  <div class="globe">
                    <div class="globe-sphere">
                      <div class="globe-worldmap"></div>
                    </div>
                    <div class="globe-ring"></div>
                  </div>
                </div>
                <p class="text-sm font-medium">Serving clients in <span class="text-primary font-bold counter"
                    ref="countriesCounter">0</span>+ countries</p>
              </div>
            </div>

            <!-- Right: Interactive Image Gallery -->
            <div class="image-gallery">
              <div class="gallery-main">
                <img
                  src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                  alt="TechXtraSol team collaboration" class="rounded-2xl shadow-xl" />
                <div class="gallery-caption">
                  <p>Empowering businesses since 2018</p>
                </div>
              </div>

              <div class="gallery-thumbnails">
                <div class="thumbnail active">
                  <img
                    src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                    alt="Team collaboration" />
                </div>
                <div class="thumbnail">
                  <img
                    src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                    alt="Office workspace" />
                </div>
                <div class="thumbnail">
                  <img
                    src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                    alt="Team meeting" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section with Interactive Elements -->
      <section class="py-20 relative overflow-hidden">
        <div class="container mx-auto px-4">
          <div class="cta-card max-w-4xl mx-auto relative">
            <!-- Animated Background -->
            <div class="cta-background"></div>

            <!-- Content -->
            <div class="relative z-10 text-center p-10 md:p-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Transform Your Digital Presence?
              </h2>
              <p class="text-muted-foreground mb-8 max-w-2xl mx-auto">
                Let's collaborate to create innovative solutions that elevate your business.
              </p>

              <div class="flex flex-wrap justify-center gap-6">
                <Button @click="handleSectionClick('contact-section')" class="cta-button primary">
                  <MessageSquareIcon class="mr-2 h-4 w-4" />
                  Contact Us
                </Button>
                <Button variant="outline" class="cta-button secondary">
                  <RocketIcon class="mr-2 h-4 w-4" />
                  Our Services
                </Button>
              </div>

              <!-- Interactive Elements -->
              <div class="cta-interactive-elements">
                <div class="cta-element element-1"></div>
                <div class="cta-element element-2"></div>
                <div class="cta-element element-3"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </PublicLayout>
</template>

<script setup>
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

import { ref, onMounted, onUnmounted } from 'vue';
import {
  CodeIcon,
  EyeIcon,
  LightbulbIcon,
  HeartIcon,
  GlobeIcon,
  MessageSquareIcon,
  RocketIcon,
  ZapIcon,
  UsersIcon,
  ShieldIcon
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import * as THREE from 'three';

// Refs
const particlesContainer = ref(null);
const tiltCard = ref(null);
const countRefs = ref([]);
const countriesCounter = ref(null);

const scrollToSection = (sectionId) => {
  const section = document.getElementById(sectionId);
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
  }
};

const handleSectionClick = (sectionId) => {
  if (window.location.pathname !== '/') {
    Inertia.visit(`/#${sectionId}`, {
      onFinish: () => {
        scrollToSection(sectionId)
      }
    })
  } else {
    scrollToSection(sectionId)
  }
}
// Stats with counting animation
const stats = [
  { value: 5, suffix: '+', label: 'Years Experience' },
  { value: 200, suffix: '+', label: 'Projects Completed' },
  { value: 50, suffix: '+', label: 'Happy Clients' }
];

// Core values with extended descriptions
const coreValues = [
  {
    icon: LightbulbIcon,
    title: 'Innovation',
    description: 'We constantly explore new technologies to deliver cutting-edge solutions.',
    extendedDescription: 'Our team stays at the forefront of technological advancements, ensuring our clients benefit from the latest innovations that drive business growth and efficiency.'
  },
  {
    icon: UsersIcon,
    title: 'Collaboration',
    description: 'We work closely with clients, ensuring their vision is at the heart of every project.',
    extendedDescription: 'We believe in transparent communication and partnership with our clients, creating solutions that truly reflect their unique needs and business goals.'
  },
  {
    icon: HeartIcon,
    title: 'Passion',
    description: "We're driven by our love for technology and its power to transform businesses.",
    extendedDescription: 'Our enthusiasm for creating impactful digital solutions fuels our creativity and commitment to excellence in every project we undertake.'
  }
];




// 3D Particles setup
let scene, camera, renderer, particles;
const initParticles = () => {
  if (!particlesContainer.value) return;

  // Setup
  scene = new THREE.Scene();
  camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
  renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setPixelRatio(window.devicePixelRatio);
  particlesContainer.value.appendChild(renderer.domElement);

  // Create particles
  const particleCount = 100;
  const geometry = new THREE.BufferGeometry();
  const positions = new Float32Array(particleCount * 3);
  const colors = new Float32Array(particleCount * 3);

  for (let i = 0; i < particleCount * 3; i += 3) {
    // Position
    positions[i] = (Math.random() - 0.5) * 10;
    positions[i + 1] = (Math.random() - 0.5) * 10;
    positions[i + 2] = (Math.random() - 0.5) * 10 - 5;

    // Color - theme-aware colors
    const colorIndex = Math.floor(Math.random() * 3);
    if (colorIndex === 0) {
      // Primary color
      colors[i] = 0.6;
      colors[i + 1] = 0.2;
      colors[i + 2] = 0.8;
    } else if (colorIndex === 1) {
      // Secondary color
      colors[i] = 0.8;
      colors[i + 1] = 0.3;
      colors[i + 2] = 0.5;
    } else {
      // Accent color
      colors[i] = 0.4;
      colors[i + 1] = 0.7;
      colors[i + 2] = 0.9;
    }
  }



  geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

  const material = new THREE.PointsMaterial({
    size: 0.1,
    vertexColors: true,
    transparent: true,
    opacity: 0.8
  });

  particles = new THREE.Points(geometry, material);
  scene.add(particles);

  camera.position.z = 5;

  // Animation
  const animate = () => {
    requestAnimationFrame(animate);

    particles.rotation.x += 0.0005;
    particles.rotation.y += 0.001;

    renderer.render(scene, camera);
  };

  animate();

  // Handle resize
  const handleResize = () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  };

  window.addEventListener('resize', handleResize);

  // Cleanup
  return () => {
    window.removeEventListener('resize', handleResize);
    if (particlesContainer.value) {
      particlesContainer.value.removeChild(renderer.domElement);
    }
    geometry.dispose();
    material.dispose();
  };
};

// 3D Tilt effect
const initTiltEffect = () => {
  if (!tiltCard.value) return;

  const card = tiltCard.value;

  const handleMouseMove = (e) => {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    const rotateX = (y - centerY) / 20;
    const rotateY = (centerX - x) / 20;

    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
  };

  const resetTilt = () => {
    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
  };

  card.addEventListener('mousemove', handleMouseMove);
  card.addEventListener('mouseleave', resetTilt);

  // Cleanup
  return () => {
    card.removeEventListener('mousemove', handleMouseMove);
    card.removeEventListener('mouseleave', resetTilt);
  };
};

// Counting animation
const startCounting = (index) => {
  if (!countRefs.value[index]) return;

  const target = stats[index].value;
  const duration = 1500;
  const element = countRefs.value[index];
  const startValue = parseInt(element.textContent);

  if (startValue >= target) return;

  const increment = target / (duration / 16);
  let currentValue = startValue;

  const updateCounter = () => {
    currentValue += increment;
    if (currentValue >= target) {
      element.textContent = target;
    } else {
      element.textContent = Math.floor(currentValue);
      requestAnimationFrame(updateCounter);
    }
  };

  updateCounter();
};

// Countries counter animation
const animateCountriesCounter = () => {
  if (!countriesCounter.value) return;

  const target = 15;
  const duration = 2000;
  const element = countriesCounter.value;
  const startValue = parseInt(element.textContent);

  if (startValue >= target) return;

  const increment = target / (duration / 16);
  let currentValue = startValue;

  const updateCounter = () => {
    currentValue += increment;
    if (currentValue >= target) {
      element.textContent = target;
    } else {
      element.textContent = Math.floor(currentValue);
      requestAnimationFrame(updateCounter);
    }
  };

  updateCounter();
};

// Parallax effect for vision section
const initParallax = () => {
  const handleScroll = () => {
    const scrollY = window.scrollY;
    const visionSection = document.querySelector('.vision-section');

    if (!visionSection) return;

    const sectionTop = visionSection.offsetTop;
    const sectionHeight = visionSection.offsetHeight;

    if (scrollY > sectionTop - window.innerHeight && scrollY < sectionTop + sectionHeight) {
      const layers = document.querySelectorAll('.parallax-layer');
      const relativeScroll = scrollY - (sectionTop - window.innerHeight);
      const percentage = relativeScroll / (sectionHeight + window.innerHeight);

      layers.forEach((layer, index) => {
        const speed = (index + 1) * 0.2;
        const yPos = percentage * speed * 100;
        layer.style.transform = `translateY(${yPos}px)`;
      });
    }
  };

  window.addEventListener('scroll', handleScroll);

  // Cleanup
  return () => {
    window.removeEventListener('scroll', handleScroll);
  };
};

// Text reveal animation
const initTextReveal = () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const elements = entry.target.querySelectorAll('.text-reveal-item');
        elements.forEach((el, index) => {
          setTimeout(() => {
            el.classList.add('revealed');
          }, index * 200);
        });
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  const container = document.querySelector('.text-reveal-container');
  if (container) {
    observer.observe(container);
  }

  // Cleanup
  return () => {
    if (container) {
      observer.unobserve(container);
    }
  };
};

// Initialize all animations
onMounted(() => {
  // Initialize with small delay to ensure DOM is ready
  setTimeout(() => {
    const cleanupParticles = initParticles();
    const cleanupTilt = initTiltEffect();
    const cleanupParallax = initParallax();
    const cleanupTextReveal = initTextReveal();

    // Start countries counter when in view
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCountriesCounter();
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    if (countriesCounter.value) {
      observer.observe(countriesCounter.value);
    }

    // Cleanup function
    onUnmounted(() => {
      cleanupParticles && cleanupParticles();
      cleanupTilt && cleanupTilt();
      cleanupParallax && cleanupParallax();
      cleanupTextReveal && cleanupTextReveal();
      observer.disconnect();
    });
  }, 100);
});
</script>

<style scoped>
/* Base Animations */
@keyframes pulse-slow {

  0%,
  100% {
    opacity: 0.3;
  }

  50% {
    opacity: 0.7;
  }
}

.animated-heading-container {
  padding: 1rem 0;
}

.heading-wrapper {
  font-size: 2.5rem;
  line-height: 1.2;
  font-weight: 800;
  letter-spacing: -0.025em;
}

@media (min-width: 768px) {
  .heading-wrapper {
    font-size: 3.5rem;
  }
}

/* Letter Animation */
.letter-animate {
  opacity: 0;
  transform: translateY(40px) rotate(10deg);
  animation: letterReveal 0.6s cubic-bezier(0.215, 0.61, 0.355, 1) forwards;
}

@keyframes letterReveal {
  0% {
    opacity: 0;
    transform: translateY(40px) rotate(10deg);
  }

  100% {
    opacity: 1;
    transform: translateY(0) rotate(0deg);
  }
}

/* Gradient Text */
.gradient-text {
  background: linear-gradient(to right, hsl(var(--primary)), hsl(var(--secondary)));
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  font-weight: 900;
}

/* Line Animation */
.line-container {
  position: relative;
}

.line-animate {
  opacity: 0;
  transform: translateY(20px);
  animation: lineReveal 0.8s ease forwards;
  animation-delay: 1.5s;
  color: hsl(var(--muted-foreground));
  font-size: 1.125rem;
  line-height: 1.6;
}

@media (min-width: 768px) {
  .line-animate {
    font-size: 1.25rem;
  }
}

@keyframes lineReveal {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }

  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Accent Line */
.accent-line-container {
  position: relative;
  height: 4px;
  width: 100px;
  margin: 2rem auto 0;
  overflow: hidden;
}

.accent-line {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: linear-gradient(to right, hsl(var(--primary)), hsl(var(--secondary)));
  transform: translateX(-100%);
  animation: lineSlide 1.2s ease-in-out forwards;
  animation-delay: 2s;
}

@keyframes lineSlide {
  0% {
    transform: translateX(-100%);
  }

  50% {
    transform: translateX(0);
  }

  75% {
    transform: scaleX(1.2);
  }

  100% {
    transform: scaleX(1);
  }
}

/* Fallback for browsers that don't support animations */
@media (prefers-reduced-motion: reduce) {

  .letter-animate,
  .line-animate,
  .accent-line {
    animation: none !important;
    opacity: 1 !important;
    transform: none !important;
  }
}

.animate-pulse-slow {
  animation: pulse-slow 4s ease-in-out infinite;
}

.animation-delay-1000 {
  animation-delay: 1s;
}

/* Text Reveal Animation */
.text-reveal-item {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.text-reveal-item.revealed {
  opacity: 1;
  transform: translateY(0);
}

/* 3D Tilt Card */
.tilt-card {
  transform-style: preserve-3d;
  transition: transform 0.1s ease-out;
}

/* Morphing Logo Animation */
.morph-logo {
  animation: morph 8s ease-in-out infinite;
}

@keyframes morph {

  0%,
  100% {
    border-radius: 16px;
  }

  25% {
    border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
  }

  50% {
    border-radius: 50%;
  }

  75% {
    border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%;
  }
}

/* Scroll Indicator */
.scroll-indicator {
  width: 30px;
  height: 50px;
  border: 2px solid hsl(var(--primary) / 0.3);
  border-radius: 15px;
  position: relative;
}

.scroll-dot {
  width: 6px;
  height: 6px;
  background-color: hsl(var(--primary));
  border-radius: 50%;
  position: absolute;
  top: 8px;
  left: 50%;
  transform: translateX(-50%);
  animation: scroll-down 2s ease-in-out infinite;
}

@keyframes scroll-down {
  0% {
    top: 8px;
    opacity: 1;
  }

  80% {
    opacity: 0;
  }

  100% {
    top: 32px;
    opacity: 0;
  }
}

/* Animated Underline */
.animated-underline {
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, hsl(var(--primary)), transparent);
  animation: underline-flow 3s ease-in-out infinite;
}

@keyframes underline-flow {
  0% {
    background-position: -200% 0;
  }

  100% {
    background-position: 300% 0;
  }
}

/* Value Cards Flip Effect */
.value-card-wrapper {
  perspective: 1000px;
  height: 300px;
}

.value-card {
  transition: transform 0.8s;
  transform-style: preserve-3d;
  position: relative;
  width: 100%;
  height: 100%;
}

.value-card-wrapper:hover .value-card {
  transform: rotateY(180deg);
}

.value-card-front,
.value-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
}

.value-card-back {
  transform: rotateY(180deg);
}

/* Icon Container Animation */
.icon-container {
  position: relative;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-background {
  position: absolute;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, hsl(var(--primary) / 0.2), transparent);
  border-radius: 50%;
  animation: pulse-icon 3s ease-in-out infinite;
}

@keyframes pulse-icon {

  0%,
  100% {
    transform: scale(0.8);
    opacity: 0.5;
  }

  50% {
    transform: scale(1.2);
    opacity: 0.8;
  }
}

/* Vision Section Parallax */
.vision-section {
  position: relative;
}

.parallax-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.parallax-layer {
  position: absolute;
  width: 100%;
  height: 100%;
  background-size: cover;
  opacity: 0.1;
}

.layer-1 {
  background-image: radial-gradient(circle at 20% 30%, hsl(var(--primary) / 0.4), transparent 70%);
}

.layer-2 {
  background-image: radial-gradient(circle at 70% 60%, hsl(var(--secondary) / 0.4), transparent 70%);
}

.layer-3 {
  background-image: radial-gradient(circle at 40% 80%, hsl(var(--accent) / 0.4), transparent 70%);
}

/* Vision Content Animation */
.vision-title,
.vision-text {
  opacity: 0;
  transform: translateY(20px);
  animation: fade-in-up 0.8s ease-out forwards;
}

.vision-text {
  animation-delay: 0.3s;
}

@keyframes fade-in-up {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Eye Blink Animation */
.eye-blink {
  animation: eye-blink 3s ease-in-out infinite;
}

@keyframes eye-blink {

  0%,
  100% {
    transform: scaleY(1);
  }

  95% {
    transform: scaleY(1);
  }

  97.5% {
    transform: scaleY(0.1);
  }
}

/* Interactive Globe */
.globe-container {
  position: relative;
  width: 60px;
  height: 60px;
}

.globe {
  position: relative;
  width: 100%;
  height: 100%;
  transform-style: preserve-3d;
  animation: globe-rotate 20s linear infinite;
}

.globe-sphere {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: radial-gradient(circle at 30% 30%, hsl(var(--primary) / 0.8), hsl(var(--primary) / 0.2));
  box-shadow: 0 0 20px hsl(var(--primary) / 0.3);
  overflow: hidden;
}

.globe-worldmap {
  position: absolute;
  width: 200%;
  height: 100%;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50' width='200' height='100' opacity='0.3'%3E%3Cpath fill='%23ffffff' d='M10,10 Q30,5 50,15 T90,20 M15,20 Q35,25 55,15 T95,10 M5,30 Q25,35 45,25 T85,30 M10,40 Q30,35 50,45 T90,40'/%3E%3C/svg%3E");
  background-size: cover;
  animation: worldmap-rotate 30s linear infinite;
}

.globe-ring {
  position: absolute;
  width: 120%;
  height: 20%;
  left: -10%;
  top: 40%;
  border-radius: 50%;
  border: 1px solid hsl(var(--primary) / 0.3);
  transform: rotateX(80deg);
}

@keyframes globe-rotate {
  0% {
    transform: rotateY(0deg);
  }

  100% {
    transform: rotateY(360deg);
  }
}

@keyframes worldmap-rotate {
  0% {
    background-position: 0 0;
  }

  100% {
    background-position: 200% 0;
  }
}

/* Image Gallery */
.image-gallery {
  position: relative;
}

.gallery-main {
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.gallery-main img {
  width: 100%;
  height: auto;
  transition: transform 0.5s ease;
}

.gallery-main:hover img {
  transform: scale(1.05);
}

.gallery-caption {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 16px;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
  color: white;
  font-size: 14px;
}

.gallery-thumbnails {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.thumbnail {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
  opacity: 0.6;
  transition: all 0.3s ease;
}

.thumbnail img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.thumbnail.active,
.thumbnail:hover {
  opacity: 1;
  transform: translateY(-5px);
}

.thumbnail.active {
  box-shadow: 0 0 0 2px hsl(var(--primary));
}

/* CTA Section */
.cta-card {
  position: relative;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.cta-background {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, hsl(var(--primary) / 0.1), hsl(var(--secondary) / 0.1));
  backdrop-filter: blur(10px);
  border: 1px solid hsl(var(--primary) / 0.2);
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
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent 70%);
  opacity: 0;
  transform: translate(-50%, -50%) scale(0);
  transition: transform 0.5s ease, opacity 0.5s ease;
}

.cta-button:hover::after {
  opacity: 1;
  transform: translate(-50%, -50%) scale(1);
}

.cta-button.primary {
  background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--secondary)));
  border: none;
}

.cta-button.secondary {
  border-color: hsl(var(--primary) / 0.3);
}

.cta-interactive-elements {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
}

.cta-element {
  position: absolute;
  border-radius: 50%;
  background: radial-gradient(circle, hsl(var(--primary) / 0.3), transparent);
  opacity: 0.5;
}

.element-1 {
  width: 100px;
  height: 100px;
  top: -30px;
  left: 10%;
  animation: float-element 8s ease-in-out infinite;
}

.element-2 {
  width: 150px;
  height: 150px;
  bottom: -50px;
  right: 15%;
  animation: float-element 12s ease-in-out infinite reverse;
}

.element-3 {
  width: 80px;
  height: 80px;
  top: 30%;
  right: -20px;
  animation: float-element 10s ease-in-out infinite 2s;
}

@keyframes float-element {

  0%,
  100% {
    transform: translate(0, 0);
  }

  50% {
    transform: translate(20px, -20px);
  }
}

/* Media Queries */
@media (max-width: 768px) {
  .value-card-wrapper {
    height: 250px;
  }

  .gallery-thumbnails {
    justify-content: center;
  }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {

  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
</style>
