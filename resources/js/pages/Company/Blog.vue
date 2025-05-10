<template>

  <Head title="Blog" />
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
          <div class="relative w-full md:w-72">
            <SearchIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            <Input type="search" placeholder="Search articles..." class="pl-10" v-model="searchQuery"
              @input="currentPage = 1" v-motion :initial="{ scale: 0.95, opacity: 0 }"
              :enter="{ scale: 1, opacity: 1, transition: { duration: 400, delay: 300 } }" />
          </div>
          <div class="flex flex-wrap gap-2 justify-center md:justify-end">
            <Button v-for="(category, index) in categories" :key="category.id"
              :variant="activeCategory === category.id ? 'default' : 'outline'" size="sm"
              @click="setCategory(category.id)" class="transition-all duration-300 hover:scale-105" v-motion
              :initial="{ scale: 0.9, opacity: 0 }"
              :enter="{ scale: 1, opacity: 1, transition: { duration: 400, delay: 300 + (index * 50) } }">
              <component :is="getCategoryIcon(category)" class="h-4 w-4 mr-2" />
              {{ category.name }}
            </Button>
          </div>
        </div>

        <!-- Featured Post -->
        <div v-if="featuredPost && !searchQuery" v-motion :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 800 } }" class="mb-12">
          <Card
            class="overflow-hidden group border-border/40 hover:border-primary/30 transition-all duration-500 hover:shadow-lg hover:shadow-primary/10">
            <div class="grid md:grid-cols-2 gap-0">
              <div class="relative overflow-hidden aspect-video md:aspect-auto">
                <img :src="featuredPost.image || '/placeholder.svg?height=400&width=600'" :alt="featuredPost.title"
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
                    <span class="text-xs text-muted-foreground">{{ formatDate(featuredPost.date) }}</span>
                  </div>
                  <h3 class="text-2xl font-bold mb-3 group-hover:text-primary transition-colors duration-300">{{
                    featuredPost.title }}</h3>
                  <div class="prose prose-sm text-muted-foreground mb-6 max-w-none" v-html="featuredPost.excerpt"></div>
                </div>
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <Avatar class="h-10 w-10">
                      <AvatarImage :src="featuredPost.author.avatar || '/placeholder.svg?height=40&width=40'"
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
          <!-- Render all filtered posts directly without pagination for debugging -->
          <div v-for="(post, index) in displayedPosts" :key="post.id" v-motion :initial="{ opacity: 0, y: 30 }"
            :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 100 + (index * 100) } }" class="group">
            <Card
              class="overflow-hidden h-full border-border/40 transition-all duration-500 hover:shadow-lg hover:shadow-primary/10 hover:border-primary/30 hover:-translate-y-1">
              <div class="relative overflow-hidden aspect-video">
                <Link :href="`/agency/blog/${post.slug}`" class="block">
                <img :src="post.image || '/placeholder.svg?height=300&width=500'" :alt="post.title"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
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
                    {{ formatDate(post.date) }}
                  </Badge>
                </div>
              </div>
              <CardContent class="p-5">
                <Link :href="`/agency/blog/${post.slug}`" class="block">
                <h3 class="font-bold text-xl mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-2">
                  {{ post.title }}</h3>
                </Link>
                <div class="prose prose-sm text-muted-foreground mb-6 max-w-none" v-html="post.excerpt"></div>
              </CardContent>
              <CardFooter class="px-5 pb-5 pt-0 flex justify-between items-center">
                <div class="flex items-center gap-2">
                  <Avatar class="h-8 w-8">
                    <AvatarImage :src="post.author.avatar || '/placeholder.svg?height=32&width=32'"
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
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="filteredPosts.length === 0" class="text-center py-16" v-motion :initial="{ opacity: 0, scale: 0.9 }"
          :enter="{ opacity: 1, scale: 1, transition: { type: 'spring', stiffness: 300, damping: 25 } }">
          <div class="inline-block p-4 rounded-full bg-primary/10 mb-4">
            <BookOpenIcon class="h-8 w-8 text-primary" />
          </div>
          <h3 class="text-xl font-bold mb-2">No posts found</h3>
          <p class="text-muted-foreground">Try adjusting your search or filter criteria</p>
          <Button @click="resetFilters" variant="outline" class="mt-4">
            Reset Filters
          </Button>
        </div>

        <!-- Simplified Pagination -->
        <div v-if="filteredPosts.length > postsPerPage" v-motion :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 400 } }" class="mt-12 flex justify-center">
          <div class="flex items-center gap-2">
            <Button variant="outline" size="icon" :disabled="currentPage === 1" @click="currentPage--">
              <ChevronLeftIcon class="h-4 w-4" />
            </Button>

            <Button v-for="page in totalPages" :key="page" variant="outline" size="sm"
              :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': currentPage === page }"
              @click="currentPage = page">
              {{ page }}
            </Button>

            <Button variant="outline" size="icon" :disabled="currentPage === totalPages" @click="currentPage++">
              <ChevronRightIcon class="h-4 w-4" />
            </Button>
          </div>
        </div>

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
import { ref, computed, onMounted, watch, nextTick } from 'vue';
import { usePage } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { useMotion } from '@vueuse/motion';
import { Head } from '@inertiajs/vue3';

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
  SendIcon,
  MailIcon
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

