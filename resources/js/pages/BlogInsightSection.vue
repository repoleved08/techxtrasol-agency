<template>
  <section
    class="py-20 bg-background"
    aria-labelledby="insights-heading"
  >
    <div class="container px-4 mx-auto">
      <!-- Section Header with improved semantics -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
        <div>
          <h2 id="insights-heading" class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
            Insights & <span class="text-primary">Resources</span>
          </h2>
          <p class="text-muted-foreground max-w-2xl">
            Stay updated with the latest technology trends, tutorials, and insights from our experts.
          </p>
        </div>

        <!-- Search Bar with proper accessibility -->
        <div class="mt-6 md:mt-0 relative w-full md:w-64 lg:w-72">
          <div class="relative">
            <label for="search-articles" class="sr-only">Search articles</label>
            <SearchIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" aria-hidden="true" />
            <input
              id="search-articles"
              type="search"
              placeholder="Search articles..."
              v-model="searchQuery"
              class="w-full pl-10 pr-4 py-2 rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
              @input="debouncedSearch"
            />
          </div>
        </div>
      </div>

      <!-- Category Filters with improved accessibility -->
      <div
        class="mb-12 overflow-x-auto hide-scrollbar"
        role="tablist"
        aria-label="Article categories"
      >
        <div class="flex space-x-2 pb-2">
          <button
            v-for="category in displayCategories"
            :key="category.id"
            @click="toggleCategory(category.id)"
            class="category-pill whitespace-nowrap transition-all duration-300"
            :class="[
              activeCategories.includes(category.id) ?
                'bg-primary text-primary-foreground' :
                'bg-muted text-muted-foreground hover:bg-muted/80'
            ]"
            role="tab"
            :aria-selected="activeCategories.includes(category.id)"
            :tabindex="activeCategories.includes(category.id) ? 0 : -1"
          >
            <component
              :is="getCategoryIcon(category.icon)"
              class="h-4 w-4 mr-2"
              aria-hidden="true"
            />
            {{ category.name }}
          </button>
        </div>
      </div>

      <!-- Loading State with proper ARIA -->
      <div
        v-if="loading"
        class="flex justify-center items-center py-20"
        aria-live="polite"
        aria-busy="true"
      >
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary" role="status">
          <span class="sr-only">Loading articles...</span>
        </div>
      </div>

      <template v-else>
        <!-- Enhanced Featured Article with Intersection Observer -->
        <div
          class="mb-16"
          ref="featuredArticleRef"
          :class="{ 'is-visible': isFeaturedVisible }"
        >
          <div
            v-if="featuredArticle"
            class="featured-article group relative rounded-xl overflow-hidden shadow-lg"
            @mouseenter="featuredHovered = true"
            @mouseleave="featuredHovered = false"
          >
            <!-- Background gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent z-10"></div>

            <!-- Responsive image container with loading state -->
            <div class="relative overflow-hidden">
              <!-- Mobile aspect ratio (16:9) for small screens -->
              <div class="sm:hidden relative aspect-[16/9]">
                <div v-if="featuredImageLoading" class="absolute inset-0 bg-muted animate-pulse"></div>
                <img
                  :src="featuredArticle.featured_image_url || featuredArticle.image"
                  :alt="featuredArticle.title"
                  class="w-full h-full object-cover transition-all duration-700"
                  :class="{'scale-105 brightness-105': featuredHovered}"
                  @load="featuredImageLoading = false"
                  @error="onImageError"
                  width="800"
                  height="450"
                  loading="eager"
                  fetchpriority="high"
                />
              </div>

              <!-- Tablet/Desktop aspect ratio (21:9) for larger screens -->
              <div class="hidden sm:block relative aspect-[21/9]">
                <div v-if="featuredImageLoading" class="absolute inset-0 bg-muted animate-pulse"></div>
                <img
                  :src="featuredArticle.featured_image_url || featuredArticle.image"
                  :alt="featuredArticle.title"
                  class="w-full h-full object-cover transition-all duration-700"
                  :class="{'scale-105 brightness-105': featuredHovered}"
                  @load="featuredImageLoading = false"
                  @error="onImageError"
                  width="1200"
                  height="514"
                  loading="eager"
                  fetchpriority="high"
                />
              </div>
            </div>

            <!-- Content overlay with improved responsive layout and accessibility -->
            <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 md:p-8 z-20">
              <div class="flex flex-wrap items-center gap-2 mb-3 sm:mb-4">
                <span class="px-3 py-1 bg-primary text-primary-foreground text-xs rounded-full">Featured</span>
                <span class="px-3 py-1 bg-background/20 backdrop-blur-sm text-white text-xs rounded-full">
                  {{ featuredArticle.category?.name || featuredArticle.category }}
                </span>
              </div>
              <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2 group-hover:text-primary transition-colors duration-300 line-clamp-2 sm:line-clamp-none">
                {{ featuredArticle.title }}
              </h3>
              <p class="text-white/80 mb-4 max-w-3xl hidden sm:block sm:line-clamp-2 md:line-clamp-none">{{ featuredArticle.excerpt }}</p>
              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center">
                  <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-primary/20 flex items-center justify-center mr-3">
                    <UserIcon class="h-4 w-4 sm:h-5 sm:w-5 text-white" aria-hidden="true" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-white">{{ featuredArticle.user?.name || featuredArticle.author }}</p>
                    <p class="text-xs text-white/70">
                      {{ formatDate(featuredArticle.published_at || featuredArticle.date) }} ·
                      {{ estimateReadTime(featuredArticle.body) || featuredArticle.readTime }} min read
                    </p>
                  </div>
                </div>
                <a
                  :href="`/resources/${featuredArticle.slug}`"
                  class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 py-2"
                  aria-label="Read article: ${featuredArticle.title}"
                >
                  Read Article
                  <ArrowRightIcon
                    class="ml-2 h-4 w-4 transition-transform duration-300"
                    :class="{'translate-x-1': featuredHovered}"
                    aria-hidden="true"
                  />
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Articles Grid with Intersection Observer -->
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
          ref="articlesGrid"
          role="tabpanel"
        >
          <div
            v-for="(article, index) in filteredArticles"
            :key="article.id"
            class="article-card group"
            :class="{ 'is-visible': visibleArticles[index] }"
          >
            <div class="bg-card rounded-xl overflow-hidden border border-border shadow-sm h-full flex flex-col transition-all duration-300 hover:shadow-md hover:border-primary/20">
              <div class="relative aspect-video overflow-hidden">
                <img
                  :src="article.featured_image_url || article.image || '/placeholder.svg?height=600&width=800'"
                  :alt="article.title"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                  loading="lazy"
                  width="400"
                  height="225"
                />
                <div class="absolute top-4 left-4">
                  <span class="px-2 py-1 bg-background/80 backdrop-blur-sm text-xs rounded-md">
                    {{ article.category?.name || article.category }}
                  </span>
                </div>
                <div class="absolute top-4 right-4 flex space-x-1">
                  <button
                    class="p-1.5 bg-background/80 backdrop-blur-sm rounded-full text-muted-foreground hover:text-foreground transition-colors"
                    aria-label="Bookmark article"
                  >
                    <BookmarkIcon class="h-4 w-4" aria-hidden="true" />
                  </button>
                  <button
                    class="p-1.5 bg-background/80 backdrop-blur-sm rounded-full text-muted-foreground hover:text-foreground transition-colors"
                    aria-label="Share article"
                  >
                    <ShareIcon class="h-4 w-4" aria-hidden="true" />
                  </button>
                </div>
              </div>

              <div class="p-6 flex flex-col flex-grow">
                <div class="mb-4">
                  <h3 class="text-xl font-semibold mb-2 group-hover:text-primary transition-colors duration-300">{{ article.title }}</h3>
                  <p class="text-muted-foreground text-sm">{{ article.excerpt }}</p>
                </div>

                <div class="mt-auto pt-4 border-t border-border flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2">
                      <UserIcon class="h-4 w-4 text-primary" aria-hidden="true" />
                    </div>
                    <div>
                      <p class="text-xs font-medium">{{ article.user?.name || article.author }}</p>
                      <p class="text-xs text-muted-foreground">{{ formatDate(article.published_at || article.date) }}</p>
                    </div>
                  </div>
                  <div class="flex items-center text-xs text-muted-foreground">
                    <ClockIcon class="h-3 w-3 mr-1" aria-hidden="true" />
                    {{ estimateReadTime(article.body) || article.readTime }} min read
                  </div>
                </div>
              </div>

              <a
                :href="`/resources/${article.slug}`"
                class="absolute inset-0 z-10"
                :aria-label="`Read article: ${article.title}`"
              >
                <span class="sr-only">Read {{ article.title }}</span>
              </a>
            </div>
          </div>
        </div>
      </template>

      <!-- Load More Button -->
      <div
        class="mt-12 text-center"
        ref="ctaSection"
        :class="{ 'is-visible': isCtaVisible }"
      >
        <a
          href="/our-resources"
          class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-6 py-2"
        >
          View All Resources
          <ArrowRightIcon class="ml-2 h-4 w-4" aria-hidden="true" />
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import {
  SearchIcon, UserIcon, ArrowRightIcon, BookmarkIcon, ShareIcon,
  ClockIcon, LoaderIcon, MailIcon, SendIcon, LightbulbIcon,
  CodeIcon, TrendingUpIcon, NewspaperIcon, GraduationCapIcon,
  RocketIcon
} from 'lucide-vue-next';

