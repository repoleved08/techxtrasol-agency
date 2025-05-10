<template>
   <Head>
      <!-- Primary Meta Tags -->
      <title>{{ meta.title }} | TechXtraSol Resources</title>
      <meta name="title" :content="meta.title">
      <meta name="description" :content="meta.description">
      <meta name="author" :content="meta.author">
      <meta name="keywords" :content="meta.tags ? meta.tags.join(', ') : ''">

      <!-- Open Graph / Facebook -->
      <meta property="og:type" :content="meta.type">
      <meta property="og:url" :content="meta.url">
      <meta property="og:title" :content="meta.title">
      <meta property="og:description" :content="meta.description">
      <meta property="og:image" :content="meta.image">
      <meta property="og:image:width" content="1200">
      <meta property="og:image:height" content="630">
      <meta property="og:site_name" :content="meta.site_name">
      <meta property="article:published_time" :content="meta.published_time">
      <meta property="article:modified_time" :content="meta.modified_time">
      <meta property="article:author" :content="meta.author">
      <meta property="article:section" :content="meta.category">
      <meta v-for="tag in meta.tags" :key="tag" property="article:tag" :content="tag">

      <!-- Twitter -->
      <meta name="twitter:card" :content="meta.twitter_card">
      <meta name="twitter:site" :content="meta.twitter_site">
      <meta name="twitter:creator" :content="meta.twitter_creator">
      <meta name="twitter:title" :content="meta.title">
      <meta name="twitter:description" :content="meta.description">
      <meta name="twitter:image" :content="meta.image">
      <meta name="twitter:label1" content="Written by">
      <meta name="twitter:data1" :content="meta.author">
      <meta name="twitter:label2" content="Category">
      <meta name="twitter:data2" :content="meta.category">

      <!-- Canonical URL -->
      <link rel="canonical" :href="meta.url">


    </Head>

  <!-- Reading Progress Bar -->
  <div
    class="fixed top-0 left-0 w-full h-1.5 bg-muted z-50"
    v-motion
    :initial="{ opacity: 0 }"
    :enter="{ opacity: 1, transition: { delay: 300 } }"
  >
    <div
      class="h-full bg-gradient-to-r from-primary via-primary/80 to-primary transition-all duration-200 ease-out"
      :style="{ width: `${readingProgress}%` }"
      :class="{ 'reading-progress-complete': readingProgress >= 98 }"
    ></div>
  </div>

  <!-- Theme Toggle -->
  <div class="fixed top-20 right-4 z-40">
    <button
      @click="toggleDarkMode"
      class="p-3 rounded-full bg-card border border-border shadow-lg text-foreground hover:bg-primary hover:text-primary-foreground transition-all duration-300 transform hover:scale-110"
      v-motion
      :initial="{ opacity: 0, scale: 0.8, rotate: -15 }"
      :enter="{ opacity: 1, scale: 1, rotate: 0, transition: { type: 'spring', stiffness: 200, damping: 15, delay: 800 } }"
    >
      <Sun v-if="isDarkMode" class="w-5 h-5" />
      <Moon v-else class="w-5 h-5" />
    </button>
  </div>

  <!-- Back Button -->
  <div class="container mx-auto px-4 pt-6">
    <button
      @click="goBack"
      class="inline-flex items-center text-muted-foreground hover:text-primary transition-colors group"
      v-motion
      :initial="{ opacity: 0, x: -20 }"
      :enter="{ opacity: 1, x: 0, transition: { duration: 500 } }"
    >
      <div class="w-8 h-8 rounded-full bg-muted flex items-center justify-center mr-2 group-hover:bg-primary/10 transition-colors">
        <ArrowLeftIcon class="w-4 h-4 group-hover:translate-x-[-2px] transition-transform" />
      </div>
      <span>Back to Resources</span>
    </button>
  </div>

  <!-- Hero Section -->
  <div
    class="relative w-full bg-gradient-to-b from-primary/5 to-background pt-8 pb-8 md:pt-16 md:pb-12 overflow-hidden"
    v-motion
    :initial="{ opacity: 0 }"
    :enter="{ opacity: 1, transition: { duration: 800 } }"
  >
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto">
        <!-- Category Badge -->
        <div
          v-motion
          :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { delay: 200, duration: 500 } }"
        >
          <span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-sm font-medium rounded-full">
            {{ resource.category.name }}
          </span>
        </div>

        <!-- Title -->
        <h1
          class="text-3xl md:text-5xl font-bold mt-4 mb-4 leading-tight"
          v-motion
          :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { delay: 300, duration: 500 } }"
        >
          {{ resource.title }}
        </h1>

        <!-- Meta Information -->
        <div
          class="flex flex-wrap items-center text-muted-foreground text-sm mb-6 gap-4"
          v-motion
          :initial="{ opacity: 0, y: 20 }"
          :enter="{ opacity: 1, y: 0, transition: { delay: 400, duration: 500 } }"
        >
          <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2">
              <UserIcon class="h-4 w-4 text-primary" />
            </div>
            <span>{{ resource.user.name }}</span>
          </div>
          <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2">
              <CalendarIcon class="h-4 w-4 text-primary" />
            </div>
            <span>{{ formatDate(resource.published_at) }}</span>
          </div>
          <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2">
              <ClockIcon class="h-4 w-4 text-primary" />
            </div>
            <span>{{ calculateReadingTime(resource.body) }} min read</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Animated background elements -->
    <div class="absolute top-0 right-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
      <div
        v-for="i in 8"
        :key="i"
        class="absolute bg-primary rounded-full blur-xl"
        :style="{
          width: `${30 + i * 15}px`,
          height: `${30 + i * 15}px`,
          top: `${Math.random() * 100}%`,
          right: `${Math.random() * 100}%`,
          opacity: 0.3 + (Math.random() * 0.4)
        }"
        v-motion
        :initial="{ opacity: 0.3 }"
        :enter="{
          opacity: [0.3, 0.7, 0.3],
          y: [0, -80, 0],
          x: [0, i % 2 === 0 ? 30 : -30, 0],
          transition: {
            repeat: Infinity,
            duration: 8000 + (i * 1000),
            delay: i * 500,
            ease: 'easeInOut'
          }
        }"
      ></div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
      <div class="flex flex-col md:flex-row gap-8">
        <!-- Table of Contents (for desktop) -->
        <div
          class="hidden md:block w-72 shrink-0 relative"
          v-if="tableOfContents.length > 0"
          v-motion
          :initial="{ opacity: 0, x: -20 }"
          :enter="{ opacity: 1, x: 0, transition: { delay: 500, duration: 500 } }"
        >
          <div class="sticky top-24 p-6 bg-card rounded-xl border border-border shadow-sm">
            <h3 class="text-base font-semibold mb-4 flex items-center">
              <ListIcon class="w-4 h-4 mr-2 text-primary" />
              Table of Contents
            </h3>
            <ul class="space-y-3 text-sm pl-2">
              <li
                v-for="(item, index) in tableOfContents"
                :key="index"
                class="relative"
              >
                <a
                  :href="`#heading-${index}`"
                  class="text-muted-foreground hover:text-primary transition-colors line-clamp-1 pl-4 py-1 block hover:bg-primary/5 rounded-md"
                  :class="{ 'text-primary font-medium': activeHeading === `heading-${index}` }"
                  @click.prevent="scrollToHeading(`heading-${index}`)"
                >
                  <div
                    class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-primary/30"
                    :class="{ 'bg-primary': activeHeading === `heading-${index}` }"
                  ></div>
                  {{ item }}
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Article Content -->
        <div class="flex-1">
          <!-- Featured Image -->
          <div
            v-if="resource.featured_image"
            class="mb-8 rounded-xl overflow-hidden shadow-lg"
            v-motion
            :initial="{ opacity: 0, scale: 0.95 }"
            :enter="{ opacity: 1, scale: 1, transition: { delay: 500, duration: 800 } }"
          >
            <img
              :src="resource.featured_image_url"
              :alt="resource.title"
              class="w-full object-cover h-[300px] md:h-[400px]"
            />
          </div>

          <!-- Social Sharing (Top) -->
          <div
            class="flex justify-end mb-6 space-x-2"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 600, duration: 500 } }"
          >
            <button
              v-for="(social, index) in socialSharing"
              :key="index"
              class="p-2 rounded-full bg-muted hover:bg-primary/10 hover:text-primary transition-colors"
              @click="shareTo(social.name)"
              v-motion
              :initial="{ scale: 1 }"
              :hover="{ scale: 1.1 }"
              :title="`Share on ${social.name.charAt(0).toUpperCase() + social.name.slice(1)}`"
            >
              <component :is="social.icon" class="w-4 h-4" />
            </button>
          </div>

          <!-- Article Body -->
          <div
            class="article-content"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 700, duration: 500 } }"
            ref="contentRef"
          >
            <div class="prose prose-lg dark:prose-invert max-w-none" v-html="processedContent"></div>
          </div>

          <!-- Tags -->
          <div
            v-if="resource.tags && resource.tags.length"
            class="mt-8 flex flex-wrap gap-2"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 800, duration: 500 } }"
          >
            <span
              v-for="tag in resource.tags"
              :key="tag.id"
              class="px-3 py-1.5 bg-secondary text-secondary-foreground text-sm rounded-full hover:bg-primary hover:text-primary-foreground transition-colors cursor-pointer"
              v-motion
              :initial="{ scale: 1 }"
              :hover="{ scale: 1.05 }"
            >
              #{{ tag.name }}
            </span>
          </div>

          <!-- Author Bio -->
          <div
            class="mt-12 p-6 bg-card rounded-xl border border-border shadow-sm"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :enter="{ opacity: 1, y: 0, transition: { delay: 900, duration: 500 } }"
          >
            <div class="flex items-start gap-4">
              <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-primary/60 flex items-center justify-center">
                <UserIcon class="h-8 w-8 text-primary-foreground" />
              </div>
              <div>
                <h3 class="text-lg font-semibold">{{ resource.user.name }}</h3>
                <p class="text-muted-foreground mt-1">
                  {{ resource.user.bio || 'Content creator at TechXtraSol' }}
                </p>
                <div class="mt-3 flex gap-2">
                  <button class="inline-flex items-center px-3 py-1 text-xs bg-primary/10 text-primary rounded-full hover:bg-primary hover:text-primary-foreground transition-colors">
                    <UserPlusIcon class="w-3 h-3 mr-1" />
                    Follow
                  </button>
                  <button class="inline-flex items-center px-3 py-1 text-xs bg-secondary text-secondary-foreground rounded-full hover:bg-secondary/80 transition-colors">
                    <MailIcon class="w-3 h-3 mr-1" />
                    Contact
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Floating Social Share Bar -->
      <div
        class="fixed left-4 top-1/2 transform -translate-y-1/2 hidden lg:flex flex-col gap-3 z-40"
        v-motion
        :initial="{ opacity: 0, x: -20 }"
        :enter="{ opacity: 1, x: 0, transition: { delay: 1000, duration: 500 } }"
      >
        <button
          v-for="(social, index) in socialSharing"
          :key="index"
          class="p-3 rounded-full bg-card shadow-md hover:bg-primary hover:text-primary-foreground transition-all duration-300"
          @click="shareTo(social.name)"
          v-motion
          :initial="{ scale: 1 }"
          :hover="{ scale: 1.1, y: -5 }"
          :title="`Share on ${social.name.charAt(0).toUpperCase() + social.name.slice(1)}`"
        >
          <component :is="social.icon" class="w-5 h-5" />
        </button>
      </div>

      <!-- Next Article Navigation -->
      <div
        v-if="nextResource"
        class="mt-16 pt-8 border-t border-border"
        v-motion
        :initial="{ opacity: 0, y: 20 }"
        :enter="{ opacity: 1, y: 0, transition: { delay: 1000, duration: 500 } }"
      >
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-bold">Continue Reading</h3>
          <a href="/resources" class="text-primary text-sm hover:underline">View All Resources</a>
        </div>

        <a
          :href="`/resources/${nextResource.slug}`"
          class="block group"
        >
          <div class="bg-card hover:bg-card/80 border border-border rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg">
            <div class="md:flex">
              <div class="md:w-1/3 aspect-video md:aspect-auto overflow-hidden">
                <img
                  :src="nextResource.featured_image_url"
                  :alt="nextResource.title"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
              </div>
              <div class="p-6 md:w-2/3">
                <div class="flex items-center mb-2">
                  <ArrowRightIcon class="w-4 h-4 mr-2 text-primary" />
                  <span class="text-sm font-medium text-primary">Next Article</span>
                </div>
                <h3 class="text-xl font-semibold mb-2 group-hover:text-primary transition-colors">
                  {{ nextResource.title }}
                </h3>
                <p class="text-muted-foreground line-clamp-2 mb-4">
                  {{ nextResource.excerpt }}
                </p>
                <div class="flex items-center text-sm text-muted-foreground">
                  <CalendarIcon class="h-4 w-4 mr-1" />
                  <span>{{ formatDate(nextResource.published_at) }}</span>
                  <span class="mx-2">•</span>
                  <ClockIcon class="h-4 w-4 mr-1" />
                  <span>{{ calculateReadingTime(nextResource.body) }} min read</span>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Recently Published Resources -->
      <div
        v-if="recentResources && recentResources.length"
        class="mt-16 pt-12 border-t border-border"
        v-motion
        :initial="{ opacity: 0, y: 40 }"
        :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
      >
        <h2 class="text-2xl font-bold mb-8 flex items-center">
          <SparklesIcon class="w-5 h-5 mr-2 text-primary" />
          Recently Published
        </h2>
        <div class="grid md:grid-cols-3 gap-6">
          <ResourceCard
            v-for="(item, index) in recentResources"
            :key="item.id"
            :resource="item"
            :index="index"
          />
        </div>
      </div>

      <!-- Related Resources -->
      <div
        v-if="related && related.length"
        class="mt-16 pt-12 border-t border-border"
        v-motion
        :initial="{ opacity: 0, y: 40 }"
        :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
      >
        <h2 class="text-2xl font-bold mb-8 flex items-center">
          <LinkIcon class="w-5 h-5 mr-2 text-primary" />
          Related Resources
        </h2>
        <div class="grid md:grid-cols-3 gap-6">
          <ResourceCard
            v-for="(item, index) in related"
            :key="item.id"
            :resource="item"
            :index="index"
          />
        </div>
      </div>
    </div>
  </div>

  <!-- Enhanced Footer -->
  <ResourceFooter />

  <!-- Back to top button -->
  <button
    v-show="showBackToTop"
    @click="scrollToTop"
    class="fixed bottom-6 right-6 p-3 rounded-full bg-primary text-primary-foreground shadow-lg z-50 transition-all"
    v-motion
    :initial="{ scale: 0.8, opacity: 0 }"
    :enter="{ scale: 1, opacity: 1, transition: { duration: 300 } }"
    :leave="{ scale: 0.8, opacity: 0, transition: { duration: 300 } }"
  >
    <ArrowUpIcon class="h-5 w-5" />
  </button>

  <!-- Mobile Table of Contents Drawer -->
  <div
    v-if="tableOfContents.length > 0"
    class="md:hidden fixed bottom-6 left-6 z-50"
  >
    <button
      @click="showTocDrawer = true"
      class="p-3 rounded-full bg-primary text-primary-foreground shadow-lg transition-all hover:bg-primary/90"
      v-motion
      :initial="{ scale: 0.8, opacity: 0 }"
      :enter="{ scale: 1, opacity: 1, transition: { duration: 300, delay: 1000 } }"
    >
      <ListIcon class="h-5 w-5" />
    </button>
  </div>

  <!-- Mobile TOC Drawer -->
  <div
    v-if="showTocDrawer"
    class="fixed inset-0 bg-background/80 backdrop-blur-sm z-50 md:hidden"
    @click="showTocDrawer = false"
  >
    <div
      class="fixed bottom-0 left-0 right-0 bg-card border-t border-border p-6 rounded-t-xl max-h-[70vh] overflow-y-auto"
      @click.stop
      v-motion
      :initial="{ y: '100%' }"
      :enter="{ y: 0, transition: { type: 'spring', stiffness: 300, damping: 30 } }"
      :leave="{ y: '100%', transition: { duration: 300 } }"
    >
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold flex items-center">
          <ListIcon class="w-5 h-5 mr-2 text-primary" />
          Table of Contents
        </h3>
        <button @click="showTocDrawer = false" class="p-2 rounded-full hover:bg-muted">
          <XIcon class="w-5 h-5" />
        </button>
      </div>
      <div class="w-12 h-1 bg-muted rounded-full mx-auto mb-4"></div>
      <ul class="space-y-3">
        <li
          v-for="(item, index) in tableOfContents"
          :key="index"
          class="relative"
        >
          <a
            :href="`#heading-${index}`"
            class="text-muted-foreground hover:text-primary transition-colors line-clamp-1 pl-4 py-2 block hover:bg-primary/5 rounded-md"
            :class="{ 'text-primary font-medium': activeHeading === `heading-${index}` }"
            @click="scrollToHeadingMobile(`heading-${index}`)"
          >
            <div
              class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-primary/30"
              :class="{ 'bg-primary': activeHeading === `heading-${index}` }"
            ></div>
            {{ item }}
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, nextTick, watch } from 'vue';
import { useMotion } from '@vueuse/motion';
import {
  UserIcon,
  CalendarIcon,
  ClockIcon,
  ArrowUpIcon,
  ArrowRightIcon,
  ArrowLeftIcon,
  TwitterIcon,
  FacebookIcon,
  LinkedinIcon,
  LinkIcon,
  CopyIcon,
  CheckIcon,
  Sun,
  Moon,
  ListIcon,
  XIcon,
  UserPlusIcon,
  MailIcon,
  SparklesIcon
} from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';
import { usePreferredColorScheme } from '@vueuse/core';
import ResourceCard from '@/components/Resources/ResourceCard.vue';
import ResourceFooter from '@/components/Resources/ResourceFooter.vue';

