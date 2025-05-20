<template>
  <PublicLayout>
  <div class="relative min-h-screen">
    <!-- SEO Head -->
    <Head>
      <title>Our Book Collection | Discover Amazing Reads</title>
      <meta name="description" content="Browse our curated collection of books across various genres. Find your next favorite read today!" />
      <meta name="keywords" content="books, reading, literature, collection, library" />
      <meta property="og:title" content="Our Book Collection" />
      <meta property="og:description" content="Browse our curated collection of books across various genres." />
      <meta property="og:type" content="website" />
    </Head>

    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden -z-10">
      <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-primary/5 to-transparent"></div>
      <div class="absolute -top-20 -left-20 w-72 h-72 bg-primary/10 rounded-full filter blur-3xl opacity-70"></div>
      <div class="absolute top-40 right-10 w-36 h-36 bg-primary/10 rounded-full filter blur-3xl opacity-50"></div>
      <div class="absolute bottom-20 left-1/4 w-48 h-48 bg-primary/10 rounded-full filter blur-3xl opacity-60"></div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-7xl relative z-10">
      <!-- Header with animation -->
      <div
        class="mb-16 text-center"
        v-motion
        :initial="{ opacity: 0, y: 50 }"
        :enter="{ opacity: 1, y: 0, transition: { duration: 600 } }"
      >
        <div class="inline-block mb-4">
          <div class="relative">
            <div class="absolute inset-0 bg-primary/20 blur-xl rounded-full transform -translate-y-1/4 scale-150"></div>
            <BookOpen class="h-16 w-16 text-primary relative z-10 mx-auto" />
          </div>
        </div>
        <h1 class="text-5xl font-bold tracking-tight mb-3 bg-clip-text text-transparent bg-gradient-to-r from-primary to-primary/70">
          Our Book Collection
        </h1>
        <p class="text-muted-foreground max-w-2xl mx-auto text-lg">
          Discover your next favorite read from our carefully curated collection
        </p>
      </div>

      <!-- Interactive Search and Filter Panel -->
      <div
        class="mb-12 relative"
        v-motion
        :initial="{ opacity: 0, y: 30 }"
        :enter="{ opacity: 1, y: 0, transition: { delay: 200, duration: 500 } }"
      >
        <div class="absolute inset-0 bg-card/80 backdrop-blur-sm rounded-xl -z-10"></div>
        <div class="border border-border/40 rounded-xl p-6 shadow-lg">
          <div class="flex flex-col md:flex-row gap-6 items-start">
            <!-- Search with animation -->
            <div class="relative w-full md:w-1/2 group">
              <div class="absolute inset-0 bg-primary/5 rounded-md blur-sm group-focus-within:bg-primary/10 transition-all duration-300"></div>
              <Input
                v-model="searchQuery"
                placeholder="Search by title, author, or keyword..."
                class="pl-10 pr-4 py-6 text-lg bg-transparent relative z-10 border-muted/50 focus:border-primary/50"
              />
              <Search class="absolute left-3 top-3.5 h-5 w-5 text-muted-foreground group-focus-within:text-primary transition-colors duration-300" />
              <Button
                v-if="searchQuery"
                variant="ghost"
                size="sm"
                class="absolute right-2 top-2.5 h-8 w-8 p-0"
                @click="clearSearch"
              >
                <X class="h-4 w-4" />
                <span class="sr-only">Clear search</span>
              </Button>
            </div>

            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-1/2">
              <div class="w-full sm:w-1/2">
                <Label for="sort-by" class="text-sm font-medium mb-1.5 block text-muted-foreground">Sort by</Label>
                <Select v-model="sortBy">
                  <SelectTrigger id="sort-by" class="w-full">
                    <SelectValue placeholder="Sort by" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="title_asc">Title (A-Z)</SelectItem>
                    <SelectItem value="title_desc">Title (Z-A)</SelectItem>
                    <SelectItem value="popular">Most Popular</SelectItem>
                    <SelectItem value="newest">Newest First</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div class="w-full sm:w-1/2">
                <Label for="filter-by" class="text-sm font-medium mb-1.5 block text-muted-foreground">Filter by</Label>
                <Select v-model="filterBy">
                  <SelectTrigger id="filter-by" class="w-full">
                    <SelectValue placeholder="All Books" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="all">All Books</SelectItem>
                    <SelectItem value="featured">Featured Only</SelectItem>
                    <SelectItem value="popular">Popular (100+ downloads)</SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>
          </div>

          <!-- Active filters -->
          <div v-if="hasActiveFilters" class="mt-4 flex flex-wrap gap-2">
            <Badge
              v-if="searchQuery"
              variant="outline"
              class="px-3 py-1 bg-primary/5 hover:bg-primary/10"
            >
              Search: {{ searchQuery }}
              <Button variant="ghost" size="sm" class="h-4 w-4 p-0 ml-1" @click="clearSearch">
                <X class="h-3 w-3" />
              </Button>
            </Badge>

            <Badge
              v-if="sortBy !== 'title_asc'"
              variant="outline"
              class="px-3 py-1 bg-primary/5 hover:bg-primary/10"
            >
              Sort: {{ getSortLabel(sortBy) }}
              <Button variant="ghost" size="sm" class="h-4 w-4 p-0 ml-1" @click="resetSort">
                <X class="h-3 w-3" />
              </Button>
            </Badge>

            <Badge
              v-if="filterBy !== 'all'"
              variant="outline"
              class="px-3 py-1 bg-primary/5 hover:bg-primary/10"
            >
              Filter: {{ getFilterLabel(filterBy) }}
              <Button variant="ghost" size="sm" class="h-4 w-4 p-0 ml-1" @click="resetFilter">
                <X class="h-3 w-3" />
              </Button>
            </Badge>

            <Button v-if="hasActiveFilters" variant="ghost" size="sm" class="text-xs" @click="resetAllFilters">
              Clear all filters
            </Button>
          </div>
        </div>
      </div>

      <!-- Results summary -->
      <div
        class="mb-6 flex justify-between items-center"
        v-motion
        :initial="{ opacity: 0 }"
        :enter="{ opacity: 1, transition: { delay: 300, duration: 300 } }"
      >
        <p class="text-muted-foreground">
          Showing <span class="font-medium text-foreground">{{ filteredBooks.length }}</span>
          {{ filteredBooks.length === 1 ? 'book' : 'books' }}
          <span v-if="searchQuery"> for "<span class="text-primary font-medium">{{ searchQuery }}</span>"</span>
        </p>

        <div class="flex gap-2">
          <Button
            variant="ghost"
            size="sm"
            class="h-8 w-8 p-0"
            :class="{ 'text-primary': viewMode === 'grid' }"
            @click="viewMode = 'grid'"
          >
            <LayoutGrid class="h-4 w-4" />
            <span class="sr-only">Grid view</span>
          </Button>
          <Button
            variant="ghost"
            size="sm"
            class="h-8 w-8 p-0"
            :class="{ 'text-primary': viewMode === 'list' }"
            @click="viewMode = 'list'"
          >
            <List class="h-4 w-4" />
            <span class="sr-only">List view</span>
          </Button>
        </div>
      </div>

      <!-- Book grid with staggered animation -->
      <div
        v-if="viewMode === 'grid'"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        v-motion
        :initial="{ opacity: 0 }"
        :enter="{ opacity: 1, transition: { duration: 500 } }"
      >
        <div
          v-for="(book, index) in paginatedBooks"
          :key="book.id"
          v-motion
          :initial="{ opacity: 0, y: 30 }"
          :enter="{ opacity: 1, y: 0, transition: { delay: 100 + (index % 8) * 50, duration: 400 } }"
          class="group"
        >
          <Card class="overflow-hidden h-full border-border/40 bg-card/80 backdrop-blur-sm hover:shadow-xl transition-all duration-500 hover:shadow-primary/5 hover:border-primary/20">
            <Link :href="`/books/${book.slug}`" class="h-full flex flex-col">
              <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                <img
                  :src="book.cover_image ? `/storage/${book.cover_image}` : '/images/default-book-cover.jpg'"
                  :alt="book.title"
                  class="w-full h-56 object-cover transition-transform duration-700 group-hover:scale-110"
                >
                <Badge
                  v-if="book.featured"
                  class="absolute top-2 right-2 bg-primary text-primary-foreground z-20"
                >
                  <Star class="h-3 w-3 mr-1 fill-current" />
                  Featured
                </Badge>

                <div class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                  <Button size="sm" variant="secondary" class="w-full gap-1">
                    <Eye class="h-3.5 w-3.5" />
                    Quick View
                  </Button>
                </div>
              </div>

              <CardContent class="flex-grow p-5">
                <h3 class="font-bold text-lg mb-1 line-clamp-1 group-hover:text-primary transition-colors duration-300">
                  {{ book.title }}
                </h3>
                <p class="text-muted-foreground flex items-center text-sm">
                  <User class="h-3 w-3 mr-1" />
                  {{ book.author }}
                </p>

                <div class="mt-3 pt-3 border-t border-border/40 flex justify-between items-center">
                  <span class="text-sm text-muted-foreground flex items-center">
                    <Download class="h-3 w-3 mr-1" />
                    {{ formatNumber(book.download_count) }}
                  </span>
                  <Button variant="ghost" size="sm" class="p-0 h-8 w-8 hover:text-primary">
                    <BookmarkPlus class="h-4 w-4" />
                    <span class="sr-only">Save for later</span>
                  </Button>
                </div>
              </CardContent>
            </Link>
          </Card>
        </div>
      </div>

      <!-- Book list view -->
      <div
        v-else
        class="space-y-4"
        v-motion
        :initial="{ opacity: 0 }"
        :enter="{ opacity: 1, transition: { duration: 500 } }"
      >
        <div
          v-for="(book, index) in paginatedBooks"
          :key="book.id"
          v-motion
          :initial="{ opacity: 0, x: -20 }"
          :enter="{ opacity: 1, x: 0, transition: { delay: 100 + (index % 8) * 50, duration: 400 } }"
        >
          <Card class="overflow-hidden border-border/40 bg-card/80 backdrop-blur-sm hover:shadow-md transition-all duration-300 hover:border-primary/20">
            <Link :href="`/books/${book.slug}`" class="flex flex-col sm:flex-row">
              <div class="relative sm:w-48 h-48">
                <img
                  :src="book.cover_image ? `/storage/${book.cover_image}` : '/images/default-book-cover.jpg'"
                  :alt="book.title"
                  class="w-full h-full object-cover"
                >
                <Badge
                  v-if="book.featured"
                  class="absolute top-2 right-2 bg-primary text-primary-foreground"
                >
                  <Star class="h-3 w-3 mr-1 fill-current" />
                  Featured
                </Badge>
              </div>

              <CardContent class="flex-grow p-5">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between">
                  <div>
                    <h3 class="font-bold text-lg mb-1 hover:text-primary transition-colors duration-300">
                      {{ book.title }}
                    </h3>
                    <p class="text-muted-foreground flex items-center text-sm mb-2">
                      <User class="h-3 w-3 mr-1" />
                      {{ book.author }}
                    </p>
                    <p class="text-sm text-muted-foreground line-clamp-2 mb-3">
                      {{ book.description_excerpt || 'No description available.' }}
                    </p>
                  </div>

                  <div class="flex sm:flex-col items-center sm:items-end gap-4 sm:gap-2 mt-3 sm:mt-0">
                    <span class="text-sm text-muted-foreground flex items-center">
                      <Download class="h-3 w-3 mr-1" />
                      {{ formatNumber(book.download_count) }}
                    </span>
                    <Button variant="outline" size="sm" class="gap-1">
                      <BookOpen class="h-3.5 w-3.5" />
                      View Details
                    </Button>
                  </div>
                </div>
              </CardContent>
            </Link>
          </Card>
        </div>
      </div>

      <!-- Empty state -->
      <div
        v-if="filteredBooks.length === 0"
        class="text-center py-16 px-4 border border-dashed border-border/60 rounded-xl bg-card/50 backdrop-blur-sm"
      >
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 mb-4">
          <BookX class="h-8 w-8 text-primary" />
        </div>
        <h3 class="text-xl font-medium mb-2">No books found</h3>
        <p class="text-muted-foreground mb-6 max-w-md mx-auto">
          We couldn't find any books matching your search criteria. Try adjusting your filters or search terms.
        </p>
        <Button @click="resetAllFilters">Clear all filters</Button>
      </div>

      <!-- Pagination -->
      <div
        v-if="filteredBooks.length > 0"
        class="mt-12"
        v-motion
        :initial="{ opacity: 0 }"
        :enter="{ opacity: 1, transition: { delay: 400, duration: 300 } }"
      >
        <div class="flex items-center justify-between">
          <p class="text-sm text-muted-foreground">
            Showing <span class="font-medium">{{ startItem }}</span> to
            <span class="font-medium">{{ endItem }}</span> of
            <span class="font-medium">{{ filteredBooks.length }}</span> books
          </p>

          <div class="flex items-center space-x-2">
            <Button
              variant="outline"
              size="sm"
              :disabled="currentPage === 1"
              @click="currentPage--"
            >
              <ChevronLeft class="h-4 w-4 mr-1" />
              Previous
            </Button>

            <div class="flex items-center">
              <Button
                v-for="page in totalPages"
                :key="page"
                variant="ghost"
                size="sm"
                :class="{ 'bg-primary/10 text-primary': currentPage === page }"
                @click="currentPage = page"
              >
                {{ page }}
              </Button>
            </div>

            <Button
              variant="outline"
              size="sm"
              :disabled="currentPage === totalPages"
              @click="currentPage++"
            >
              Next
              <ChevronRight class="h-4 w-4 ml-1" />
            </Button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </PublicLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { useMotion } from '@vueuse/motion';