// State
const searchQuery = ref('');
const activeCategories = ref(['all']);
const visibleArticlesCount = ref(6);
const loading = ref(true);
const resources = ref([]);
const categories = ref([]);
const error = ref(null);
const featuredImageLoading = ref(true);
const featuredHovered = ref(false);

// Intersection Observer state
const featuredArticleRef = ref(null);
const articlesGrid = ref(null);
const ctaSection = ref(null);
const isFeaturedVisible = ref(false);
const visibleArticles = ref([]);
const isCtaVisible = ref(false);
let observers = [];

// Default categories
const defaultCategories = [
  { id: 'all', name: 'All', icon: 'newspaper' },
  { id: 'tech-trends', name: 'Tech Trends', icon: 'trending-up' },
  { id: 'tutorials', name: 'Tutorials', icon: 'graduation-cap' },
  { id: 'development', name: 'Development', icon: 'code' },
  { id: 'case-studies', name: 'Case Studies', icon: 'lightbulb' },
  { id: 'company-news', name: 'Company News', icon: 'rocket' }
];

// Default articles data (fallback)
const defaultArticles = [
  {
    id: 1,
    title: "The Future of AI in Software Development",
    excerpt: "Explore how artificial intelligence is transforming the way we build and maintain software applications.",
    author: "Alex Johnson",
    date: "May 15, 2023",
    readTime: 8,
    category: "Tech Trends",
    categoryId: "tech-trends",
    image: "https://cdn.pixabay.com/photo/2021/08/04/13/06/software-developer-6521720_1280.jpg",
    featured: true,
    slug: "future-of-ai-in-software-development"
  },
  {
    id: 2,
    title: "Building Scalable APIs with Laravel",
    excerpt: "Learn best practices for designing and implementing scalable RESTful APIs using Laravel framework.",
    author: "Maria Garcia",
    date: "April 28, 2023",
    readTime: 12,
    category: "Tutorials",
    categoryId: "tutorials",
    image: "https://cdn.pixabay.com/photo/2016/11/29/06/15/plans-1867745_960_720.jpg",
    slug: "building-scalable-apis-with-laravel"
  },
  {
    id: 3,
    title: "Responsive Design Best Practices",
    excerpt: "Discover the latest techniques for creating responsive websites that work seamlessly across all devices.",
    author: "John Smith",
    date: "April 15, 2023",
    readTime: 10,
    category: "Development",
    categoryId: "development",
    image: "https://cdn.pixabay.com/photo/2017/01/29/13/21/mobile-devices-2017980_960_720.jpg",
    slug: "responsive-design-best-practices"
  },
  {
    id: 4,
    title: "How We Improved Website Performance by 300%",
    excerpt: "A case study on optimizing website performance through modern techniques and tools.",
    author: "Sarah Williams",
    date: "March 22, 2023",
    readTime: 15,
    category: "Case Studies",
    categoryId: "case-studies",
    image: "https://cdn.pixabay.com/photo/2018/05/04/20/01/website-3374825_960_720.jpg",
    slug: "how-we-improved-website-performance"
  },
  {
    id: 5,
    title: "TechXtraSol Announces New Partnership",
    excerpt: "We're excited to announce our strategic partnership with a leading cloud provider.",
    author: "Michael Brown",
    date: "March 10, 2023",
    readTime: 5,
    category: "Company News",
    categoryId: "company-news",
    image: "https://cdn.pixabay.com/photo/2017/10/23/05/56/business-2880346_960_720.jpg",
    slug: "techxtrasol-announces-new-partnership"
  },
  {
    id: 6,
    title: "Introduction to Vue 3 Composition API",
    excerpt: "Learn how to leverage the power of Vue 3's Composition API in your projects.",
    author: "David Lee",
    date: "February 28, 2023",
    readTime: 14,
    category: "Tutorials",
    categoryId: "tutorials",
    image: "https://cdn.pixabay.com/photo/2019/10/03/12/12/javascript-4523100_960_720.jpg",
    slug: "introduction-to-vue-3-composition-api"
  }
];