const props = defineProps({
  resource: Object,
  related: Array,
  nextResource: Object,
  recentResources: Array,
  resource: Object,
  meta: Object
});

onMounted(() => {
  const script = document.createElement('script')
  script.setAttribute('type', 'application/ld+json')
  script.textContent = JSON.stringify({
    "@context": "https://schema.org",
    "@type": "Article",
    headline: props.meta.title,
    description: props.meta.description,
    image: props.meta.image,
    author: {
      "@type": "Person",
      name: props.meta.author,
    },
    datePublished: props.meta.published_time,
    dateModified: props.meta.modified_time,
    publisher: {
      "@type": "Organization",
      name: "TechXtraSol",
      logo: {
        "@type": "ImageObject",
        url: '/logo.png', // Replace with actual dynamic logo if needed
      },
    },
    mainEntityOfPage: {
      "@type": "WebPage",
      "@id": props.meta.url,
    },
  })
  document.head.appendChild(script)
})



// Get current URL for canonical and OG tags
const currentUrl = computed(() => {
  if (typeof window !== 'undefined') {
    return window.location.href;
  }
  return '';
});

// Dark mode state
const preferredColorScheme = usePreferredColorScheme();
const isDarkMode = ref(preferredColorScheme.value === 'dark');

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;

  // Apply dark mode class to document for global styles
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
};