// Get data from Inertia props
const page = usePage();
const props = page.props;

// Blog categories from backend
const categories = ref(props.categories || []);

// Blog posts from backend - ensure we have a copy to avoid reactivity issues
const blogPosts = ref([...(props.blogPosts || [])]);

// Featured post from backend
const featuredPost = ref(props.featuredPost || null);

const activeCategory = ref('all');
const searchQuery = ref('');

// Pagination state - simplified
const currentPage = ref(1);
const postsPerPage = ref(6); // Number of posts to show per page

// Set category and reset pagination
const setCategory = (categoryId) => {
  activeCategory.value = categoryId;
  currentPage.value = 1;
};

// Reset all filters
const resetFilters = () => {
  activeCategory.value = 'all';
  searchQuery.value = '';
  currentPage.value = 1;
};

// Format date helper
const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  }).format(date);
};

// Get initials helper
const getInitials = (name) => {
  if (!name) return '?';
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2);
};

// Get icon component from category
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

// Filter posts based on active category and search query
const filteredPosts = computed(() => {
  // Make sure we have posts to filter
  if (!blogPosts.value || blogPosts.value.length === 0) {
    console.warn('No blog posts available to filter');
    return [];
  }

  let filtered = [...blogPosts.value];

  // Filter by category
  if (activeCategory.value !== 'all') {
    filtered = filtered.filter(post => {
      // Handle potential undefined category
      if (!post.category) return false;
      return post.category.toLowerCase() === activeCategory.value.toLowerCase();
    });
  }

  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(post =>
      (post.title && post.title.toLowerCase().includes(query)) ||
      (post.excerpt && post.excerpt.toLowerCase().includes(query)) ||
      (post.category && post.category.toLowerCase().includes(query))
    );
  }

  console.log('Filtered posts:', filtered.length);
  return filtered;
});

// Total pages calculation
const totalPages = computed(() => {
  return Math.max(1, Math.ceil(filteredPosts.value.length / postsPerPage.value));
});

// Get posts for current page - simplified approach
const displayedPosts = computed(() => {
  const startIndex = (currentPage.value - 1) * postsPerPage.value;
  const endIndex = startIndex + postsPerPage.value;
  const posts = filteredPosts.value.slice(startIndex, endIndex);
  console.log(`Displaying posts ${startIndex} to ${endIndex}:`, posts.length);
  return posts;
});

// Watch for changes in filtered posts to reset pagination if needed
watch(filteredPosts, (newPosts) => {
  if (currentPage.value > Math.ceil(newPosts.length / postsPerPage.value)) {
    currentPage.value = 1;
  }
});

// Log data on mount for debugging
onMounted(() => {
  console.log('Blog component mounted');
  console.log('Total posts:', blogPosts.value.length);
  console.log('Categories:', categories.value);

  // Force a re-render to ensure all posts are displayed
  nextTick(() => {
    console.log('After nextTick - Displayed posts:', displayedPosts.value.length);
  });
});
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
