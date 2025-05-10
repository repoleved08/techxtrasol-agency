<template>
  <PublicLayout>
    <Head title="Terms of Service" />
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-8">
      <h1 class="text-3xl font-bold tracking-tight text-center">Terms of Service</h1>

      <Card>
        <CardContent class="space-y-6 text-sm leading-7 text-gray-700 dark:text-gray-300">
          <p>
            Welcome to TechXtraSol. These Terms of Service ("Terms") govern your use of our website, products, and services. By accessing or using our services, you agree to comply with and be bound by these Terms.
          </p>

          <h2 class="text-xl font-semibold">1. Services</h2>
          <p>
            TechXtraSol provides digital solutions including but not limited to web development, mobile app development, AI integration, digital marketing, and graphic design.
          </p>

          <h2 class="text-xl font-semibold">2. Client Responsibilities</h2>
          <ul class="list-disc pl-5 space-y-2">
            <li>Provide accurate and complete information during project onboarding.</li>
            <li>Review and approve project milestones in a timely manner.</li>
            <li>Make payments as per agreed schedule or contract.</li>
          </ul>

          <h2 class="text-xl font-semibold">3. Intellectual Property</h2>
          <p>
            Unless otherwise agreed, all intellectual property created during project execution remains the property of TechXtraSol until full payment is received.
          </p>

          <h2 class="text-xl font-semibold">4. Payment & Refunds</h2>
          <p>
            All payments are subject to the agreed terms outlined in the proposal. Refunds are only applicable under conditions outlined in the contract or service agreement.
          </p>

          <h2 class="text-xl font-semibold">5. Limitation of Liability</h2>
          <p>
            TechXtraSol is not liable for any indirect, incidental, or consequential damages arising from the use or inability to use our services.
          </p>

          <h2 class="text-xl font-semibold">6. Termination</h2>
          <p>
            We reserve the right to suspend or terminate services if these Terms are violated or in cases of misuse or abuse.
          </p>

          <h2 class="text-xl font-semibold">7. Updates</h2>
          <p>
            We may update these Terms from time to time. Continued use of our services constitutes acceptance of those changes.
          </p>

          <p class="text-xs text-gray-500">Last updated: {{ lastUpdated }}</p>
        </CardContent>
      </Card>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { ref } from 'vue';

const lastUpdated = ref('May 10, 2025');
</script>

<style scoped>
@media (max-width: 640px) {
  h1 {
    font-size: 1.875rem;
  }

  h2 {
    font-size: 1.125rem;
  }
}
</style>
