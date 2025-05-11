<template>
  <section class="py-20 bg-background relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-20 left-10 opacity-5">
        <CodeIcon class="w-64 h-64" />
      </div>
      <div class="absolute bottom-20 right-10 opacity-5">
        <ServerIcon class="w-64 h-64" />
      </div>
    </div>

    <div class="container px-4 mx-auto relative">
      <!-- Section Header -->
      <div class="text-center mb-16 max-w-2xl mx-auto">
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
          Our <span class="text-primary">Technology</span> Stack
        </h2>
        <p class="text-muted-foreground">
          We leverage cutting-edge technologies to deliver scalable, robust, and innovative solutions for our clients.
        </p>
      </div>

      <!-- Technology Categories -->
      <div class="mb-12 flex justify-center">
        <div class="inline-flex p-1 bg-muted rounded-lg">
          <button v-for="category in categories" :key="category.id" @click="activeCategory = category.id"
            class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-300" :class="activeCategory === category.id ?
              'bg-background shadow-sm text-foreground' :
              'text-muted-foreground hover:text-foreground'">
            <component :is="category.icon" class="inline-block h-4 w-4 mr-2" />
            {{ category.name }}
          </button>
        </div>
      </div>

      <!-- Featured Technologies Grid -->
      <transition-group name="tech-fade" tag="div" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-16">
        <div v-for="tech in filteredTechnologies" :key="tech.id" class="tech-card group">
          <div
            class="bg-card rounded-xl p-6 border border-border shadow-sm transition-all duration-300 hover:shadow-md hover:border-primary/20 h-full flex flex-col items-center text-center">
            <!-- Logo Container with Hover Effect -->
            <div class="tech-logo-container mb-4 relative">
              <div
                class="w-20 h-20 flex items-center justify-center bg-muted/50 rounded-lg p-4 transition-transform duration-500 group-hover:scale-110">
                <img :src="tech.logo" :alt="tech.name" class="max-w-full max-h-full object-contain" />
              </div>

              <!-- Skill Level Indicator (appears on hover) -->
              <div
                class="skill-indicator absolute -bottom-2 left-1/2 -translate-x-1/2 px-2 py-1 bg-background border border-border rounded-full text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                <span v-if="tech.level === 'expert'" class="text-green-500">Expert</span>
                <span v-else-if="tech.level === 'advanced'" class="text-blue-500">Advanced</span>
                <span v-else class="text-amber-500">Proficient</span>
              </div>
            </div>

            <h3 class="text-lg font-semibold mb-2">{{ tech.name }}</h3>
            <p class="text-sm text-muted-foreground mb-4">{{ tech.description }}</p>

            <!-- Experience Bar -->
            <div class="w-full mt-auto">
              <div class="text-xs flex justify-between mb-1">
                <span>Experience</span>
                <span>{{ tech.experience }}+ years</span>
              </div>
              <div class="w-full bg-muted rounded-full h-2 overflow-hidden">
                <div class="experience-bar bg-primary h-full rounded-full transition-all duration-1000"
                  :style="{ width: `${Math.min(tech.experience * 10, 100)}%` }"></div>
              </div>
            </div>
          </div>
        </div>
      </transition-group>

      <!-- Marquee for Additional Tools & Technologies -->
      <div class="mb-16">
        <h3 class="text-xl font-semibold mb-6 text-center">Additional Tools & Technologies</h3>

        <div class="relative marquee-container">
          <!-- Enhanced Gradient Overlays -->
          <div
            class="absolute left-0 top-0 bottom-0 w-[120px] z-10 bg-gradient-to-r from-background via-background/90 to-transparent pointer-events-none">
          </div>
          <div
            class="absolute right-0 top-0 bottom-0 w-[120px] z-10 bg-gradient-to-l from-background via-background/90 to-transparent pointer-events-none">
          </div>

          <!-- Marquee Wrapper -->
          <div ref="marqueeWrapper" class="overflow-hidden py-6" @mouseenter="pauseMarquee" @mouseleave="resumeMarquee">
            <!-- First Marquee (Left to Right) -->
            <div class="marquee-track flex" :style="{ animationPlayState: isPaused ? 'paused' : 'running' }">
              <div v-for="(tool, index) in additionalTools" :key="`track1-${tool.id}-${index}`"
                class="flex-shrink-0 px-4 tech-tool" :style="{ animationDelay: `${index * 0.05}s` }">
                <div
                  class="bg-card rounded-lg p-4 border border-border shadow-sm hover:shadow-md hover:border-primary/20 transition-all duration-300 flex flex-col items-center text-center h-full w-28 tool-card">
                  <div class="w-12 h-12 flex items-center justify-center mb-3 tool-icon">
                    <img :src="tool.logo" :alt="tool.name" class="max-w-full max-h-full object-contain" />
                  </div>
                  <span class="text-sm font-medium">{{ tool.name }}</span>
                </div>
              </div>
            </div>

            <!-- Second Marquee (Right to Left) - Reverse Direction -->
            <div class="marquee-track-reverse flex mt-6"
              :style="{ animationPlayState: isPaused ? 'paused' : 'running' }">
              <div v-for="(tool, index) in [...additionalTools].reverse()" :key="`track2-${tool.id}-${index}`"
                class="flex-shrink-0 px-4 tech-tool" :style="{ animationDelay: `${index * 0.05}s` }">
                <div
                  class="bg-card rounded-lg p-4 border border-border shadow-sm hover:shadow-md hover:border-primary/20 transition-all duration-300 flex flex-col items-center text-center h-full w-28 tool-card">
                  <div class="w-12 h-12 flex items-center justify-center mb-3 tool-icon">
                    <img :src="tool.logo" :alt="tool.name" class="max-w-full max-h-full object-contain" />
                  </div>
                  <span class="text-sm font-medium">{{ tool.name }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import {
  CodeIcon, ServerIcon, ChevronLeftIcon, ChevronRightIcon,
  GlobeIcon, SmartphoneIcon, DatabaseIcon, CloudIcon,
  LightbulbIcon, MessageSquareIcon, LayoutIcon
} from 'lucide-vue-next';
import nginxLogo from '@/assets/nginx.svg';
import gitLogo from '@/assets/git.svg';
import tailwindLogo from '@/assets/tailwind.svg';
import graphqlLogo from '@/assets/graphql.svg';
import redisLogo from '@/assets/redis.svg';
import kubernetesLogo from '@/assets/kubernetes.svg';
import figmaLogo from '@/assets/figma.svg';
import jenkinsLogo from '@/assets/jenkins.svg';
import elasticSearchLogo from '@/assets/elasticsearch.svg';
import firebaseLogo from '@/assets/firebase.svg';
import stripeLogo from '@/assets/stripe.svg';
import webpackLogo from '@/assets/webpack.svg';
import nodejsLogo from '@/assets/nodejs.svg';
import postgresLogo from '@/assets/postgres.svg';
import mongoLogo from '@/assets/mongo.svg';
import awsLogo from '@/assets/aws.svg';
import dockerLogo from '@/assets/docker.svg';
import laravelLogo from '@/assets/laravel.svg';
import reactLogo from '@/assets/react.svg';
import vueLogo from '@/assets/vue.svg';
import flutterLogo from '@/assets/flutter.svg';
import typescriptLogo from '@/assets/typescript.svg';
import pythonLogo from '@/assets/python.svg';

// Technology Categories
const categories = [
  { id: 'all', name: 'All', icon: CodeIcon },
  { id: 'frontend', name: 'Frontend', icon: LayoutIcon },
  { id: 'backend', name: 'Backend', icon: ServerIcon },
  { id: 'mobile', name: 'Mobile', icon: SmartphoneIcon },
  { id: 'database', name: 'Database', icon: DatabaseIcon },
  { id: 'cloud', name: 'Cloud', icon: CloudIcon }
];

const activeCategory = ref('all');
const marqueeWrapper = ref(null);
const isPaused = ref(false);

// Main Technologies
const technologies = [
  {
    id: 2,
    name: "Vue.js",
    description: "Creating reactive and composable user interfaces.",
    logo: vueLogo,
    category: "frontend",
    level: "expert",
    experience: 5
  },
  {
    id: 3,
    name: "Laravel",
    description: "Developing robust backend systems with elegant syntax.",
    logo: laravelLogo,
    category: "backend",
    level: "expert",
    experience: 7
  },
  {
    id: 4,
    name: "Node.js",
    description: "Building scalable network applications with JavaScript.",
    logo: nodejsLogo,
    category: "backend",
    level: "advanced",
    experience: 6
  },
  {
    id: 6,
    name: "Flutter",
    description: "Developing beautiful native apps from a single codebase.",
    logo: flutterLogo,
    category: "mobile",
    level: "proficient",
    experience: 3
  },
  {
    id: 7,
    name: "PostgreSQL",
    description: "Managing relational data with advanced features.",
    logo: postgresLogo,
    category: "database",
    level: "expert",
    experience: 8
  },
  {
    id: 8,
    name: "MongoDB",
    description: "Storing data in flexible, JSON-like documents.",
    logo: mongoLogo,
    category: "database",
    level: "advanced",
    experience: 5
  },
  {
    id: 9,
    name: "AWS",
    description: "Leveraging cloud services for scalable infrastructure.",
    logo: awsLogo,
    category: "cloud",
    level: "expert",
    experience: 6
  },
  {
    id: 10,
    name: "Docker",
    description: "Containerizing applications for consistent deployment.",
    logo: dockerLogo,
    category: "cloud",
    level: "advanced",
    experience: 5
  },
  {
    id: 11,
    name: "TypeScript",
    description: "Adding static typing to JavaScript for better code quality.",
    logo: typescriptLogo,
    category: "frontend",
    level: "advanced",
    experience: 4
  },
  {
    id: 12,
    name: "Python",
    description: "Building data-driven applications and automation tools.",
    logo: pythonLogo,
    category: "backend",
    level: "proficient",
    experience: 4
  }
];

// Additional Tools - duplicated for the marquee effect
const additionalTools = [
  { id: 1, name: "Figma", logo: figmaLogo },
  { id: 2, name: "Tailwind CSS", logo: tailwindLogo },
  { id: 3, name: "GraphQL", logo: graphqlLogo },
  { id: 4, name: "Redis", logo: redisLogo },
  { id: 5, name: "Kubernetes", logo: kubernetesLogo },
  { id: 6, name: "Jenkins", logo: jenkinsLogo },
  { id: 7, name: "Elasticsearch", logo: elasticSearchLogo },
  { id: 8, name: "Firebase", logo: firebaseLogo },
  { id: 9, name: "Stripe", logo: stripeLogo },
  { id: 10, name: "Webpack", logo: webpackLogo },
  { id: 11, name: "Git", logo: gitLogo },
  { id: 12, name: "NGINX", logo: nginxLogo },
  // Duplicate the tools to ensure a seamless loop
  { id: 13, name: "Figma", logo: figmaLogo },
  { id: 14, name: "Tailwind CSS", logo: tailwindLogo },
  { id: 15, name: "GraphQL", logo: graphqlLogo },
  { id: 16, name: "Redis", logo: redisLogo },
  { id: 17, name: "Kubernetes", logo: kubernetesLogo },
  { id: 18, name: "Jenkins", logo: jenkinsLogo }
];

// Filtered technologies based on active category
const filteredTechnologies = computed(() => {
  if (activeCategory.value === 'all') {
    return technologies;
  }
  return technologies.filter(tech => tech.category === activeCategory.value);
});

// Marquee control functions
const pauseMarquee = () => {
  isPaused.value = true;
};

const resumeMarquee = () => {
  isPaused.value = false;
};

onMounted(() => {
  // Initialize experience bars with animation
  const bars = document.querySelectorAll('.experience-bar');
  bars.forEach(bar => {
    bar.style.width = '0%';
    setTimeout(() => {
      bar.style.width = bar.getAttribute('data-width') || bar.style.width;
    }, 300);
  });
});

// Watch for category changes to reset experience bars
watch(activeCategory, () => {
  setTimeout(() => {
    const bars = document.querySelectorAll('.experience-bar');
    bars.forEach(bar => {
      bar.style.width = '0%';
      setTimeout(() => {
        bar.style.width = bar.getAttribute('data-width') || bar.style.width;
      }, 300);
    });
  }, 100);
});
</script>

<style scoped>
.tech-card {
  animation: fadeInUp 0.6s ease-out forwards;
  opacity: 0;
}

.tech-tool {
  animation: fadeInScale 0.5s ease-out forwards;
}

.marquee-container {
  position: relative;
  overflow: hidden;
  padding: 10px 0;
  background-color: rgba(var(--background), 0.8);
}

/* Marquee Animation */
.marquee-track {
  display: flex;
  animation: marquee 30s linear infinite;
  will-change: transform;
}

.marquee-track-reverse {
  display: flex;
  animation: marquee-reverse 25s linear infinite;
  will-change: transform;
}

@keyframes marquee {
  0% {
    transform: translateX(0);
  }

  100% {
    transform: translateX(-100%);
  }
}

@keyframes marquee-reverse {
  0% {
    transform: translateX(-100%);
  }

  100% {
    transform: translateX(0);
  }
}

.tool-card {
  transition: all 0.3s ease;
}

.tool-card:hover {
  transform: translateY(-5px) scale(1.05);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
  z-index: 10;
  position: relative;
}

.tool-icon {
  transition: all 0.5s ease;
}

.tool-card:hover .tool-icon {
  transform: scale(1.1) rotate(5deg);
}

.tech-fade-enter-active,
.tech-fade-leave-active {
  transition: all 0.5s ease;
}

.tech-fade-enter-from,
.tech-fade-leave-to {
  opacity: 0;
  transform: translateY(30px);
}

.tech-fade-move {
  transition: transform 0.5s ease;
}

.tech-cta-btn {
  position: relative;
  overflow: hidden;
}

.tech-cta-btn::after {
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

.tech-cta-btn:hover::after {
  animation: ripple 1s ease-out;
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

@keyframes fadeInScale {
  from {
    opacity: 0;
    transform: scale(0.9);
  }

  to {
    opacity: 1;
    transform: scale(1);
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

/* Apply different animation delays to tech cards */
.tech-card:nth-child(4n+1) {
  animation-delay: 0.1s;
}

.tech-card:nth-child(4n+2) {
  animation-delay: 0.2s;
}

.tech-card:nth-child(4n+3) {
  animation-delay: 0.3s;
}

.tech-card:nth-child(4n+4) {
  animation-delay: 0.4s;
}
</style>
