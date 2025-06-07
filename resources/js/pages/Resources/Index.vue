<template>
  <Head title="Resources" />
  <PublicLayout>
    <div class="py-12">
      <div class="container px-4 mx-auto">
        <!-- Header -->
        <div class="mb-10">
          <h1 class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
            Resources & <span class="text-primary">Insights</span>
          </h1>
          <p class="text-muted-foreground max-w-3xl">
            Browse our collection of articles, tutorials, case studies, and more to stay updated with the latest in technology and development.
          </p>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
          <!-- Categories -->
          <div class="flex flex-wrap gap-2">
            <Link
              href="/our-resources"
              class="px-4 py-2 rounded-full text-sm font-medium inline-flex items-center transition-colors"
              :class="!activeCategory ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground hover:bg-muted/80'"
            >
              <NewspaperIcon class="h-4 w-4 mr-2" />
              All
            </Link>
            <Link
              v-for="category in categories"
              :key="category.id"
              :href="buildCategoryUrl(category.slug)"
              class="px-4 py-2 rounded-full text-sm font-medium inline-flex items-center transition-colors"
              :class="activeCategory === category.slug ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground hover:bg-muted/80'"
            >
              <component :is="getCategoryIcon(category.icon)" class="h-4 w-4 mr-2" />
              {{ category.name }}
            </Link>
          </div>

          <!-- Search Form - Now uses regular form submission for SEO -->
          <div class="relative w-full md:w-64 lg:w-72">
            <form
              method="GET"
              action="/our-resources"
              @submit="handleSearchSubmit"
              ref="searchForm"
            >
              <!-- Preserve current category filter -->
              <input
                v-if="activeCategory"
                type="hidden"
                name="category"
                :value="activeCategory"
              >

              <div class="relative">
                <SearchIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                <input
                  type="text"
                  name="search"
                  placeholder="Search resources..."
                  v-model="searchQuery"
                  class="w-full pl-10 pr-4 py-2 rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
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
        </div>

        <!-- Active Filters Display -->
        <div v-if="hasActiveFilters" class="flex flex-wrap items-center gap-2 mb-6 p-4 bg-muted/50 rounded-lg">
          <span class="text-sm font-medium text-muted-foreground">Active filters:</span>

          <div v-if="activeCategory" class="flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary rounded-full text-sm">
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
            href="/our-resources"
            class="text-sm text-muted-foreground hover:text-foreground underline"
          >
            Clear all filters
          </Link>
        </div>

        <!-- Results Summary -->
        <div class="mb-6">
          <p class="text-sm text-muted-foreground">
            <template v-if="hasActiveFilters">
              Found {{ resources.total }} resource{{ resources.total !== 1 ? 's' : '' }}
              <template v-if="filters.search">matching "{{ filters.search }}"</template>
              <template v-if="activeCategory">in {{ getCategoryName(activeCategory) }}</template>
            </template>
            <template v-else>
              Showing all {{ resources.total }} resources
            </template>
          </p>
        </div>

        <!-- Resources Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
          <div
            v-for="resource in resources.data"
            :key="resource.id"
            class="article-card group"
          >
            <article class="bg-card rounded-xl overflow-hidden border border-border shadow-sm h-full flex flex-col transition-all duration-300 hover:shadow-md hover:border-primary/20">
              <div class="relative aspect-video overflow-hidden">
                <img
                  :src="resource.featured_image_url || '/placeholder.svg?height=600&width=800'"
                  :alt="resource.title"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                  loading="lazy"
                />
                <div class="absolute top-4 left-4">
                  <span class="px-2 py-1 bg-background/80 backdrop-blur-sm text-xs rounded-md">
                    {{ resource.category?.name || 'Uncategorized' }}
                  </span>
                </div>
                <div class="absolute top-4 right-4 flex space-x-1">
                  <button
                    class="p-1.5 bg-background/80 backdrop-blur-sm rounded-full text-muted-foreground hover:text-foreground transition-colors"
                    :aria-label="`Bookmark ${resource.title}`"
                  >
                    <BookmarkIcon class="h-4 w-4" />
                  </button>
                  <button
                    class="p-1.5 bg-background/80 backdrop-blur-sm rounded-full text-muted-foreground hover:text-foreground transition-colors"
                    :aria-label="`Share ${resource.title}`"
                  >
                    <ShareIcon class="h-4 w-4" />
                  </button>
                </div>
              </div>

              <div class="p-6 flex flex-col flex-grow">
                <div class="mb-4">
                  <h2 class="text-xl font-semibold mb-2 group-hover:text-primary transition-colors duration-300">
                    {{ resource.title }}
                  </h2>
                  <p class="text-muted-foreground text-sm">{{ resource.excerpt }}</p>
                </div>

                <div class="mt-auto pt-4 border-t border-border flex items-center justify-between">
                  <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2">
                      <UserIcon class="h-4 w-4 text-primary" />
                    </div>
                    <div>
                      <p class="text-xs font-medium">{{ resource.user?.name || 'Admin' }}</p>
                      <time class="text-xs text-muted-foreground" :datetime="resource.published_at">
                        {{ formatDate(resource.published_at) }}
                      </time>
                    </div>
                  </div>
                  <div class="flex items-center text-xs text-muted-foreground">
                    <ClockIcon class="h-3 w-3 mr-1" />
                    {{ estimateReadTime(resource.body) }} min read
                  </div>
                </div>
              </div>

              <Link
                :href="`/resources/${resource.slug}`"
                class="absolute inset-0 z-10"
                :aria-label="`Read full article: ${resource.title}`"
              >
                <span class="sr-only">Read {{ resource.title }}</span>
              </Link>
            </article>
          </div>
        </div>

        <!-- No Results -->
        <div v-if="resources.data.length === 0" class="text-center py-12">
          <div class="max-w-md mx-auto">
            <SearchIcon class="h-12 w-12 text-muted-foreground mx-auto mb-4" />
            <h3 class="text-lg font-semibold mb-2">No resources found</h3>
            <p class="text-muted-foreground mb-4">
              <template v-if="hasActiveFilters">
                Try adjusting your search terms or filters to find what you're looking for.
              </template>
              <template v-else>
                No resources have been published yet. Check back soon!
              </template>
            </p>
            <Link
              v-if="hasActiveFilters"
              href="/resources"
              class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
              View all resources
            </Link>
          </div>
        </div>

        <!-- Pagination -->
        <nav v-if="resources.data.length > 0" class="flex justify-between items-center" aria-label="Pagination">
          <div class="text-sm text-muted-foreground">
            Showing {{ resources.from }} to {{ resources.to }} of {{ resources.total }} resources
          </div>

          <div class="flex gap-2">
            <Link
              v-if="resources.prev_page_url"
              :href="resources.prev_page_url"
              class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2"
              rel="prev"
            >
              <ChevronLeftIcon class="h-4 w-4 mr-1" />
              Previous
            </Link>

            <Link
              v-if="resources.next_page_url"
              :href="resources.next_page_url"
              class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2"
              rel="next"
            >
              Next
              <ChevronRightIcon class="h-4 w-4 ml-1" />
            </Link>
          </div>
        </nav>

        <!-- Newsletter Subscription -->
        <Newsletter class="mt-16 md:mt-24"/>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Newsletter from '../Company/Newsletter.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';

