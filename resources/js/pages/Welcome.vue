<template>
  <PublicLayout :can-view-admin="canViewAdmin">
   <Head title="Welcome">
       <link rel="preconnect" href="https://rsms.me/" />
       <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
   </Head>

   <HeroSection />
   <!-- &lt;!-- <AboutUs /> -->
   <div id="service-section" class="service-section">
     <ServiceSection />
   </div>
   <div id="portfolio-section" class="portfolio-section">
     <PortfolioSection :projects="projects" :categories="categories" />
   </div>
   <Testimonials />
   <div id="blog-section" class="blog-section">
  <BlogInsightSection />
</div>
   <TechnologiesSection />
   <CTA />
   <div id="contact-section" class="contact-section">
     <ContactSection />
   </div>
    <div class="mx-auto mb-8 max-w-7xl px-4 sm:px-6 lg:px-8">
      <Newsletter />
    </div>
 </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Navbar from './shared/Navbar.vue';
import HeroSection from './HeroSection.vue';
import AboutUs from './AboutUs.vue';
import ServiceSection from './ServiceSection.vue';
import PortfolioSection from './PortfolioSection.vue';
import Testimonials from './Testimonials.vue';
import BlogInsightSection from './BlogInsightSection.vue';
import TechnologiesSection from './TechnologiesSection.vue';
import CTA from './CTA.vue';
import ContactSection from './ContactSection.vue';
import Newsletter from './Company/Newsletter.vue';
import FooterSection from './FooterSection.vue';
import { computed } from 'vue';

const page = usePage<{
 canViewAdmin: boolean,
 projects: any[],
 categories: string[]
}>();

const canViewAdmin = computed(() => page.props.canViewAdmin);
const projects = computed(() => page.props.projects);
const categories = computed(() => page.props.categories);
</script>