import PublicLayout from '@/layouts/PublicLayout.vue';
// import {
//   Badge, Button, Card, CardContent, Input, Label,
//   Select, SelectContent, SelectItem, SelectTrigger, SelectValue
// } from '@/components/ui';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import {
  BookOpen, BookX, BookmarkPlus, ChevronLeft, ChevronRight, Download,
  Eye, LayoutGrid, List, Search, Star, User, X
} from 'lucide-vue-next';

const props = defineProps({
  books: Object,
});

// Reactive state
const searchQuery = ref('');
const sortBy = ref('title_asc');
const filterBy = ref('all');
const viewMode = ref('grid');
const currentPage = ref(1);
const itemsPerPage = ref(8);

// Reset functions
const clearSearch = () => {
  searchQuery.value = '';
};

const resetSort = () => {
  sortBy.value = 'title_asc';
};

const resetFilter = () => {
  filterBy.value = 'all';
};

const resetAllFilters = () => {
  clearSearch();
  resetSort();
  resetFilter();
};

// Helper functions for labels
const getSortLabel = (sort) => {
  const labels = {
    'title_asc': 'Title (A-Z)',
    'title_desc': 'Title (Z-A)',
    'popular': 'Most Popular',
    'newest': 'Newest First'
  };
  return labels[sort] || 'Unknown';
};