import {
  SearchIcon, UserIcon, ArrowRightIcon, BookmarkIcon, ShareIcon,
  ClockIcon, ChevronLeftIcon, ChevronRightIcon, NewspaperIcon,
  LightbulbIcon, CodeIcon, TrendingUpIcon, GraduationCapIcon,
  RocketIcon, XIcon
} from 'lucide-vue-next';

const props = defineProps({
  resources: Object,
  categories: Array,
  filters: Object
});

const searchQuery = ref(props.filters?.search || '');
const activeCategory = computed(() => props.filters?.category || null);
const hasActiveFilters = computed(() => activeCategory.value || props.filters?.search);
const isSearching = ref(false);

// Enhanced search function with progressive enhancement
const handleSearchSubmit = (event) => {
  // Only prevent default if JavaScript is enabled and Inertia is available
  if (typeof router !== 'undefined') {
    event.preventDefault();
    isSearching.value = true;

    const params = {
      search: searchQuery.value || undefined,
      category: activeCategory.value || undefined
    };

    // Remove undefined values
    Object.keys(params).forEach(key => {
      if (params[key] === undefined) {
        delete params[key];
      }
    });

    router.get('/our-resources', params, {
      preserveState: true,
      replace: true,
      onFinish: () => {
        isSearching.value = false;
      }
    });
  }
  // If JavaScript is disabled, form will submit normally
};

// URL building helpers for better SEO
const buildCategoryUrl = (categorySlug) => {
  const params = new URLSearchParams();
  params.set('category', categorySlug);
  if (props.filters?.search) {
    params.set('search', props.filters.search);
  }
  return `/our-resources?${params.toString()}`;
};

const buildClearCategoryUrl = () => {
  if (props.filters?.search) {
    return `/our-resources?search=${encodeURIComponent(props.filters.search)}`;
  }
  return '/our-resources';
};

const buildClearSearchUrl = () => {
  if (activeCategory.value) {
    return `/our-resources?category=${activeCategory.value}`;
  }
  return '/our-resources';
};

// Helper functions
const getCategoryName = (slug) => {
  const category = props.categories.find(cat => cat.slug === slug);
  return category ? category.name : slug;
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const estimateReadTime = (content) => {
  if (!content) return 3;
  const wordsPerMinute = 200;
  const textLength = content.split(' ').length;
  return Math.max(1, Math.ceil(textLength / wordsPerMinute));
};

const getCategoryIcon = (iconName) => {
  const iconMap = {
    'lightbulb': LightbulbIcon,
    'code': CodeIcon,
    'trending-up': TrendingUpIcon,
    'newspaper': NewspaperIcon,
    'graduation-cap': GraduationCapIcon,
    'rocket': RocketIcon
  };

  return iconMap[iconName] || NewspaperIcon;
};
</script>

<style scoped>
.article-card {
  animation: fadeInUp 0.6s ease-out forwards;
  opacity: 0;
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

.article-card:nth-child(3n+1) { animation-delay: 0.1s; }
.article-card:nth-child(3n+2) { animation-delay: 0.2s; }
.article-card:nth-child(3n+3) { animation-delay: 0.3s; }
</style>