// Debounced search function
let searchTimeout;
const debouncedSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    // Reset visibility tracking when search changes
    visibleArticles.value = Array(filteredArticles.value.length).fill(false);
    // Reset observers
    setupIntersectionObservers();
  }, 300);
};

// Fetch resources from Laravel backend with error handling and caching
const fetchResources = async () => {
  loading.value = true;

  // Check for cached data first
  const cachedData = sessionStorage.getItem('blog-resources-data');
  if (cachedData) {
    try {
      const parsedData = JSON.parse(cachedData);
      resources.value = parsedData.resources;
      categories.value = parsedData.categories;
      loading.value = false;

      // Setup visibility tracking
      visibleArticles.value = Array(filteredArticles.value.length).fill(false);
      setupIntersectionObservers();

      // Still fetch in background to update cache
      fetchAndUpdateCache();
      return;
    } catch (e) {
      console.error('Error parsing cached data:', e);
      // Continue with normal fetch if cache parsing fails
    }
  }

  // Normal fetch flow
  try {
    // First, try to fetch from the web.php route
    const response = await axios.get('/resources-data');
    resources.value = response.data.resources;
    categories.value = response.data.categories;

    // Cache the successful response
    sessionStorage.setItem('blog-resources-data', JSON.stringify({
      resources: response.data.resources,
      categories: response.data.categories,
      timestamp: Date.now()
    }));

  } catch (err) {
    console.log('Error fetching from web route, trying API route...');
    try {
      // If that fails, try the API route
      const apiResponse = await axios.get('/api/resources');
      resources.value = apiResponse.data.resources;
      categories.value = apiResponse.data.categories;

      // Cache the successful response
      sessionStorage.setItem('blog-resources-data', JSON.stringify({
        resources: apiResponse.data.resources,
        categories: apiResponse.data.categories,
        timestamp: Date.now()
      }));

    } catch (apiErr) {
      console.error('Error fetching resources:', apiErr);
      error.value = apiErr;
      // Fall back to default data
      resources.value = defaultArticles;
      categories.value = defaultCategories;
    }
  } finally {
    loading.value = false;

    // Setup visibility tracking after data is loaded
    visibleArticles.value = Array(filteredArticles.value.length).fill(false);
    setupIntersectionObservers();
  }
};

