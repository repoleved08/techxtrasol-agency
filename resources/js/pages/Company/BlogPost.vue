<template>
  <Head :title="post.title" />
  <!-- Optimized meta tags with minimal processing -->
  <meta name="description" :content="post.excerpt" />
  <meta name="author" :content="post.author.name" />
  <meta property="og:title" :content="post.title" />
  <meta property="og:description" :content="post.excerpt" />
  <meta property="og:image" :content="post.image" />
  <meta property="og:url" :content="`${$page.props.app_url}/blog/${post.slug}`" />
  <meta property="og:type" content="article" />
  <meta name="twitter:card" content="summary_large_image" />
  <link rel="canonical" :href="`${$page.props.app_url}/blog/${post.slug}`" />

  <PublicLayout>
    <!-- Simplified reading progress - no complex animations -->
    <div
      class="fixed top-0 left-0 w-full h-1 bg-primary/20 z-50"
      v-show="showProgress"
      aria-hidden="true"
    >
      <div
        class="h-full bg-primary"
        :style="{ width: `${readingProgress}%` }"
      ></div>
    </div>

    <div class="bg-background min-h-screen">
      <!-- Optimized Hero Section -->
      <header
        class="relative h-[50vh] md:h-[60vh] overflow-hidden"
        v-if="post.image"
      >
        <!-- Lazy loaded hero image with proper sizing -->
        <img
          :src="post.image"
          :alt="post.title"
          class="absolute inset-0 w-full h-full object-cover"
          loading="eager"
          :width="1200"
          :height="600"
          decoding="async"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-background"></div>

        <div class="container relative z-10 h-full flex flex-col justify-end pb-8 px-4 mx-auto">
          <!-- Simplified breadcrumbs -->
          <nav class="mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center text-sm text-white/80 gap-2">
              <li><a href="/blog" class="hover:text-white">Blog</a></li>
              <ChevronRightIcon class="h-3 w-3" aria-hidden="true" />
              <li>{{ post.category }}</li>
            </ol>
          </nav>

          <Badge class="mb-4 bg-primary/90 text-primary-foreground self-start">
            {{ post.category }}
          </Badge>

          <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 max-w-4xl">
            {{ post.title }}
          </h1>

          <div class="flex flex-wrap items-center gap-4 text-white/90">
            <div class="flex items-center gap-3">
              <!-- Optimized avatar with explicit dimensions -->
              <img
                :src="post.author.avatar || '/placeholder.svg?height=40&width=40'"
                :alt="post.author.name"
                class="h-10 w-10 rounded-full border-2 border-primary/30"
                width="40"
                height="40"
                loading="lazy"
                decoding="async"
              />
              <div>
                <p class="font-medium text-white">{{ post.author.name }}</p>
                <p class="text-xs text-white/70" v-if="post.author.role">{{ post.author.role }}</p>
              </div>
            </div>

            <div class="flex items-center gap-4 text-sm">
              <time class="flex items-center" :datetime="post.date">
                <CalendarIcon class="h-4 w-4 mr-1" aria-hidden="true" />
                {{ formatDate(post.date) }}
              </time>
              <span class="flex items-center">
                <ClockIcon class="h-4 w-4 mr-1" aria-hidden="true" />
                {{ readingTime }} min read
              </span>
            </div>
          </div>
        </div>
      </header>

      <div class="container px-4 mx-auto max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 py-8">
          <!-- Main Content -->
          <main class="lg:col-span-8">
            <!-- Article Content with optimized processing -->
            <article
              ref="postContent"
              class="prose-container"
              v-html="optimizedContent"
            ></article>

            <!-- Simplified Footer -->
            <footer class="mt-12 pt-8 border-t border-border space-y-6">
              <!-- Tags -->
              <div v-if="post.tags?.length" class="flex flex-wrap gap-2">
                <span
                  v-for="tag in post.tags"
                  :key="tag"
                  class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-secondary text-secondary-foreground cursor-pointer hover:bg-secondary/80"
                  @click="navigateToTag(tag)"
                >
                  #{{ tag }}
                </span>
              </div>

              <!-- Simplified Share Buttons -->
              <div class="flex items-center gap-4">
                <span class="text-sm font-medium">Share:</span>
                <div class="flex gap-2">
                  <button
                    v-for="social in socials"
                    :key="social.name"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-border hover:bg-muted transition-colors"
                    @click="shareContent(social.name)"
                    :aria-label="`Share on ${social.name}`"
                  >
                    <component :is="social.icon" class="h-4 w-4" />
                  </button>
                </div>
              </div>

              <!-- Simplified Author Bio -->
              <div
                v-if="post.author.bio"
                class="bg-muted/50 rounded-lg p-6"
              >
                <div class="flex items-start gap-4">
                  <img
                    :src="post.author.avatar || '/placeholder.svg?height=60&width=60'"
                    :alt="post.author.name"
                    class="w-15 h-15 rounded-full"
                    width="60"
                    height="60"
                    loading="lazy"
                    decoding="async"
                  />
                  <div>
                    <h3 class="font-bold text-lg mb-2">{{ post.author.name }}</h3>
                    <p class="text-muted-foreground text-sm">{{ post.author.bio }}</p>
                  </div>
                </div>
              </div>
            </footer>
          </main>

          <!-- Simplified Sidebar -->
          <aside class="lg:col-span-4">
            <div class="lg:sticky lg:top-24 space-y-6">
              <!-- Table of Contents -->
              <div v-if="tableOfContents.length > 0" class="bg-card rounded-lg border p-4">
                <h3 class="font-semibold mb-3 flex items-center">
                  <ListIcon class="h-4 w-4 mr-2" />
                  Contents
                </h3>
                <nav aria-label="Table of contents">
                  <ul class="space-y-1 text-sm">
                    <li
                      v-for="(item, index) in tableOfContents"
                      :key="index"
                    >
                      <a
                        :href="`#${item.id}`"
                        class="block py-1 px-2 rounded hover:bg-muted transition-colors"
                        :class="[
                          activeHeading === item.id ? 'bg-primary/10 text-primary font-medium' : 'text-muted-foreground',
                          item.level === 3 ? 'ml-4' : ''
                        ]"
                        @click.prevent="scrollToHeading(item.id)"
                      >
                        {{ item.text }}
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>

              <!-- Newsletter -->
              

              <!-- Related Posts -->
              <div v-if="relatedPosts?.length" class="bg-card rounded-lg border p-4">
                <h3 class="font-semibold mb-3 flex items-center">
                  <BookmarkIcon class="h-4 w-4 mr-2" />
                  Related
                </h3>
                <div class="space-y-3">
                  <article
                    v-for="relatedPost in relatedPosts.slice(0, 3)"
                    :key="relatedPost.id"
                    class="flex gap-3 p-2 rounded hover:bg-muted/50 transition-colors cursor-pointer"
                    @click="navigateToPost(relatedPost.slug)"
                  >
                    <img
                      :src="relatedPost.image || '/placeholder.svg?height=60&width=60'"
                      :alt="relatedPost.title"
                      class="w-15 h-15 rounded object-cover flex-shrink-0"
                      width="60"
                      height="60"
                      loading="lazy"
                      decoding="async"
                    />
                    <div class="flex-1 min-w-0">
                      <h4 class="font-medium text-sm line-clamp-2 mb-1">
                        {{ relatedPost.title }}
                      </h4>
                      <time class="text-xs text-muted-foreground" :datetime="relatedPost.date">
                        {{ formatDate(relatedPost.date) }}
                      </time>
                    </div>
                  </article>
                </div>
              </div>
            </div>
          </aside>
        </div>

        <!-- Back to Top -->
        <button
          v-show="showBackToTop"
          @click="scrollToTop"
          class="fixed bottom-8 right-8 bg-primary text-primary-foreground rounded-full p-3 shadow-lg hover:bg-primary/90 transition-colors z-50"
          aria-label="Back to top"
        >
          <ArrowUpIcon class="h-5 w-5" />
        </button>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup>
