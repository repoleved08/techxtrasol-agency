<template>
  <div
    class="group relative bg-card rounded-xl overflow-hidden border border-border transition-all duration-300 hover:shadow-lg hover:border-primary/30 hover:-translate-y-1"
    v-motion
    :initial="{ opacity: 0, y: 20 }"
    :visible="{ opacity: 1, y: 0, transition: { delay: index * 100, duration: 500 } }"
  >
    <a :href="`/resources/${resource.slug}`" class="block h-full">
      <div class="aspect-video overflow-hidden">
        <img
          :src="resource.featured_image_url || '/placeholder.svg?height=200&width=400'"
          :alt="resource.title"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
      </div>
      <div class="p-5">
        <div class="mb-2 flex items-center justify-between">
          <span class="text-xs font-medium text-primary bg-primary/10 px-2 py-1 rounded-full">
            {{ resource.category ? resource.category.name : 'Resource' }}
          </span>
          <span class="text-xs text-muted-foreground">{{ formatDate(resource.published_at) }}</span>
        </div>
        <h3 class="font-semibold mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ resource.title }}</h3>
        <p class="text-muted-foreground text-sm line-clamp-2 mb-4">{{ resource.excerpt }}</p>

        <div class="flex items-center justify-between mt-auto">
          <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center">
              <UserIcon class="h-3 w-3 text-primary" />
            </div>
            <span class="text-xs">{{ resource.user ? resource.user.name : 'Author' }}</span>
          </div>
          <div class="flex items-center text-xs text-muted-foreground">
            <ClockIcon class="h-3 w-3 mr-1" />
            <span>{{ calculateReadingTime(resource.body) }} min</span>
          </div>
        </div>
      </div>
    </a>
  </div>
</template>

<script setup>
import { UserIcon, ClockIcon } from 'lucide-vue-next';
import { useMotion } from '@vueuse/motion';

const props = defineProps({
  resource: {
    type: Object,
    required: true
  },
  index: {
    type: Number,
    default: 0
  }
});

// Format date
function formatDate(dateString) {
  if (!dateString) return '';
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
}

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
</script>
