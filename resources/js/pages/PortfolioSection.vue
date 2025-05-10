<template>
  <section
    id="portfolio"
    class="portfolio-section py-16 md:py-24"
    aria-labelledby="portfolio-heading"
  >
    <!-- Header -->
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-sm font-medium rounded-full mb-3">
          Our Work
        </span>
        <h2 id="portfolio-heading" class="text-3xl md:text-4xl font-bold mb-4">Featured Projects</h2>
        <p class="text-muted-foreground max-w-2xl mx-auto">
          Explore our collection of successful projects that showcase our expertise in delivering innovative solutions
          across various industries.
        </p>
      </div>

      <!-- Category Filter -->
      <div
        class="flex flex-wrap justify-center gap-2 mb-12"
        role="tablist"
        aria-label="Project categories"
      >
        <button
          v-for="category in categories"
          :key="category"
          @click="setActiveCategory(category)"
          class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-300"
          :class="activeCategory === category
            ? 'bg-primary text-primary-foreground shadow-md'
            : 'bg-secondary text-secondary-foreground hover:bg-secondary/80'"
          role="tab"
          :aria-selected="activeCategory === category"
          :tabindex="activeCategory === category ? 0 : -1"
        >
          {{ category }}
        </button>
      </div>

      <!-- Projects Grid with Intersection Observer -->
      <div
        v-if="hasProjects"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8"
        ref="projectsGrid"
        role="tabpanel"
      >
        <div
          v-for="(project, index) in filteredProjects"
          :key="project.id || index"
          class="project-card group"
          :class="{ 'is-visible': visibleProjects[index] }"
        >
          <div class="relative overflow-hidden rounded-lg aspect-[4/3] mb-4">
            <!-- Project Image with width/height and lazy loading -->
            <img
              :src="project.image || '/images/placeholder-project.jpg'"
              :alt="project.title || 'Project'"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
              loading="lazy"
              width="400"
              height="300"
              :fetchpriority="index < 3 ? 'high' : 'low'"
            />

            <!-- Overlay -->
            <div
              class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
            >
              <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                <span
                  class="inline-block px-2 py-1 bg-primary/90 text-primary-foreground text-xs font-medium rounded mb-2"
                >
                  {{ formatCategory(project.category) }}
                </span>
                <h3 class="text-white text-xl font-bold mb-1">{{ project.title || 'Untitled Project' }}</h3>
                <p class="text-white/80 text-sm line-clamp-2">{{ project.description || 'No description available' }}</p>
              </div>
            </div>
          </div>

          <!-- Project Info -->
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2 group-hover:text-primary transition-colors duration-300">
              {{ project.title || 'Untitled Project' }}
            </h3>
            <p class="text-muted-foreground text-sm mb-4 line-clamp-2">
              {{ project.description || 'No description available' }}
            </p>

            <!-- Technologies -->
            <div class="flex flex-wrap gap-1 mb-4">
              <span
                v-for="(tech, techIndex) in extractTechnologies(project.technologies).slice(0, 3)"
                :key="`${project.id || index}-${techIndex}`"
                class="px-2 py-1 bg-secondary text-secondary-foreground text-xs rounded"
              >
                {{ tech }}
              </span>
              <span
                v-if="extractTechnologies(project.technologies).length > 3"
                class="px-2 py-1 bg-secondary text-secondary-foreground text-xs rounded"
              >
                +{{ extractTechnologies(project.technologies).length - 3 }}
              </span>
            </div>

            <!-- Action Button -->
            <Link
              v-if="project.slug"
              :href="`/case-studies/${project.slug}`"
              class="text-sm font-medium text-primary flex items-center group/btn"
            >
              View Details
              <ArrowRightIcon class="ml-1 h-4 w-4 transition-transform duration-300 group-hover/btn:translate-x-1" />
            </Link>
            <button
              v-else
              class="text-sm font-medium text-primary flex items-center group/btn"
              @click="openProject(project)"
            >
              View Details
              <ArrowRightIcon class="ml-1 h-4 w-4 transition-transform duration-300 group-hover/btn:translate-x-1" />
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State (No Projects) -->
      <div
        v-else
        class="text-center py-16 bg-card border border-border rounded-xl"
      >
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-muted mb-4">
          <FolderIcon class="h-8 w-8 text-muted-foreground" />
        </div>
        <h3 class="text-xl font-semibold mb-2">No projects available</h3>
        <p class="text-muted-foreground mb-6 max-w-md mx-auto">
          We're currently working on adding our portfolio projects. Check back soon to see our latest work.
        </p>
      </div>

      <!-- Empty State (No Filtered Projects) -->
      <div
        v-if="hasProjects && filteredProjects.length === 0"
        class="text-center py-16"
      >
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-muted mb-4">
          <SearchXIcon class="h-8 w-8 text-muted-foreground" />
        </div>
        <h3 class="text-xl font-semibold mb-2">No projects found</h3>
        <p class="text-muted-foreground mb-6">We don't have any projects in this category yet.</p>
        <button
          @click="setActiveCategory('All')"
          class="inline-flex items-center px-4 py-2 rounded-md bg-primary text-primary-foreground text-sm font-medium"
        >
          <RefreshCwIcon class="mr-2 h-4 w-4" />
          Show all projects
        </button>
      </div>

      <!-- Featured Project Spotlight (if available) - Lazy loaded -->
      <div
        v-if="featuredProject"
        class="mt-24 relative"
        ref="featuredProjectSection"
        :class="{ 'is-visible': isFeaturedVisible }"
      >
        <div class="relative bg-card border border-border rounded-xl overflow-hidden shadow-xl">
          <div class="grid md:grid-cols-2 gap-0">
            <!-- Left: Image -->
            <div class="relative h-full min-h-[300px]">
              <img
                :src="featuredProject.image || '/images/placeholder-project.jpg'"
                :alt="featuredProject.title || 'Featured Project'"
                class="w-full h-full object-cover"
                loading="lazy"
                width="600"
                height="400"
              />
              <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
              <div class="absolute top-6 left-6">
                <span class="px-3 py-1 bg-primary text-primary-foreground text-sm font-medium rounded-full">
                  Featured
                </span>
              </div>
            </div>

            <!-- Right: Content -->
            <div class="p-8 md:p-10 flex flex-col">
              <div>
                <span class="text-sm text-primary font-medium">{{ formatCategory(featuredProject.category) }}</span>
                <h3 class="text-2xl md:text-3xl font-bold mt-2 mb-4">
                  {{ featuredProject.title || 'Featured Project' }}
                </h3>
                <p class="text-muted-foreground mb-6">
                  {{ featuredProject.description || 'No description available' }}
                </p>
              </div>

              <!-- Stats (if available) -->
              <div
                v-if="featuredProject.key_metrics && featuredProject.key_metrics.length"
                class="grid grid-cols-2 gap-4 mb-6"
              >
                <div
                  v-for="(metric, index) in featuredProject.key_metrics.slice(0, 2)"
                  :key="index"
                  class="bg-muted/50 rounded-lg p-4 text-center"
                >
                  <div class="text-2xl font-bold text-primary">{{ metric.value }}</div>
                  <div class="text-xs text-muted-foreground">{{ metric.label }}</div>
                </div>
              </div>

              <!-- Technologies -->
              <div class="mb-6">
                <h4 class="text-sm font-semibold mb-3">Technologies Used</h4>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="(tech, index) in extractTechnologies(featuredProject.technologies)"
                    :key="index"
                    class="px-3 py-1 bg-secondary text-secondary-foreground text-xs rounded"
                  >
                    {{ tech }}
                  </span>
                </div>
              </div>

              <div class="mt-auto">
                <Link
                  v-if="featuredProject.slug"
                  :href="`/case-studies/${featuredProject.slug}`"
                  class="inline-flex items-center px-4 py-2 rounded-md bg-primary text-primary-foreground text-sm font-medium"
                >
                  View Case Study
                  <ArrowRightIcon class="ml-2 h-4 w-4" />
                </Link>
                <button
                  v-else
                  class="inline-flex items-center px-4 py-2 rounded-md bg-primary text-primary-foreground text-sm font-medium"
                  @click="openProject(featuredProject)"
                >
                  View Case Study
                  <ArrowRightIcon class="ml-2 h-4 w-4" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
  ArrowRightIcon,
  UserIcon,
  QuoteIcon,
  SearchXIcon,
  RefreshCwIcon,
  FolderIcon
} from 'lucide-vue-next';