// Watch for changes in preferred color scheme
onMounted(() => {
  watch(preferredColorScheme, (newVal) => {
    isDarkMode.value = newVal === 'dark';
    if (isDarkMode.value) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  }, { immediate: true });
});

// Mobile TOC drawer
const showTocDrawer = ref(false);

// Back button functionality
function goBack() {
  // Check if there's a previous page in history
  if (window.history.length > 1) {
    window.history.back();
  } else {
    // Fallback to resources index page
    window.location.href = '/resources';
  }
}

// Format date
const formatDate = (dateString) => {
  if (!dateString) return '';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

// Calculate reading time
function calculateReadingTime(content) {
  if (!content) return 1;

  // Strip HTML tags
  const text = content.replace(/<[^>]*>/g, '');

  // Average reading speed: 200 words per minute
  const words = text.trim().split(/\s+/).length;
  const readingTime = Math.ceil(words / 200);

  return readingTime < 1 ? 1 : readingTime;
}

// Process content to add IDs to headings for table of contents and add copy buttons to code blocks
const processedContent = computed(() => {
  if (!props.resource.body) return '';

  let content = props.resource.body;

  // Add IDs to headings
  let index = 0;
  content = content.replace(/<(h[2-4])[^>]*>(.*?)<\/\1>/gi, (match, tag, text) => {
    const headingId = `heading-${index}`;
    index++;
    return `<${tag} id="${headingId}">${text}</${tag}>`;
  });

  // Add copy buttons to code blocks
  content = content.replace(/<pre><code[^>]*>([\s\S]*?)<\/code><\/pre>/gi, (match, codeContent) => {
    const escapedCode = codeContent.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return `
      <div class="code-block-wrapper">
        <div class="code-block-header">
          <button class="copy-button" data-code="${escapedCode.replace(/"/g, '&quot;')}">
            <span class="copy-icon">Copy</span>
          </button>
        </div>
        <pre><code>${codeContent}</code></pre>
      </div>
    `;
  });

  return content;
});

// Table of contents
const contentRef = ref(null);
const tableOfContents = ref([]);
const activeHeading = ref(null);

// Extract headings for table of contents
onMounted(async () => {
  await nextTick();
  if (contentRef.value) {
    const headings = contentRef.value.querySelectorAll('h2, h3, h4');
    tableOfContents.value = Array.from(headings).map(heading => heading.textContent);

    // Set up code copy buttons
    setupCodeCopyButtons();

    // Set up intersection observer for headings
    setupHeadingObserver();
  }
});

// Setup code copy buttons
function setupCodeCopyButtons() {
  const copyButtons = document.querySelectorAll('.copy-button');
  copyButtons.forEach(button => {
    button.addEventListener('click', () => {
      const code = button.getAttribute('data-code');
      const decodedCode = code
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&amp;/g, '&');

      navigator.clipboard.writeText(decodedCode).then(() => {
        const span = button.querySelector('span');
        span.textContent = 'Copied!';
        setTimeout(() => {
          span.textContent = 'Copy';
        }, 2000);
      });
    });
  });
}