// Background fetch to update cache
const fetchAndUpdateCache = async () => {
  try {
    const response = await axios.get('/resources-data');
    // Only update if we got new data
    if (response.data && response.data.resources) {
      resources.value = response.data.resources;
      categories.value = response.data.categories;

      // Update cache
      sessionStorage.setItem('blog-resources-data', JSON.stringify({
        resources: response.data.resources,
        categories: response.data.categories,
        timestamp: Date.now()
      }));
    }
  } catch (err) {
    // Silent fail for background updates
    console.log('Background fetch failed, using cached data');
  }
};

// Handle image error with optimized placeholder
const onImageError = (e) => {
  // Replace with placeholder
  e.target.src = '/placeholder.svg?height=600&width=800';
  e.target.alt = 'Image not available';
};

// Display categories
const displayCategories = computed(() => {
  return categories.value.length > 0 ? categories.value : defaultCategories;
});

// Toggle category filter with performance optimization
const toggleCategory = (categoryId) => {
  if (categoryId === 'all') {
    if (!activeCategories.value.includes('all')) {
      activeCategories.value = ['all'];
      // Reset visibility tracking when changing categories
      visibleArticles.value = Array(filteredArticles.value.length).fill(false);
      // Reset observers
      setupIntersectionObservers();
    }
    return;
  }

  // Remove 'all' category if it's active
  if (activeCategories.value.includes('all')) {
    activeCategories.value = activeCategories.value.filter(id => id !== 'all');
  }

  // Toggle the selected category
  if (activeCategories.value.includes(categoryId)) {
    activeCategories.value = activeCategories.value.filter(id => id !== categoryId);

    // If no categories are selected, default to 'all'
    if (activeCategories.value.length === 0) {
      activeCategories.value = ['all'];
    }
  } else {
    activeCategories.value.push(categoryId);
  }

  // Reset visibility tracking when changing categories
  visibleArticles.value = Array(filteredArticles.value.length).fill(false);
  // Reset observers
  setupIntersectionObservers();
};