// Default projects data (fallback)
const defaultProjects = [
  {
    id: 1,
    title: "Financial Analytics Dashboard",
    description: "Real-time analytics platform for financial decision-making with customizable dashboards.",
    category: "finance",
    technologies: ["Angular", "D3.js", "Python", "PostgreSQL"],
    image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop"
  },
  {
    id: 2,
    title: "E-Learning Mobile App",
    description: "Interactive learning platform with progress tracking and personalized content.",
    category: "mobile",
    technologies: ["React Native", "Node.js", "MongoDB", "Firebase"],
    image: "https://images.unsplash.com/photo-1501504905252-473c47e087f8?q=80&w=800&auto=format&fit=crop"
  },
  {
    id: 3,
    title: "E-commerce Platform",
    description: "Feature-rich online store with inventory management and payment processing.",
    category: "ecommerce",
    technologies: ["Vue.js", "Laravel", "MySQL", "Stripe API"],
    image: "https://images.unsplash.com/photo-1607082350899-7e105aa886ae?q=80&w=800&auto=format&fit=crop"
  }
];

// Props from the controller (now optional with defaults)
const props = defineProps({
  projects: {
    type: Array,
    default: () => []
  },
  categories: {
    type: Array,
    default: () => ['All', 'Web', 'Mobile', 'AI', 'E-commerce', 'Finance']
  }
});

// Category filter with performance tracking
const activeCategory = ref('All');
const setActiveCategory = (category) => {
  // Only update if actually changing categories
  if (activeCategory.value !== category) {
    activeCategory.value = category;
    // Reset visibility tracking when changing categories
    visibleProjects.value = Array(filteredProjects.value.length).fill(false);
    // Reset observers
    setupIntersectionObservers();
  }
};

