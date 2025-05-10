<template>
  <PublicLayout>
    <Head title="Privacy Policy" />

    <div class="max-w-4xl mx-auto px-4 py-12 space-y-8 text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">
      <h1 class="text-3xl font-semibold text-zinc-900 dark:text-zinc-100">Privacy Policy</h1>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">1. Introduction</h2>
        <p>
          TechXtraSol is committed to protecting your privacy. This Privacy Policy explains how we collect, use,
          and safeguard your personal data when you interact with our services.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">2. Data We Collect</h2>
        <ul class="list-disc list-inside space-y-1">
          <li>Personal Information (name, email, phone)</li>
          <li>Usage data (browsing behavior, IP address)</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">3. How We Use Your Data</h2>
        <p>We use your data to:</p>
        <ul class="list-disc list-inside space-y-1">
          <li>Provide and improve our services</li>
          <li>Communicate with you</li>
          <li>Analyze user interaction and enhance your experience</li>
        </ul>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">4. Data Sharing</h2>
        <p>
          We do not sell your data. We may share it with trusted third parties for service delivery, legal obligations, or with your consent.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">5. Security</h2>
        <p>
          We implement industry-standard measures to secure your data. However, no method of transmission over the internet is completely secure.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">6. Your Rights</h2>
        <p>
          You have the right to access, update, or delete your personal data. To do so, contact us at
          <a href="mailto:support@techxtrasol.com" class="text-blue-600 underline dark:text-blue-400"> support@techxtrasol.com</a>.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">7. Changes</h2>
        <p>
          We may update this Privacy Policy occasionally. Changes will be posted on this page with a revised date.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">8. Contact Us</h2>
        <p>
          If you have any questions about this policy, please contact us at
          <a href="mailto:support@techxtrasol.com" class="text-blue-600 underline dark:text-blue-400"> support@techxtrasol.com</a>.
        </p>
      </section>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>
