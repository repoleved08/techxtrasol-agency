<template>
  <Head title="Blog Section" />
  <PublicLayout>
    <div class="bg-background py-12 md:py-20">
      <div class="container px-4 mx-auto">
        <!-- Section Header with Animation -->
        <div v-motion :initial="{ opacity: 0, y: 20 }" :enter="{ opacity: 1, y: 0, transition: { duration: 600 } }"
          class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
          <div
            class="inline-flex items-center px-4 py-1.5 mb-4 rounded-full bg-primary/10 text-primary text-sm font-medium">
            <BookOpenIcon class="h-4 w-4 mr-2" />
            <span>Our Blog</span>
          </div>
          <h2 class="text-3xl md:text-4xl font-bold mb-4">Latest Insights & News</h2>
          <p class="text-muted-foreground text-lg">
            Discover the latest trends, technologies, and insights from our experts.
          </p>
        </div>

        <!-- Search and Filter Bar -->
        <div v-motion :initial="{ opacity: 0 }" :enter="{ opacity: 1, transition: { duration: 600, delay: 200 } }"
          class="flex flex-col md:flex-row gap-4 mb-10 justify-between items-center">

          <!-- Search Form -->
          <div class="relative w-full md:w-72">
            <form
              :action="route('blog')"
              method="GET"
              @submit="handleSearchSubmit"
              ref="searchForm"
            >
              <!-- Preserve current category filter -->
              <input
                v-if="activeCategory && activeCategory !== 'all'"
                type="hidden"
                name="category"
                :value="activeCategory"
              >

              <div class="relative">
                <SearchIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                <Input
                  type="search"
                  name="search"
                  placeholder="Search articles..."
                  class="pl-10"
                  v-model="searchQuery"
                  v-motion :initial="{ scale: 0.95, opacity: 0 }"
                  :enter="{ scale: 1, opacity: 1, transition: { duration: 400, delay: 300 } }"
                />
                <button
                  type="submit"
                  class="absolute right-2 top-1/2 -translate-y-1/2 p-1 rounded-md bg-primary text-primary-foreground hover:bg-primary/90 transition-colors"
                  :disabled="isSearching"
                >
                  <ArrowRightIcon class="h-4 w-4" />
                </button>
              </div>
            </form>
          </div>

          <!-- Category Filters -->
          <div class="flex flex-wrap gap-2 justify-center md:justify-end">
            <Link
              v-for="(category, index) in categories"
              :key="category.id"
              :href="buildCategoryUrl(category.id)"
              class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium transition-all duration-300 hover:scale-105"
              :class="activeCategory === category.id ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground hover:bg-muted/80'"
              v-motion
              :initial="{ scale: 0.9, opacity: 0 }"
              :enter="{ scale: 1, opacity: 1, transition: { duration: 400, delay: 300 + (index * 50) } }"
            >
              <component :is="getCategoryIcon(category)" class="h-4 w-4 mr-2" />
              {{ category.name }}
            </Link>
          </div>
        </div>

        <!-- Active Filters Display -->
        <div v-if="hasActiveFilters" class="flex flex-wrap items-center gap-2 mb-6 p-4 bg-muted/50 rounded-lg">
          <span class="text-sm font-medium text-muted-foreground">Active filters:</span>

          <div v-if="activeCategory && activeCategory !== 'all'" class="flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary rounded-full text-sm">
            <span>Category: {{ getCategoryName(activeCategory) }}</span>
            <Link
              :href="buildClearCategoryUrl()"
              class="ml-1 hover:bg-primary/20 rounded-full p-0.5"
            >
              <XIcon class="h-3 w-3" />
            </Link>
          </div>

          <div v-if="filters.search" class="flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary rounded-full text-sm">
            <span>Search: "{{ filters.search }}"</span>
            <Link
              :href="buildClearSearchUrl()"
              class="ml-1 hover:bg-primary/20 rounded-full p-0.5"
            >
              <XIcon class="h-3 w-3" />
            </Link>
          </div>

          <Link
            :href="route('blog')"
            class="text-sm text-muted-foreground hover:text-foreground underline"
          >
            Clear all filters
          </Link>
        </div>

        <!-- Results Summary -->
        <div class="mb-6">
          <p class="text-sm text-muted-foreground">
            <template v-if="hasActiveFilters">
              Found {{ blogPosts.total }} article{{ blogPosts.total !== 1 ? 's' : '' }}
              <template v-if="filters.search">matching "{{ filters.search }}"</template>
              <template v-if="activeCategory && activeCategory !== 'all'">in {{ getCategoryName(activeCategory) }}</template>
            </template>
            <template v-else>
              Showing {{ blogPosts.total }} articles
            </template>
          </p>
        </div>

        <!-- Featured Post -->
        <div v-if="featuredPost && !hasActiveFilters" v-motion :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }" class="mb-12">
          <Card
            class="overflow-hidden group border-border/40 hover:border-primary/30 transition-all duration-500 hover:shadow-lg hover:shadow-primary/10">
            <div class="grid md:grid-cols-2 gap-0">
              <div class="relative overflow-hidden aspect-video md:aspect-auto">
                <img :src="featuredPost.image" :alt="featuredPost.title"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <Badge class="absolute top-4 left-4 bg-primary hover:bg-primary text-primary-foreground" v-motion
                  :initial="{ scale: 0.8, opacity: 0 }"
                  :enter="{ scale: 1, opacity: 1, transition: { type: 'spring', stiffness: 300, damping: 20, delay: 800 } }">
                  Featured
                </Badge>
              </div>
              <div class="p-6 md:p-8 flex flex-col justify-between">
                <div>
                  <div class="flex items-center gap-2 mb-3">
                    <Badge variant="outline">{{ featuredPost.category }}</Badge>
                    <time class="text-xs text-muted-foreground" :datetime="featuredPost.date">
                      {{ formatDate(featuredPost.date) }}
                    </time>
                  </div>
                  <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors duration-300">{{
                    featuredPost.title }}</h3>
                  <div class="prose prose-sm text-muted-foreground mb-6 max-w-none" v-html="featuredPost.excerpt"></div>
                </div>
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <Avatar class="h-10 w-10">
                      <AvatarImage :src="featuredPost.author.avatar"
                        :alt="featuredPost.author.name" />
                      <AvatarFallback>{{ getInitials(featuredPost.author.name) }}</AvatarFallback>
                    </Avatar>
                    <div>
                      <p class="text-sm font-medium">{{ featuredPost.author.name }}</p>
                      <p class="text-xs text-muted-foreground">{{ featuredPost.author.role }}</p>
                    </div>
                  </div>
                  <Button as-child variant="ghost" class="group-hover:text-primary transition-colors duration-300">
                    <Link v-if="featuredPost.slug" :href="`/agency/blog/${featuredPost.slug}`"
                      class="flex items-center">
                    Read More
                    <ArrowRightIcon class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
                    </Link>
                  </Button>
                </div>
              </div>
            </div>
          </Card>
        </div>

        <!-- Blog Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
          <article v-for="(post, index) in blogPosts.data" :key="post.id" v-motion :initial="{ opacity: 0, y: 30 }"
            :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 100 + (index * 100) } }" class="group">
            <Card
              class="overflow-hidden h-full border-border/40 transition-all duration-500 hover:shadow-lg hover:shadow-primary/10 hover:border-primary/30 hover:-translate-y-1">
              <div class="relative overflow-hidden aspect-video">
                <Link :href="`/agency/blog/${post.slug}`" class="block">
                <img :src="post.image" :alt="post.title"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                  loading="lazy" />
                <div
                  class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                </Link>
                <div class="absolute top-4 left-4 flex gap-2">
                  <Badge variant="default" v-motion :initial="{ scale: 0.8, opacity: 0 }"
                    :enter="{ scale: 1, opacity: 1, transition: { delay: 200 + (index * 100) } }">
                    {{ post.category }}
                  </Badge>
                  <Badge variant="outline" class="bg-background/80" v-motion :initial="{ scale: 0.8, opacity: 0 }"
                    :enter="{ scale: 1, opacity: 1, transition: { delay: 300 + (index * 100) } }">
                    <time :datetime="post.date">{{ formatDate(post.date) }}</time>
                  </Badge>
                </div>
              </div>
              <CardContent class="p-5">
                <Link :href="`/agency/blog/${post.slug}`" class="block">
                <h2 class="font-bold text-xl mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-2">
                  {{ post.title }}</h2>
                </Link>
                <div class="prose prose-sm text-muted-foreground mb-6 max-w-none" v-html="post.excerpt"></div>
              </CardContent>
              <CardFooter class="px-5 pb-5 pt-0 flex justify-between items-center">
                <div class="flex items-center gap-2">
                  <Avatar class="h-8 w-8">
                    <AvatarImage :src="post.author.avatar"
                      :alt="post.author.name" />
                    <AvatarFallback>{{ getInitials(post.author.name) }}</AvatarFallback>
                  </Avatar>
                  <span class="text-xs">{{ post.author.name }}</span>
                </div>
                <Button as-child variant="ghost" size="sm"
                  class="group-hover:text-primary transition-colors duration-300">
                  <Link :href="`/agency/blog/${post.slug}`" class="flex items-center">
                  Read
                  <ArrowRightIcon class="ml-1 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
                  </Link>
                </Button>
              </CardFooter>
            </Card>
          </article>
        </div>

        <!-- No Results -->
        <div v-if="blogPosts.data.length === 0" class="text-center py-16" v-motion :initial="{ opacity: 0, scale: 0.9 }"
          :enter="{ opacity: 1, scale: 1, transition: { type: 'spring', stiffness: 300, damping: 25 } }">
          <div class="inline-block p-4 rounded-full bg-primary/10 mb-4">
            <BookOpenIcon class="h-8 w-8 text-primary" />
          </div>
          <h3 class="text-xl font-bold mb-2">No articles found</h3>
          <p class="text-muted-foreground mb-4">
            <template v-if="hasActiveFilters">
              Try adjusting your search terms or filters to find what you're looking for.
            </template>
            <template v-else>
              No articles have been published yet. Check back soon!
            </template>
          </p>
          <Link
            v-if="hasActiveFilters"
            :href="route('blog')"
            class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
          >
            View all articles
          </Link>
        </div>

        <!-- Pagination -->
        <nav v-if="blogPosts.data.length > 0 && (blogPosts.prev_page_url || blogPosts.next_page_url)"
          v-motion :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 400 } }"
          class="mt-12 flex justify-between items-center"
          aria-label="Blog pagination">

          <div class="text-sm text-muted-foreground">
            Showing {{ blogPosts.from }} to {{ blogPosts.to }} of {{ blogPosts.total }} articles
          </div>

          <div class="flex gap-2">
            <Link
              v-if="blogPosts.prev_page_url"
              :href="blogPosts.prev_page_url"
              class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2"
              rel="prev"
            >
              <ChevronLeftIcon class="h-4 w-4 mr-1" />
              Previous
            </Link>

            <Link
              v-if="blogPosts.next_page_url"
              :href="blogPosts.next_page_url"
              class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2"
              rel="next"
            >
              Next
              <ChevronRightIcon class="h-4 w-4 ml-1" />
            </Link>
          </div>
        </nav>

        <!-- Newsletter Subscription -->
        <Newsletter class="mt-16 md:mt-24" v-motion :initial="{ opacity: 0, y: 30 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 800, delay: 500 } }"
          :visibleOnce="{ opacity: 1, y: 0 }" />
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Newsletter from './Newsletter.vue';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useMotion } from '@vueuse/motion';
import { Head } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