// Check if we have projects
const hasProjects = computed(() => {
  return Array.isArray(props.projects) && props.projects.length > 0;
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

// Extract technologies from the technologies array - memoized
const techCache = new Map();
const extractTechnologies = (technologies) => {
  // Return from cache if available
  const cacheKey = JSON.stringify(technologies);
  if (techCache.has(cacheKey)) {
    return techCache.get(cacheKey);
  }

  if (!technologies) return [];

  let result = [];
  // Handle different formats that might come from the backend
  if (Array.isArray(technologies)) {
    // If technologies is an array of objects with a 'technology' property
    if (technologies.length > 0 && technologies[0] && typeof technologies[0] === 'object' && 'technology' in technologies[0]) {
      result = technologies.map(tech => tech.technology);
    } else {
      // If technologies is an array of strings
      result = technologies;
    }
  }

  // Cache the result
  techCache.set(cacheKey, result);
  return result;
};

// Filtered projects based on active category - with performance optimization
const filteredProjects = computed(() => {
  // Use props.projects if available, otherwise use defaultProjects
  const projectsToFilter = hasProjects.value ? props.projects : defaultProjects;

  if (activeCategory.value === 'All') {
    return projectsToFilter;
  }

  return projectsToFilter.filter(project => {
    // Convert both to lowercase for case-insensitive comparison
    const projectCategory = (project.category || '').toLowerCase();
    const selectedCategory = activeCategory.value.toLowerCase();
    return projectCategory === selectedCategory || formatCategory(projectCategory).toLowerCase() === selectedCategory;
  });
});

// Get featured project (first project or most recent)
const featuredProject = computed(() => {
  if (!hasProjects.value && defaultProjects.length === 0) return null;
  return hasProjects.value ? props.projects[0] : defaultProjects[0];
});

// Open project details (placeholder function)
const openProject = (project) => {
  console.log('Opening project:', project.title);
  // In a real implementation, this would open a modal or navigate to a details page
};

// Intersection Observer for lazy loading and animations
const projectsGrid = ref(null);
const featuredProjectSection = ref(null);
const visibleProjects = ref([]);
const isFeaturedVisible = ref(false);
let observers = [];

// Setup intersection observers
const setupIntersectionObservers = () => {
  // Clean up existing observers
  observers.forEach(observer => observer.disconnect());
  observers = [];

  // Initialize visibility array
  visibleProjects.value = Array(filteredProjects.value.length).fill(false);

  // Wait for DOM update
  setTimeout(() => {
    // Observer for project cards
    if (projectsGrid.value) {
      const projectCards = projectsGrid.value.querySelectorAll('.project-card');

      const projectObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const index = Array.from(projectCards).indexOf(entry.target);
            if (index !== -1) {
              visibleProjects.value[index] = true;
            }
            projectObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px 100px 0px' });

      projectCards.forEach(card => {
        projectObserver.observe(card);
      });

      observers.push(projectObserver);
    }

    // Observer for featured project
    if (featuredProjectSection.value) {
      const featuredObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            isFeaturedVisible.value = true;
            featuredObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      featuredObserver.observe(featuredProjectSection.value);
      observers.push(featuredObserver);
    }
  }, 0);
};

// Lifecycle hooks
onMounted(() => {
  setupIntersectionObservers();
});

onUnmounted(() => {
  // Clean up observers
  observers.forEach(observer => observer.disconnect());
});
</script>

<style scoped>
.portfolio-section {
  background-color: hsl(var(--background));
  color: hsl(var(--foreground));
  contain: content; /* CSS containment for performance */
}

.project-card {
  background-color: hsl(var(--card));
  border-radius: 0.75rem;
  border: 1px solid hsl(var(--border));
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  opacity: 0;
  transform: translateY(20px);
  will-change: transform, opacity; /* Hint for browser optimization */
  content-visibility: auto; /* Modern browsers will optimize rendering */
  contain-intrinsic-size: 0 400px; /* Hint for browser about size */
}

.project-card.is-visible {
  opacity: 1;
  transform: translateY(0);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

/* Staggered animation delay */
.project-card:nth-child(1).is-visible { transition-delay: 0ms; }
.project-card:nth-child(2).is-visible { transition-delay: 100ms; }
.project-card:nth-child(3).is-visible { transition-delay: 200ms; }
.project-card:nth-child(4).is-visible { transition-delay: 300ms; }
.project-card:nth-child(5).is-visible { transition-delay: 400ms; }
.project-card:nth-child(6).is-visible { transition-delay: 500ms; }

.project-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1),
    0 8px 10px -6px rgba(0, 0, 0, 0.1);
}

/* Featured project animation */
.mt-24 {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.mt-24.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Reduce animations for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
  .project-card,
  .mt-24 {
    transition: none;
    opacity: 1;
    transform: none;
  }

  .project-card:hover {
    transform: none;
  }

  .project-card img {
    transition: none;
  }
}
</style>
