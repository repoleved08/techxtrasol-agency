<template>
  <PublicLayout>
    <div class="container mx-auto px-4 py-12">
      <div class="max-w-5xl mx-auto" v-motion :initial="{ opacity: 0, y: 50 }"
        :enter="{ opacity: 1, y: 0, transition: { duration: 600 } }">
        <!-- Book Hero Section with Glassmorphism -->
        <div class="relative mb-16">
          <!-- Background Gradient Elements -->
          <div
            class="absolute -top-20 -left-20 w-72 h-72 bg-primary/20 rounded-full filter blur-3xl opacity-70 animate-blob">
          </div>
          <div
            class="absolute -bottom-20 -right-20 w-72 h-72 bg-primary/30 rounded-full filter blur-3xl opacity-70 animate-blob animation-delay-2000">
          </div>

          <div class="relative flex flex-col md:flex-row gap-8 md:gap-12 backdrop-blur-sm">
            <!-- Book Cover with Animation -->
            <div class="md:w-1/3" v-motion :initial="{ opacity: 0, x: -50 }"
              :enter="{ opacity: 1, x: 0, transition: { delay: 200, duration: 600 } }">
              <div class="relative group">
                <div
                  class="absolute -inset-1 bg-gradient-to-r from-primary/30 to-primary/50 rounded-xl blur-lg opacity-0 group-hover:opacity-100 transition-all duration-500">
                </div>
                <div class="relative aspect-[2/3] overflow-hidden rounded-xl shadow-xl">
                  <img :src="book.cover_image ? `/storage/${book.cover_image}` : '/images/default-book-cover.jpg'"
                    :alt="book.title"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-background/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  </div>
                </div>
              </div>

              <!-- Book Actions -->
              <div class="mt-6 space-y-3">
                <Button @click="downloadBook"
                  class="w-full group transition-all duration-300 hover:shadow-lg hover:shadow-primary/25" size="lg">
                  <Download class="h-5 w-5 mr-2 group-hover:animate-bounce" />
                  Download Book
                </Button>

                <!-- Share Dropdown -->
                <DropdownMenu>
                  <DropdownMenuTrigger asChild>
                    <Button variant="outline" class="w-full">
                      <Share2 class="h-5 w-5 mr-2" />
                      Share Book
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="center" class="w-56">
                    <DropdownMenuLabel>Share this book</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem @click="shareViaTwitter">
                      <Twitter class="h-4 w-4 mr-2" />
                      Twitter
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="shareViaFacebook">
                      <Facebook class="h-4 w-4 mr-2" />
                      Facebook
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="shareViaEmail">
                      <Mail class="h-4 w-4 mr-2" />
                      Email
                    </DropdownMenuItem>
                    <DropdownMenuItem @click="shareViaWhatsApp">
                      <MessageCircle class="h-4 w-4 mr-2" />
                      WhatsApp
                    </DropdownMenuItem>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem @click="copyToClipboard">
                      <Copy class="h-4 w-4 mr-2" />
                      Copy Link
                    </DropdownMenuItem>
                  </DropdownMenuContent>
                </DropdownMenu>

                <Button variant="outline" class="w-full group">
                  <Bookmark class="h-5 w-5 mr-2 group-hover:fill-primary/20 transition-all duration-300" />
                  Save for Later
                </Button>
              </div>
            </div>

            <!-- Book Details -->
            <div class="md:w-2/3" v-motion :initial="{ opacity: 0, x: 50 }"
              :enter="{ opacity: 1, x: 0, transition: { delay: 300, duration: 600 } }">
              <div class="space-y-6">
                <!-- Title and Author -->
                <div>
                  <h1 class="text-4xl font-bold tracking-tight mb-2 text-foreground">{{ book.title }}</h1>
                  <p class="text-xl text-muted-foreground flex items-center">
                    by
                    <span class="font-medium text-foreground ml-1 inline-flex items-center">
                      <User class="h-4 w-4 mr-1 text-primary" />
                      {{ book.author }}
                    </span>
                  </p>
                </div>

                <!-- Book Metadata Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                  <Card class="bg-secondary/50 border-none shadow-sm hover:shadow-md transition-shadow duration-300">
                    <CardContent class="p-4 flex items-center">
                      <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center mr-3">
                        <Hash class="h-5 w-5 text-primary" />
                      </div>
                      <div>
                        <p class="text-xs text-muted-foreground">ISBN</p>
                        <p class="font-medium">{{ book.isbn || 'Not available' }}</p>
                      </div>
                    </CardContent>
                  </Card>

                  <Card class="bg-secondary/50 border-none shadow-sm hover:shadow-md transition-shadow duration-300">
                    <CardContent class="p-4 flex items-center">
                      <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center mr-3">
                        <Calendar class="h-5 w-5 text-primary" />
                      </div>
                      <div>
                        <p class="text-xs text-muted-foreground">Published</p>
                        <p class="font-medium">{{ formatDate(book.published_date) }}</p>
                      </div>
                    </CardContent>
                  </Card>

                  <Card class="bg-secondary/50 border-none shadow-sm hover:shadow-md transition-shadow duration-300">
                    <CardContent class="p-4 flex items-center">
                      <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center mr-3">
                        <Download class="h-5 w-5 text-primary" />
                      </div>
                      <div>
                        <p class="text-xs text-muted-foreground">Downloads</p>
                        <p class="font-medium">{{ formatNumber(book.download_count) }}</p>
                      </div>
                    </CardContent>
                  </Card>
                </div>

                <!-- Book Description -->
                <Card class="overflow-hidden border-muted/40 bg-card/80 backdrop-blur-sm">
                  <CardContent class="p-6">
                    <h3 class="text-xl font-semibold mb-4 flex items-center">
                      <FileText class="h-5 w-5 mr-2 text-primary" />
                      Description
                    </h3>
                    <div class="prose dark:prose-invert max-w-none" v-html="book.description"></div>
                  </CardContent>
                </Card>
              </div>
            </div>
          </div>
        </div>

        <!-- Related Books Section -->
        <div class="mt-20 relative" v-motion :initial="{ opacity: 0, y: 50 }"
          :enter="{ opacity: 1, y: 0, transition: { delay: 500, duration: 600 } }">
          <!-- Decorative elements -->
          <div
            class="absolute -left-10 top-1/2 transform -translate-y-1/2 h-40 w-1 bg-gradient-to-b from-transparent via-primary/50 to-transparent rounded-full blur-sm">
          </div>

          <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold tracking-tight flex items-center">
              <LibraryBig class="h-5 w-5 mr-2 text-primary" />
              Related Books
            </h2>
            <div class="flex space-x-2">
              <Button variant="ghost" size="sm" class="group" @click="scrollRelatedBooks('left')">
                <ChevronLeft class="h-5 w-5 group-hover:text-primary transition-colors" />
              </Button>
              <Button variant="ghost" size="sm" class="group" @click="scrollRelatedBooks('right')">
                <ChevronRight class="h-5 w-5 group-hover:text-primary transition-colors" />
              </Button>
            </div>
          </div>

          <div ref="relatedBooksContainer" class="flex space-x-6 overflow-x-auto pb-4 snap-x scrollbar-hide"
            v-motion-slide-visible :delay="100">
            <div v-for="(relatedBook, index) in relatedBooks" :key="relatedBook.id" v-motion
              :initial="{ opacity: 0, y: 20 }"
              :enter="{ opacity: 1, y: 0, transition: { delay: 600 + (index * 100), duration: 400 } }"
              class="group snap-start min-w-[250px] max-w-[250px]">
              <Link :href="`/books/${relatedBook.slug}`" class="block">
              <Card
                class="overflow-hidden h-full border-muted/40 transition-all duration-300 hover:shadow-lg hover:shadow-primary/10 hover:border-primary/20">
                <div class="relative overflow-hidden">
                  <img
                    :src="relatedBook.cover_image ? `/storage/${relatedBook.cover_image}` : '/images/default-book-cover.jpg'"
                    :alt="relatedBook.title"
                    class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110">
                  <div
                    class="absolute inset-0 bg-gradient-to-t from-background/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  </div>
                </div>
                <CardContent class="p-4">
                  <h3
                    class="font-bold text-lg mb-1 line-clamp-1 group-hover:text-primary transition-colors duration-300">
                    {{ relatedBook.title }}
                  </h3>
                  <p class="text-muted-foreground text-sm flex items-center">
                    <User class="h-3 w-3 mr-1" />
                    {{ relatedBook.author }}
                  </p>
                </CardContent>
              </Card>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Toast for notifications -->
      <Toaster />
    </div>
  </PublicLayout>