const getFilterLabel = (filter) => {
  const labels = {
    'all': 'All Books',
    'featured': 'Featured Only',
    'popular': 'Popular (100+ downloads)'
  };
  return labels[filter] || 'Unknown';
};

// Filter and sort books
const filteredBooks = computed(() => {
  let result = [...props.books.data];

  // Apply search filter
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    result = result.filter(book =>
      book.title.toLowerCase().includes(query) ||
      book.author.toLowerCase().includes(query)
    );
  }

  // Apply category filter
  if (filterBy.value === 'featured') {
    result = result.filter(book => book.featured);
  } else if (filterBy.value === 'popular') {
    result = result.filter(book => book.download_count >= 100);
  }

  // Apply sorting
  if (sortBy.value === 'title_asc') {
    result.sort((a, b) => a.title.localeCompare(b.title));
  } else if (sortBy.value === 'title_desc') {
    result.sort((a, b) => b.title.localeCompare(a.title));
  } else if (sortBy.value === 'popular') {
    result.sort((a, b) => b.download_count - a.download_count);
  } else if (sortBy.value === 'newest') {
    result.sort((a, b) => new Date(b.published_date) - new Date(a.published_date));
  }

  return result;
});

// Pagination
const totalPages = computed(() => {
  return Math.ceil(filteredBooks.value.length / itemsPerPage.value);
});

const paginatedBooks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredBooks.value.slice(start, end);
});

const startItem = computed(() => {
  return (currentPage.value - 1) * itemsPerPage.value + 1;
});

const endItem = computed(() => {
  return Math.min(currentPage.value * itemsPerPage.value, filteredBooks.value.length);
});

// Reset to page 1 when filters change
watch([searchQuery, sortBy, filterBy], () => {
  currentPage.value = 1;
});

// Check if any filters are active
const hasActiveFilters = computed(() => {
  return searchQuery.value !== '' || sortBy.value !== 'title_asc' || filterBy.value !== 'all';
});

// Format number with commas
const formatNumber = (num) => {
  if (!num) return '0';
  return new Intl.NumberFormat().format(num);
};
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Animation for the background blobs */
@keyframes float {
  0% { transform: translateY(0px) translateX(0px); }
  50% { transform: translateY(-10px) translateX(10px); }
  100% { transform: translateY(0px) translateX(0px); }
}

.animate-float {
  animation: float 8s ease-in-out infinite;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: hsl(var(--secondary));
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: hsl(var(--primary) / 0.3);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: hsl(var(--primary) / 0.5);
}
</style>