// Setup intersection observer for headings
function setupHeadingObserver() {
  const headingElements = document.querySelectorAll('h2[id^="heading-"], h3[id^="heading-"], h4[id^="heading-"]');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        activeHeading.value = entry.target.id;
      }
    });
  }, { threshold: 0.2 });

  headingElements.forEach(heading => {
    observer.observe(heading);
  });
}

// Scroll to heading
function scrollToHeading(id) {
  const element = document.getElementById(id);
  if (element) {
    window.scrollTo({
      top: element.offsetTop - 100,
      behavior: 'smooth'
    });
    activeHeading.value = id;
  }
}

// Scroll to heading from mobile drawer
function scrollToHeadingMobile(id) {
  scrollToHeading(id);
  showTocDrawer.value = false;
}

// Reading progress
const readingProgress = ref(0);

function updateReadingProgress() {
  if (!contentRef.value) return;

  const contentHeight = contentRef.value.offsetHeight;
  const scrollPosition = window.scrollY - contentRef.value.offsetTop + 300; // Adjust for header
  const progress = Math.min(100, Math.max(0, (scrollPosition / contentHeight) * 100));

  readingProgress.value = progress;
}

// Back to top button
const showBackToTop = ref(false);

function handleScroll() {
  showBackToTop.value = window.scrollY > 500;
  updateReadingProgress();
}

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