import PublicLayout from '@/layouts/PublicLayout.vue'
import { usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'

// Minimal imports - only what's needed
import {
  ChevronRightIcon,
  CalendarIcon,
  ClockIcon,
  ListIcon,
  MailIcon,
  BookmarkIcon,
  ArrowUpIcon,
  TwitterIcon,
  FacebookIcon,
  LinkedinIcon,
  Link2Icon
} from 'lucide-vue-next'

import { Badge } from '@/components/ui/badge'

const page = usePage()
const post = computed(() => page.props.post)
const relatedPosts = computed(() => page.props.relatedPosts || [])

// Minimal state
const tableOfContents = ref([])
const activeHeading = ref('')
const postContent = ref(null)
const readingProgress = ref(0)
const showProgress = ref(false)
const showBackToTop = ref(false)
const newsletterEmail = ref('')

// Optimized computed properties
const readingTime = computed(() => {
  if (!post.value?.body) return 0
  const words = post.value.body.replace(/<[^>]*>/g, '').split(/\s+/).length
  return Math.ceil(words / 200)
})

// Simplified content processing
const optimizedContent = computed(() => {
  if (!post.value?.body) return ''

  let content = post.value.body

  // Add IDs to headings for TOC (minimal processing)
  content = content.replace(/<h([2-3])([^>]*)>(.*?)<\/h[2-3]>/g, (match, level, attrs, text) => {
    const id = text.toLowerCase().replace(/[^\w\s]/g, '').replace(/\s+/g, '-')
    return `<h${level}${attrs} id="${id}">${text}</h${level}>`
  })

  return content
})

// Social sharing
const socials = [
  { name: 'twitter', icon: TwitterIcon },
  { name: 'facebook', icon: FacebookIcon },
  { name: 'linkedin', icon: LinkedinIcon },
  { name: 'copy', icon: Link2Icon }
]

// Optimized methods
const formatDate = (dateString) => {
  return new Intl.DateTimeFormat('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  }).format(new Date(dateString))
}

const shareContent = (platform) => {
  const url = window.location.href
  const title = post.value?.title

  const urls = {
    twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`,
    facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
    linkedin: `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`
  }

  if (platform === 'copy') {
    navigator.clipboard.writeText(url)
    return
  }

  if (urls[platform]) {
    window.open(urls[platform], '_blank', 'width=600,height=400')
  }
}

// Simplified TOC extraction
const extractTableOfContents = () => {
  if (!postContent.value) return

  const headings = postContent.value.querySelectorAll('h2, h3')
  tableOfContents.value = Array.from(headings).map(heading => ({
    id: heading.id,
    text: heading.textContent,
    level: parseInt(heading.tagName.substring(1))
  }))
}

const scrollToHeading = (id) => {
  document.getElementById(id)?.scrollIntoView({
    behavior: 'smooth',
    block: 'start'
  })
}

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

// Throttled scroll handler for better performance
let ticking = false
const updateReadingProgress = () => {
  if (!ticking) {
    requestAnimationFrame(() => {
      if (!postContent.value) return

      const scrollTop = window.scrollY
      const docHeight = document.documentElement.scrollHeight - window.innerHeight
      const progress = Math.min(100, Math.max(0, (scrollTop / docHeight) * 100))

      readingProgress.value = progress
      showProgress.value = scrollTop > 100
      showBackToTop.value = scrollTop > 500

      // Update active heading (simplified)
      const headings = Array.from(document.querySelectorAll('h2, h3'))
      const current = headings.find(h => h.getBoundingClientRect().top <= 100)
      if (current) activeHeading.value = current.id

      ticking = false
    })
    ticking = true
  }
}

const navigateToPost = (slug) => {
  window.location.href = `/blog/${slug}`
}

const navigateToTag = (tag) => {
  window.location.href = `/blog?tag=${tag.toLowerCase()}`
}

const subscribeToNewsletter = () => {
  // Implement newsletter subscription
  console.log('Subscribe:', newsletterEmail.value)
  newsletterEmail.value = ''
}

// Lifecycle with performance optimizations
onMounted(() => {
  // Use setTimeout to defer non-critical operations
  setTimeout(() => {
    extractTableOfContents()
  }, 100)

  // Passive scroll listener for better performance
  window.addEventListener('scroll', updateReadingProgress, { passive: true })
  updateReadingProgress()
})

onUnmounted(() => {
  window.removeEventListener('scroll', updateReadingProgress)
})
</script>

<style scoped>
/* Minimal, optimized CSS */
.prose-container {
  max-width: none;
  font-family: system-ui, -apple-system, sans-serif;
  line-height: 1.7;
  color: hsl(var(--foreground));
}

.prose-container :deep(p) {
  margin-bottom: 1.5rem;
  font-size: 1.1rem;
  line-height: 1.8;
}

.prose-container :deep(h2) {
  margin: 2.5rem 0 1rem;
  font-size: 1.875rem;
  font-weight: 700;
  line-height: 1.2;
  scroll-margin-top: 100px;
}

.prose-container :deep(h3) {
  margin: 2rem 0 0.75rem;
  font-size: 1.5rem;
  font-weight: 600;
  line-height: 1.3;
  scroll-margin-top: 100px;
}

.prose-container :deep(a) {
  color: hsl(var(--primary));
  text-decoration: underline;
  text-decoration-color: hsl(var(--primary) / 0.3);
  text-underline-offset: 2px;
  transition: text-decoration-color 0.2s;
}

.prose-container :deep(a:hover) {
  text-decoration-color: hsl(var(--primary));
}

.prose-container :deep(img) {
  width: 100%;
  height: auto;
  border-radius: 0.5rem;
  margin: 1.5rem 0;
}

.prose-container :deep(pre) {
  margin: 1.5rem 0;
  padding: 1rem;
  background: hsl(var(--muted));
  border-radius: 0.5rem;
  overflow-x: auto;
  font-size: 0.875rem;
}

.prose-container :deep(code) {
  font-family: ui-monospace, monospace;
  font-size: 0.875em;
  background: hsl(var(--muted));
  padding: 0.125rem 0.25rem;
  border-radius: 0.25rem;
}

.prose-container :deep(blockquote) {
  margin: 1.5rem 0;
  padding: 1rem 1.5rem;
  border-left: 4px solid hsl(var(--primary));
  background: hsl(var(--muted) / 0.5);
  font-style: italic;
}

.prose-container :deep(ul),
.prose-container :deep(ol) {
  margin: 1rem 0;
  padding-left: 1.5rem;
}

.prose-container :deep(li) {
  margin-bottom: 0.5rem;
}

/* Utility classes */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Performance optimizations */
.prose-container :deep(*) {
  contain: layout style;
}

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}

/* Critical CSS inlined, non-critical deferred */
@media (max-width: 768px) {
  .prose-container :deep(h2) {
    font-size: 1.5rem;
  }

  .prose-container :deep(h3) {
    font-size: 1.25rem;
  }

  .prose-container :deep(p) {
    font-size: 1rem;
  }
}
</style>
