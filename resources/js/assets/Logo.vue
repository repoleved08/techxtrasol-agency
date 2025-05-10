<template>
  <Link href="/" class="flex flex-col items-center gap-1 ml-4 font-bold mr-6 group">
    <div
      class="bg-gradient-to-r from-primary to-purple-600 p-1.5 rounded-md transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3 group-hover:shadow-lg">
      <CodeIcon class="h-6 w-6 text-white" />
    </div>
    <span
      class="sm:inline-block text-sm sm:text-base tracking-tight bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent transition-all duration-300 group-hover:tracking-wider">
      TechXtraSol
    </span>
  </Link>
</template>


<script setup lang="ts">
import { CodeIcon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
</script>
