<script setup>
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Avatar, AvatarImage } from '@/components/ui/avatar';
import { MailIcon, SendIcon } from 'lucide-vue-next';
import { useForm, usePage } from '@inertiajs/vue3'; // Removed useRoute import
import { ref, computed } from 'vue';
import { useMotion } from '@vueuse/motion';

const page = usePage();
// Removed useRoute() since it's not needed

// Make the newsletter flash message optional
const newsletter = computed(() => page.props.flash?.newsletter);

const form = useForm({
  email: ''
});

const submit = () => {
  form.post(route('newsletter.subscribe'), { // Use the global route() function directly
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    }
  });
};
</script>

<template>
  <!-- Newsletter Subscription -->
  <div
    v-motion
    :initial="{ opacity: 0, y: 20 }"
    :enter="{ opacity: 1, y: 0, transition: { duration: 800, delay: 200 } }"
    class="mt-16 md:mt-24 bg-primary/5 border border-primary/20 rounded-xl p-6 md:p-10"
  >
    <!-- Only show if newsletter message exists -->
    <div
      v-if="newsletter"
      class="mb-4 p-4 rounded-md"
      :class="{
        'bg-green-100 text-green-800': newsletter.status === 'success',
        'bg-blue-100 text-blue-800': newsletter.status === 'info',
        'bg-red-100 text-red-800': newsletter.status === 'error'
      }"
    >
      {{ newsletter.message }}
    </div>

    <div class="grid md:grid-cols-2 gap-8 items-center">
      <div>
        <h3 class="text-2xl font-bold mb-3">Stay Updated with Our Newsletter</h3>
        <p class="text-muted-foreground mb-6">Get the latest articles, tutorials, and updates delivered straight to your inbox.</p>
        <form @submit.prevent="submit" class="flex flex-col sm:flex-row gap-3">
          <Input
            type="email"
            placeholder="Enter your email"
            class="flex-1"
            v-model="form.email"
            required
            :disabled="form.processing"
          />
          <Button
            type="submit"
            class="bg-primary hover:bg-primary/90 text-primary-foreground"
            :disabled="form.processing"
          >
            <template v-if="form.processing">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Processing...
            </template>
            <template v-else>
              Subscribe
              <SendIcon class="ml-2 h-4 w-4" />
            </template>
          </Button>
        </form>
        <p class="text-xs text-muted-foreground mt-3">By subscribing, you agree to our Privacy Policy. We'll send a confirmation email.</p>
      </div>
      <div class="hidden md:flex justify-end">
        <div class="relative">
          <div class="absolute -top-6 -left-6 w-24 h-24 bg-primary/10 rounded-full"></div>
          <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-primary/10 rounded-full"></div>
          <div class="relative z-10 bg-background rounded-lg p-6 shadow-lg border border-border">
            <MailIcon class="h-12 w-12 text-primary mb-4" />
            <h4 class="font-bold mb-2">Weekly Digest</h4>
            <p class="text-sm text-muted-foreground">Get the latest posts every Friday morning.</p>
            <div class="mt-4 flex items-center gap-2">
              <div class="flex -space-x-2">
                <Avatar class="h-6 w-6 border-2 border-background">
                  <AvatarImage src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" />
                </Avatar>
                <Avatar class="h-6 w-6 border-2 border-background">
                  <AvatarImage src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=698&q=80" />
                </Avatar>
                <Avatar class="h-6 w-6 border-2 border-background">
                  <AvatarImage src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" />
                </Avatar>
              </div>
              <span class="text-xs text-muted-foreground">Join our community</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Add any additional styles here */
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