// Enhanced social sharing with structured data
const socialSharing = [
  { name: 'twitter', icon: TwitterIcon },
  { name: 'facebook', icon: FacebookIcon },
  { name: 'linkedin', icon: LinkedinIcon },
  { name: 'copy', icon: LinkIcon }
];

function shareTo(platform) {
  const url = window.location.href;
  const title = props.resource.title;
  const description = props.resource.excerpt || props.resource.title;

  switch (platform) {
    case 'twitter':
      window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`, '_blank');
      break;
    case 'facebook':
      window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
      break;
    case 'linkedin':
      window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}&summary=${encodeURIComponent(description)}`, '_blank');
      break;
    case 'copy':
      navigator.clipboard.writeText(url).then(() => {
        alert('Link copied to clipboard!');
      });
      break;
  }
}

// Reading progress
// Initialize readingProgress ref outside of conditional

// Function to update reading progress


// Call updateReadingProgress and handleScroll on scroll


</script>

<style scoped>
/* Theme variables */
:root {
  --primary-hsl: 346.8, 77.2%, 49.8%;
  --primary-foreground-hsl: 355.7, 100%, 97.3%;
}

/* Smooth transitions for theme changes */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Article content styling */
.article-content :deep(h2) {
  font-size: 1.75rem;
  font-weight: 700;
  margin-top: 2.5rem;
  margin-bottom: 1.25rem;
  scroll-margin-top: 100px;
  position: relative;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid hsl(var(--border));
}