</template>

<script setup>
import { ref } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { toast, Toaster } from 'vue-sonner';
//import { vMotion, vMotionSlideVisible } from '@vueuse/motion';
import {
  Bookmark, Calendar, ChevronLeft, ChevronRight, Copy, Download, Facebook,
  FileText, Hash, Heart, LibraryBig, Mail, MessageCircle, Share2, Twitter, User
} from 'lucide-vue-next';
// import {
//   Button,
//   Card, CardContent,
//   DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel,
//   DropdownMenuSeparator, DropdownMenuTrigger
// } from '@/components/ui';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';


const props = defineProps({
  book: Object,
  relatedBooks: Array,
});

const relatedBooksContainer = ref(null);

const downloadBook = () => {
  window.location.href = `/books/${props.book.slug}/download`;
};

const copyToClipboard = () => {
  const url = window.location.href;
  navigator.clipboard.writeText(url)
    .then(() => {
      toast.success('Link copied to clipboard!', {
        description: 'Share this book with others',
        action: {
          label: 'View',
          onClick: () => window.open(url, '_blank')
        },
      });
    })
    .catch(() => {
      toast.error('Failed to copy link', {
        description: 'Please try again',
      });
    });
};

const shareViaTwitter = () => {
  const text = `Check out "${props.book.title}" by ${props.book.author}`;
  const url = window.location.href;
  window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
  toast('Shared on Twitter', { description: 'Opening Twitter...' });
};

