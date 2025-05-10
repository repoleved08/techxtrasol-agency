<template>
  <footer class="bg-card border-t border-border mt-24 pt-16 pb-8">
    <div class="container mx-auto px-4">
      <!-- Main Footer Content -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <!-- Company Info -->
        <div>
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary/60 rounded-lg flex items-center justify-center mr-3">
              <div class="text-primary-foreground font-bold text-xl">T</div>
            </div>
            <h3 class="text-xl font-bold">TechXtraSol</h3>
          </div>
          <p class="text-muted-foreground mb-4">
            Empowering businesses through innovative technology solutions. We help you transform ideas into reality.
          </p>
          <div class="flex space-x-3">
            <a
              v-for="social in socialLinks"
              :key="social.name"
              :href="social.url"
              target="_blank"
              rel="noopener noreferrer"
              class="w-8 h-8 rounded-full bg-muted flex items-center justify-center hover:bg-primary hover:text-primary-foreground transition-colors"
              v-motion
              :initial="{ scale: 1 }"
              :hover="{ scale: 1.1, y: -3 }"
            >
              <component :is="social.icon" class="w-4 h-4" />
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-base font-semibold mb-4">Quick Links</h4>
          <ul class="space-y-2">
            <li v-for="link in quickLinks" :key="link.name">
              <a
                :href="link.url"
                class="text-muted-foreground hover:text-primary transition-colors flex items-center"
              >
                <ChevronRightIcon class="w-4 h-4 mr-1" />
                {{ link.name }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Resources -->
        <div>
          <h4 class="text-base font-semibold mb-4">Resources</h4>
          <ul class="space-y-2">
            <li v-for="link in resourceLinks" :key="link.name">
              <a
                :href="link.url"
                class="text-muted-foreground hover:text-primary transition-colors flex items-center"
              >
                <ChevronRightIcon class="w-4 h-4 mr-1" />
                {{ link.name }}
              </a>
            </li>
          </ul>
        </div>

        <!-- Newsletter -->
        <div>
          <h4 class="text-base font-semibold mb-4">Stay Updated</h4>
          <p class="text-muted-foreground mb-4">Subscribe to our newsletter for the latest updates and resources.</p>
          <div class="flex">
            <input
              type="email"
              placeholder="Your email"
              class="flex-1 px-3 py-2 bg-muted border border-border rounded-l-md focus:outline-none focus:ring-1 focus:ring-primary"
            />
            <button class="bg-primary text-primary-foreground px-4 py-2 rounded-r-md hover:bg-primary/90 transition-colors">
              <SendIcon class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>

      <!-- Animated Divider -->
      <div class="relative h-px bg-border my-8 overflow-hidden">
        <div
          class="absolute top-0 left-0 h-full w-24 bg-gradient-to-r from-transparent via-primary to-transparent"
          v-motion
          :initial="{ x: '-100%' }"
          :enter="{
            x: ['100%', '-100%'],
            transition: {
              repeat: Infinity,
              duration: 3000,
              ease: 'linear'
            }
          }"
        ></div>
      </div>

      <!-- Bottom Footer -->
      <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="text-sm text-muted-foreground mb-4 md:mb-0">
          &copy; {{ new Date().getFullYear() }} TechXtraSol. All rights reserved.
        </p>
        <div class="flex space-x-4 text-sm">
          <a href="/privacy-policy" class="text-muted-foreground hover:text-primary transition-colors">Privacy Policy</a>
          <a href="/terms-of-service" class="text-muted-foreground hover:text-primary transition-colors">Terms of Service</a>
          <a href="/contact" class="text-muted-foreground hover:text-primary transition-colors">Contact Us</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { useMotion } from '@vueuse/motion';
import {
  TwitterIcon,
  FacebookIcon,
  LinkedinIcon,
  GithubIcon,
  InstagramIcon,
  ChevronRightIcon,
  SendIcon
} from 'lucide-vue-next';

const socialLinks = [
  { name: 'Twitter', icon: TwitterIcon, url: 'https://twitter.com' },
  { name: 'Facebook', icon: FacebookIcon, url: 'https://facebook.com' },
  { name: 'LinkedIn', icon: LinkedinIcon, url: 'https://linkedin.com' },
  { name: 'GitHub', icon: GithubIcon, url: 'https://github.com' },
  { name: 'Instagram', icon: InstagramIcon, url: 'https://instagram.com' }
];

const quickLinks = [
  { name: 'Home', url: '/' },
  { name: 'About Us', url: '/about-us' },
  { name: 'Services', url: '/services' },
  { name: 'Portfolio', url: '/portfolio' },
  { name: 'Contact', url: '/contact' }
];

const resourceLinks = [
  { name: 'All Resources', url: '/resources' },
  { name: 'Tutorials', url: '/resources/category/tutorials' },
  { name: 'Case Studies', url: '/resources/category/case-studies' },
  { name: 'Guides', url: '/resources/category/guides' },
  { name: 'Documentation', url: '/resources/category/documentation' }
];
</script>