.article-content :deep(h3) {
  font-size: 1.5rem;
  font-weight: 600;
  margin-top: 2rem;
  margin-bottom: 1rem;
  scroll-margin-top: 100px;
  position: relative;
}

.article-content :deep(h4) {
  font-size: 1.25rem;
  font-weight: 600;
  margin-top: 1.75rem;
  margin-bottom: 0.75rem;
  scroll-margin-top: 100px;
  position: relative;
}

.article-content :deep(p) {
  margin-bottom: 1.5rem;
  line-height: 1.8;
}

.article-content :deep(ul),
.article-content :deep(ol) {
  margin-bottom: 1.5rem;
  padding-left: 1.75rem;
}

.article-content :deep(li) {
  margin-bottom: 0.75rem;
  line-height: 1.7;
}

.article-content :deep(blockquote) {
  border-left: 4px solid hsl(var(--primary-hsl));
  padding: 1rem 1.5rem;
  font-style: italic;
  margin: 2rem 0;
  color: hsl(var(--muted-foreground));
  background-color: hsl(var(--muted) / 0.2);
  border-radius: 0.5rem;
}

/* Code block styling with copy button */
.article-content :deep(.code-block-wrapper) {
  position: relative;
  margin: 2rem 0;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border: 1px solid hsl(var(--border));
}

