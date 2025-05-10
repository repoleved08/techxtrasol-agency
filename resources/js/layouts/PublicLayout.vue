<!-- resources/js/layouts/PublicLayout.vue -->
<template>
  <div class="min-h-screen bg-background">
    <!-- Only include navbar (no sidebar) -->
    <Navbar :can-view-admin="canViewAdmin" />

    <!-- Main content -->
    <main>
      <slot />
    </main>

    <FooterSection />
  </div>
</template>

<script setup lang="ts">
import Navbar from '@/pages/shared/Navbar.vue';
import FooterSection from '@/pages/FooterSection.vue';

defineProps({
  canViewAdmin: {
    type: Boolean,
    default: false
  }
});
</script>