import {
  BookOpenIcon,
  CodeIcon,
  PaletteIcon,
  TrendingUpIcon,
  ServerIcon,
  SearchIcon,
  ArrowRightIcon,
  ChevronLeftIcon,
  ChevronRightIcon,
  XIcon
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

const props = defineProps({
  blogPosts: Object,
  categories: Array,
  featuredPost: Object,
  filters: Object
});

const searchQuery = ref(props.filters?.search || '');
const activeCategory = computed(() => props.filters?.category || 'all');
const hasActiveFilters = computed(() =>
  (activeCategory.value && activeCategory.value !== 'all') || props.filters?.search
);
const isSearching = ref(false);

// Enhanced search function with progressive enhancement
const handleSearchSubmit = (event) => {
  if (typeof router !== 'undefined') {
    event.preventDefault();
    isSearching.value = true;

    const params = {};

    if (searchQuery.value && searchQuery.value.trim()) {
      params.search = searchQuery.value.trim();
    }

    if (activeCategory.value && activeCategory.value !== 'all') {
      params.category = activeCategory.value;
    }

    router.get(route('blog'), params, {
      preserveState: true,
      replace: true,
      onFinish: () => {
        isSearching.value = false;
      },
      onError: (errors) => {
        console.error('Search error:', errors);
        isSearching.value = false;
      }
    });
  }
};

// URL building helpers
const buildCategoryUrl = (categoryId) => {
  const params = {};
  if (categoryId !== 'all') {
    params.category = categoryId;
  }
  if (props.filters?.search) {
    params.search = props.filters.search;
  }
  return route('blog', params);
};

const buildClearCategoryUrl = () => {
  const params = {};
  if (props.filters?.search) {
    params.search = props.filters.search;
  }
  return route('blog', params);
};

const buildClearSearchUrl = () => {
  const params = {};
  if (activeCategory.value && activeCategory.value !== 'all') {
    params.category = activeCategory.value;
  }
  return route('blog', params);
};

// Helper functions
const getCategoryName = (slug) => {
  const category = props.categories.find(cat => cat.id === slug);
  return category ? category.name : slug;
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  }).format(date);
};

const getInitials = (name) => {
  if (!name) return '?';
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2);
};

const iconMap = {
  'CodeIcon': CodeIcon,
  'PaletteIcon': PaletteIcon,
  'TrendingUpIcon': TrendingUpIcon,
  'ServerIcon': ServerIcon,
  'BookOpenIcon': BookOpenIcon
};

const getCategoryIcon = (category) => {
  return iconMap[category.icon] || BookOpenIcon;
};
</script>

<style scoped>
/* Animation for card entry */
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

/* Hover effect for blog cards */
.card-hover-effect:hover {
  transform: translateY(-5px);
}

/* Gradient overlay animation */
.gradient-overlay {
  background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 100%);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.card:hover .gradient-overlay {
  opacity: 1;
}

/* Custom animation for featured badge */
@keyframes pulse {

  0%,
  100% {
    transform: scale(1);
  }

  50% {
    transform: scale(1.05);
  }
}

.featured-badge {
  animation: pulse 2s infinite;
}

/* Reduce animations for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
</style>