.article-content :deep(.code-block-header) {
  display: flex;
  justify-content: flex-end;
  padding: 0.75rem 1rem;
  background-color: hsl(var(--card) / 0.8);
  border-bottom: 1px solid hsl(var(--border));
}

.article-content :deep(.copy-button) {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
  color: hsl(var(--muted-foreground));
  background-color: hsl(var(--muted) / 0.3);
  border: 1px solid hsl(var(--border));
  border-radius: 0.25rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.article-content :deep(.copy-button:hover) {
  background-color: hsl(var(--primary) / 0.1);
  color: hsl(var(--primary));
}

.article-content :deep(pre) {
  background-color: hsl(var(--card));
  padding: 1.25rem;
  border-radius: 0 0 0.5rem 0.5rem;
  overflow-x: auto;
  margin: 0;
}

.article-content :deep(code) {
  background-color: hsl(var(--muted) / 0.5);
  padding: 0.2rem 0.4rem;
  border-radius: 0.25rem;
  font-size: 0.875rem;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

.article-content :deep(img) {
  max-width: 100%;
  height: auto;
  border-radius: 0.75rem;
  margin: 2rem 0;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.article-content :deep(a) {
  color: hsl(var(--primary-hsl));
  text-decoration: underline;
  text-decoration-thickness: 1px;
  text-underline-offset: 2px;
  transition: all 0.2s ease;
}

.article-content :deep(a:hover) {
  text-decoration-thickness: 2px;
  color: hsl(var(--primary-hsl) / 0.8);
}

.article-content :deep(table) {
  width: 100%;
  border-collapse: collapse;
  margin: 2rem 0;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.article-content :deep(th),
.article-content :deep(td) {
  border: 1px solid hsl(var(--border));
  padding: 0.75rem 1rem;
  text-align: left;
}

.article-content :deep(th) {
  background-color: hsl(var(--muted));
  font-weight: 600;
}

.article-content :deep(figure) {
  margin: 2.5rem 0;
}

.article-content :deep(figcaption) {
  text-align: center;
  font-size: 0.875rem;
  color: hsl(var(--muted-foreground));
  margin-top: 0.75rem;
}

/* Animation for heading anchors */
.article-content :deep(h2::before),
.article-content :deep(h3::before),
.article-content :deep(h4::before) {
  content: "#";
  position: absolute;
  left: -1.5rem;
  color: hsl(var(--primary-hsl) / 0.5);
  font-weight: normal;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.article-content :deep(h2:hover::before),
.article-content :deep(h3:hover::before),
.article-content :deep(h4:hover::before) {
  opacity: 1;
}

/* Dark mode adjustments */
.dark .article-content :deep(pre) {
  background-color: hsl(var(--card) / 0.8);
}

.dark .article-content :deep(code) {
  background-color: hsl(var(--card) / 0.8);
}

.dark .article-content :deep(blockquote) {
  color: hsl(var(--muted-foreground) / 0.8);
  background-color: hsl(var(--muted) / 0.1);
}

/* Reading progress bar animation */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

.reading-progress-complete {
  animation: pulse 2s infinite;
}



/* Code block container */
.prose :where(pre) {
  background-color: #1e1e2e !important; /* Dark background for both modes */
  border-radius: 0.75rem;
  margin: 1.5rem 0;
  padding: 1.25rem;
  overflow-x: auto;
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.15),
              0 5px 10px -5px rgba(0, 0, 0, 0.1);
}

/* Code inside pre blocks */
.prose :where(pre) :where(code) {
  color: #f8f8f2 !important; /* Light text for dark background */
  background-color: transparent !important;
  padding: 0;
  border: none;
  font-size: 0.9rem;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
  line-height: 1.7;
  tab-size: 2;
}

/* Inline code (not in pre blocks) */
.prose :where(:not(pre) > code) {
  background-color: hsl(var(--muted) / 0.5);
  color: hsl(var(--primary));
  padding: 0.2rem 0.4rem;
  border-radius: 0.25rem;
  font-size: 0.875rem;
  font-weight: 500;
  white-space: nowrap;
  border: 1px solid hsl(var(--border) / 0.5);
}

/* Code block wrapper */
.article-content .code-block-wrapper {
  position: relative;
  margin: 2rem 0;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Code block header */
.article-content .code-block-header {
  display: flex;
  justify-content: flex-end;
  padding: 0.75rem 1rem;
  background-color: #191926; /* Dark header for both modes */
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Copy button */
.article-content .copy-button {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
  color: rgba(255, 255, 255, 0.8); /* Light text for dark background */
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 0.25rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.article-content .copy-button:hover {
  background-color: rgba(255, 255, 255, 0.2);
}

/* Syntax highlighting colors - works in both light and dark mode */
.prose .hljs-keyword,
.prose .hljs-selector-tag,
.prose .hljs-built_in,
.prose .hljs-name,
.prose .hljs-tag {
  color: #ff79c6 !important;
}

.prose .hljs-string,
.prose .hljs-title,
.prose .hljs-section,
.prose .hljs-attribute,
.prose .hljs-literal,
.prose .hljs-template-tag,
.prose .hljs-template-variable,
.prose .hljs-type,
.prose .hljs-addition {
  color: #50fa7b !important;
}

.prose .hljs-comment,
.prose .hljs-quote,
.prose .hljs-deletion,
.prose .hljs-meta {
  color: #6272a4 !important;
}

.prose .hljs-number,
.prose .hljs-regexp,
.prose .hljs-literal,
.prose .hljs-variable,
.prose .hljs-symbol {
  color: #bd93f9 !important;
}

.prose .hljs-attr,
.prose .hljs-selector-id,
.prose .hljs-selector-class,
.prose .hljs-selector-attr,
.prose .hljs-selector-pseudo {
  color: #ffb86c !important;
}

.prose .hljs-emphasis {
  font-style: italic;
}

.prose .hljs-strong {
  font-weight: bold;
}

/* Language badge */
.prose pre::before {
  content: attr(data-language);
  position: absolute;
  top: 0.5rem;
  right: 0.75rem;
  font-size: 0.7rem;
  font-weight: 600;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.7);
  background: rgba(255, 255, 255, 0.1);
  padding: 0.2rem 0.5rem;
  border-radius: 0.25rem;
  letter-spacing: 0.05em;
}
</style>