// All articles - memoized
const allArticles = computed(() => {
  return resources.value.length > 0 ? resources.value : defaultArticles;
});

// Featured article - memoized
const featuredArticle = computed(() => {
  const featured = allArticles.value.find(article => article.featured || article.is_featured);
  return featured || allArticles.value[0]; // Default to first article if none is featured
});

// Filtered articles (excluding featured) - optimized
const filteredArticles = computed(() => {
  let articles = allArticles.value.filter(article =>
    article.id !== (featuredArticle.value?.id)
  );

  // Apply category filter
  if (!activeCategories.value.includes('all')) {
    articles = articles.filter(article => {
      const categoryId = article.categoryId || article.category_id ||
                        (article.category?.slug || article.category?.id);
      return activeCategories.value.includes(categoryId);
    });
  }

  // Apply search filter
  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase();
    articles = articles.filter(article =>
      article.title.toLowerCase().includes(query) ||
      article.excerpt.toLowerCase().includes(query) ||
      (article.author || article.user?.name || '').toLowerCase().includes(query) ||
      (article.category?.name || article.category || '').toLowerCase().includes(query)
    );
  }

  // Limit to visible count
  return articles.slice(0, visibleArticlesCount.value);
});

// Format date - memoized
const dateCache = new Map();
const formatDate = (dateString) => {
  if (!dateString) return '';

  // Return from cache if available
  if (dateCache.has(dateString)) {
    return dateCache.get(dateString);
  }

  const formatted = new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });

  // Cache the result
  dateCache.set(dateString, formatted);
  return formatted;
};

// Estimate read time - memoized
const readTimeCache = new Map();
const estimateReadTime = (content) => {
  if (!content) return 5;

  // Return from cache if available
  if (readTimeCache.has(content)) {
    return readTimeCache.get(content);
  }

  const wordsPerMinute = 200;
  const textLength = content.split(' ').length;
  const readTime = Math.max(1, Math.ceil(textLength / wordsPerMinute));

  // Cache the result
  readTimeCache.set(content, readTime);
  return readTime;
};