const shareViaFacebook = () => {
  const url = window.location.href;
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
  toast('Shared on Facebook', { description: 'Opening Facebook...' });
};

const shareViaEmail = () => {
  const subject = `Check out this book: ${props.book.title}`;
  const body = `I thought you might be interested in this book:\n\n${props.book.title} by ${props.book.author}\n\n${window.location.href}`;
  window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
  toast('Email client opened', { description: 'Share via email' });
};

const shareViaWhatsApp = () => {
  const text = `Check out "${props.book.title}" by ${props.book.author}: ${window.location.href}`;
  window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
  toast('Shared on WhatsApp', { description: 'Opening WhatsApp...' });
};

const scrollRelatedBooks = (direction) => {
  if (!relatedBooksContainer.value) return;

  const container = relatedBooksContainer.value;
  const scrollAmount = 300;

  if (direction === 'left') {
    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
  } else {
    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
};

const formatDate = (dateString) => {
  if (!dateString) return 'Not available';
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

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

/* Add custom animation for the download button */
@keyframes bounce {

  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-4px);
  }
}

.animate-bounce {
  animation: bounce 0.5s ease infinite;
}

/* Blob animation */
@keyframes blob {
  0% {
    transform: scale(1);
  }

  33% {
    transform: scale(1.1) translate(10px, -10px);
  }

  66% {
    transform: scale(0.9) translate(-10px, 10px);
  }

  100% {
    transform: scale(1);
  }
}

.animate-blob {
  animation: blob 7s infinite alternate;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

/* Hide scrollbar but keep functionality */
.scrollbar-hide {
  -ms-overflow-style: none;
  /* IE and Edge */
  scrollbar-width: none;
  /* Firefox */
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
  /* Chrome, Safari and Opera */
}

/* Ensure proper prose styling in dark mode */
:deep(.prose) {
  max-width: none;
}

:deep(.prose p) {
  margin-bottom: 1em;
}

:deep(.prose a) {
  color: hsl(var(--primary));
  text-decoration: underline;
  text-underline-offset: 2px;
}

:deep(.dark .prose a) {
  color: hsl(var(--primary));
}
</style>