// Helper function to get category icon - memoized
const iconCache = new Map();
const getCategoryIcon = (iconName) => {
  if (!iconName) return NewspaperIcon;

  // Return from cache if available
  if (iconCache.has(iconName)) {
    return iconCache.get(iconName);
  }

  const iconMap = {
    'lightbulb': LightbulbIcon,
    'code': CodeIcon,
    'trending-up': TrendingUpIcon,
    'newspaper': NewspaperIcon,
    'graduation-cap': GraduationCapIcon,
    'rocket': RocketIcon
  };

  const icon = iconMap[iconName] || NewspaperIcon;

  // Cache the result
  iconCache.set(iconName, icon);
  return icon;
};

// Setup intersection observers for lazy loading and animations
const setupIntersectionObservers = () => {
  // Clean up existing observers
  observers.forEach(observer => observer.disconnect());
  observers = [];

  // Wait for DOM update
  setTimeout(() => {
    // Observer for featured article
    if (featuredArticleRef.value) {
      const featuredObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            isFeaturedVisible.value = true;
            featuredObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      featuredObserver.observe(featuredArticleRef.value);
      observers.push(featuredObserver);
    }

    // Observer for article cards
    if (articlesGrid.value) {
      const articleCards = articlesGrid.value.querySelectorAll('.article-card');

      if (articleCards.length > 0) {
        const articleObserver = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const index = Array.from(articleCards).indexOf(entry.target);
              if (index !== -1 && index < visibleArticles.value.length) {
                visibleArticles.value[index] = true;
              }
              articleObserver.unobserve(entry.target);
            }
          });
        }, { threshold: 0.1, rootMargin: '0px 0px 100px 0px' });

        articleCards.forEach(card => {
          articleObserver.observe(card);
        });

        observers.push(articleObserver);
      }
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
  }, 0);
};

// Lifecycle hooks
onMounted(() => {
  // Initialize visibility array
  visibleArticles.value = Array(filteredArticles.value.length).fill(false);

  // Fetch resources
  fetchResources();

  // Add event listener for reduced motion preference
  const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (mediaQuery.matches) {
    document.documentElement.classList.add('reduced-motion');
  }
});

onUnmounted(() => {
  // Clean up observers
  observers.forEach(observer => observer.disconnect());
  observers = [];

  // Clear any pending timeouts
  clearTimeout(searchTimeout);
});
</script>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}

.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.category-pill {
  @apply px-4 py-2 rounded-full text-sm font-medium inline-flex items-center;
  transition: background-color 0.3s ease, color 0.3s ease;
}

/* Optimized animations with visibility classes */
.article-card {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
  will-change: transform, opacity;
  content-visibility: auto;
  contain-intrinsic-size: 0 400px;
}

.article-card.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Staggered animation delay */
.article-card:nth-child(3n+1).is-visible { transition-delay: 0ms; }
.article-card:nth-child(3n+2).is-visible { transition-delay: 100ms; }
.article-card:nth-child(3n+3).is-visible { transition-delay: 200ms; }

.featured-article {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
  will-change: transform, opacity;
}

.mb-16.is-visible .featured-article {
  opacity: 1;
  transform: translateY(0);
}

/* CTA animation */
.mt-12 {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
}

.mt-12.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Loading animation - optimized */
@keyframes shimmer {
  0% {
    background-position: -200% 0;
  }
  100% {
    background-position: 200% 0;
  }
}

.animate-pulse {
  background: linear-gradient(90deg,
    hsl(var(--muted) / 0.3) 25%,
    hsl(var(--muted) / 0.5) 50%,
    hsl(var(--muted) / 0.3) 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  .article-card,
  .featured-article,
  .mt-12,
  .mb-16 {
    transition: none;
    animation: none;
    opacity: 1;
    transform: none;
  }

  .animate-pulse {
    animation: none;
    background: hsl(var(--muted) / 0.3);
  }

  .article-card img,
  .featured-article img {
    transition: none;
  }
}

/* For JS detection of reduced motion preference */
:root.reduced-motion * {
  transition-duration: 0.001ms !important;
  animation-duration: 0.001ms !important;
}
</style>
