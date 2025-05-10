<template>
  <header
    class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 shadow-sm">
    <div class="container flex h-16 items-center">
      <!-- Logo -->
      <Link href="/" class="flex items-center gap-2 ml-4 font-bold mr-6 group">
      <div
        class="bg-gradient-to-r from-primary to-purple-600 p-1.5 rounded-md transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3 group-hover:shadow-lg">
        <CodeIcon class="h-5 w-5 text-white" />
      </div>
      <span
        class="hidden sm:inline-block text-lg tracking-tight bg-gradient-to-r from-primary to-purple-600 bg-clip-text text-transparent transition-all duration-300 group-hover:tracking-wider">
        TechXtraSol
      </span>
      </Link>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex items-center justify-center flex-1 space-x-1">
        <!-- Services - No dropdown, scroll to section -->
        <button @click="handleSectionClick('service-section')"
          class="group inline-flex h-9 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50 hover:scale-105">
          <SettingsIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
          Services
        </button>

        <!-- Solutions - No dropdown, scroll to portfolio -->
        <button @click="handleSectionClick('portfolio-section')"
          class="group inline-flex h-9 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50 hover:scale-105">
          <LayersIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
          Solutions
        </button>

        <!-- Digital Marketing - Keep dropdown -->
        <!-- <div class="relative">
          <button
            class="group inline-flex h-9 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50 hover:scale-105"
            :class="{ 'bg-accent/50': activeDropdown === 'Digital Marketing' }"
            @click="toggleDropdown('Digital Marketing')">
            <BarChartIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
            Digital Marketing
            <ChevronDownIcon class="ml-1 h-4 w-4 transition-transform duration-300"
              :class="{ 'rotate-180': activeDropdown === 'Digital Marketing' }" />
          </button>

          <Transition enter-active-class="transition-all ease-out duration-300"
            enter-from-class="opacity-0 translate-y-2 scale-95" enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition-all ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 scale-100" leave-to-class="opacity-0 translate-y-2 scale-95">
            <div v-if="activeDropdown === 'Digital Marketing'"
              class="absolute left-0 mt-2 w-64 rounded-md border bg-popover p-3 text-popover-foreground shadow-lg max-h-[70vh] overflow-y-auto scrollbar-thin"
              @mouseleave="closeDropdownDelayed">
              <div class="grid gap-2">
                <Link v-for="(subItem, index) in getSubItems('Digital Marketing')" :key="subItem.label"
                  :href="subItem.href || '#'"
                  class="flex w-full items-center rounded-md p-2.5 text-sm hover:bg-accent hover:text-accent-foreground transition-all duration-200 hover:pl-4"
                  :style="{ transitionDelay: `${index * 30}ms` }">
                <component :is="subItem.icon" class="mr-3 h-4 w-4 transition-transform duration-300 hover:rotate-12" />
                {{ subItem.label }}
                </Link>
              </div>
            </div>
          </Transition>
        </div> -->

        <!-- Company -->
        <div class="relative">
          <button
            class="group inline-flex h-9 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50 hover:scale-105"
            :class="{ 'bg-accent/50': activeDropdown === 'Company' }" @click="toggleDropdown('Company')">
            <BuildingIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
            Company
            <ChevronDownIcon class="ml-1 h-4 w-4 transition-transform duration-300"
              :class="{ 'rotate-180': activeDropdown === 'Company' }" />
          </button>

          <Transition enter-active-class="transition-all ease-out duration-300"
            enter-from-class="opacity-0 translate-y-2 scale-95" enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition-all ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0 scale-100" leave-to-class="opacity-0 translate-y-2 scale-95">
            <div v-if="activeDropdown === 'Company'"
              class="absolute left-0 mt-2 w-64 rounded-md border bg-popover p-3 text-popover-foreground shadow-lg max-h-[70vh] overflow-y-auto scrollbar-thin"
              @mouseleave="closeDropdownDelayed">
              <div class="grid gap-2">
                <Link v-for="(subItem, index) in getSubItems('Company')" :key="subItem.label"
                  :href="subItem.href || '#'"
                  class="flex w-full items-center rounded-md p-2.5 text-sm hover:bg-accent hover:text-accent-foreground transition-all duration-200 hover:pl-4"
                  :style="{ transitionDelay: `${index * 30}ms` }">
                <component :is="subItem.icon" class="mr-3 h-4 w-4 transition-transform duration-300 hover:rotate-12" />
                {{ subItem.label }}
                </Link>
              </div>
            </div>
          </Transition>
        </div>
        <!--  Resources -->
        <!-- Resources - No dropdown, scroll to blog section -->
        <button @click="handleSectionClick('blog-section')"
          class="group inline-flex h-9 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50 hover:scale-105">
          <BookOpenIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
          Resources
        </button>
        <!-- Blog  Link -->
        <Link href="/agency/blog"
          class="group inline-flex h-9 w-max items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-all duration-300 hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground focus:outline-none disabled:pointer-events-none disabled:opacity-50 hover:scale-105">
          <FileTextIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
          Blog
        </Link>

      </nav>

      <!-- Right side controls -->
      <div class="hidden md:flex items-center gap-4 ml-auto">
        <!-- Theme toggle -->
        <button @click="toggleTheme"
          class="relative inline-flex h-9 w-9 items-center justify-center rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground transition-all duration-300 ease-in-out overflow-hidden hover:border-primary"
          aria-label="Toggle theme">
          <Transition mode="out-in">
            <SunIcon v-if="isDark" key="sun" class="h-4 w-4" />
            <MoonIcon v-else key="moon" class="h-4 w-4" />
          </Transition>
        </button>

        <!-- Admin Panel Link -->
        <div v-if="canViewAdmin">
          <Link href="/admin"
            class="group relative inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 overflow-hidden h-10 px-4 py-2 shadow-md transition-all duration-300 hover:scale-105">
          <span class="absolute inset-0 bg-gradient-to-r from-amber-500 to-orange-500"></span>
          <span
            class="absolute inset-0 bg-gradient-to-r from-amber-600 to-orange-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
          <span class="relative flex items-center text-white z-10">
            <BuildingIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
            <span class="tracking-wide">Admin</span>
            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
          </span>
          </Link>
        </div>

        <!-- User dropdown or login links -->
        <div v-if="auth.user">
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="ghost" size="icon"
                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary">
                <Avatar class="size-8 overflow-hidden rounded-full">
                  <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                  <AvatarFallback
                    class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                    {{ getInitials(auth.user.name) }}
                  </AvatarFallback>
                </Avatar>
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" class="w-56">
              <UserMenuContent :user="auth.user" />
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
        <div v-else class="flex items-center gap-2">
          <Link href="/login"
            class="group flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium transition-all duration-300 hover:text-primary hover:bg-accent/60 relative overflow-hidden">
          <span class="relative z-10 flex items-center gap-2">
            <UserIcon class="h-4 w-4 transition-transform duration-300 group-hover:rotate-12 group-hover:scale-110" />
            <span class="relative">
              Account
              <span
                class="absolute -bottom-0.5 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
            </span>
          </span>
          <span
            class="absolute inset-0 bg-primary/5 rounded-md transform scale-0 transition-transform duration-300 group-hover:scale-100"></span>
          </Link>
        </div>

        <!-- Contact Button - Changed to scroll to contact section -->
        <button @click="handleSectionClick('contact-section')"
          class="group relative inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 overflow-hidden h-10 px-4 py-2 shadow-md">
          <span
            class="absolute inset-0 bg-gradient-to-r from-primary to-purple-600 transition-all duration-300 group-hover:scale-105"></span>
          <span
            class="absolute inset-0 bg-gradient-to-r from-primary/90 to-purple-700 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
          <span class="relative flex items-center text-white z-10">
            <PhoneCallIcon class="mr-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
            <span class="tracking-wide">Contact Us</span>
          </span>
        </button>
      </div>

      <!-- Mobile menu button -->
      <div class="flex items-center gap-2 ml-auto md:hidden">
        <!-- Theme toggle -->
        <button @click="toggleTheme"
          class="relative inline-flex h-9 w-9 items-center justify-center rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground transition-all duration-300 ease-in-out overflow-hidden hover:border-primary"
          aria-label="Toggle theme">
          <Transition mode="out-in">
            <SunIcon v-if="isDark" key="sun" class="h-4 w-4" />
            <MoonIcon v-else key="moon" class="h-4 w-4" />
          </Transition>
        </button>

        <!-- Admin Panel Quick Access -->
        <div v-if="canViewAdmin">
          <Link href="/admin"
            class="relative inline-flex h-9 w-9 items-center justify-center rounded-md border-0 transition-all duration-300 ease-in-out overflow-hidden"
            aria-label="Admin Panel">
          <span class="absolute inset-0 bg-gradient-to-r from-amber-500 to-orange-500 rounded-md"></span>
          <BuildingIcon class="relative z-10 h-4 w-4 text-white" />
          <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
          </Link>
        </div>

        <!-- Mobile menu toggle -->
        <button @click="isOpen = !isOpen"
          class="inline-flex items-center justify-center rounded-md p-2 text-foreground dark:text-foreground hover:bg-accent hover:text-accent-foreground transition-all duration-300 ease-in-out"
          :class="{ 'bg-accent': isOpen }" aria-label="Toggle menu">
          <Transition mode="out-in">
            <MenuIcon v-if="!isOpen" key="menu" class="h-6 w-6" />
            <XIcon v-else key="close" class="h-6 w-6" />
          </Transition>
        </button>
      </div>
    </div>

    <!-- Mobile Navigation -->
    <Transition enter-active-class="transition-all duration-400 ease-out" enter-from-class="opacity-0 -translate-y-8"
      enter-to-class="opacity-100 translate-y-0" leave-active-class="transition-all duration-300 ease-in"
      leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-8">
      <div v-if="isOpen" class="container md:hidden py-4 max-h-[80vh] overflow-y-auto scrollbar-thin">
        <div class="space-y-2">
          <!-- Services - Mobile -->
          <div class="border-b border-border/40 last:border-0 animate-slideDown">
            <button
              class="flex w-full items-center justify-between rounded-md p-3 text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-all duration-300"
              @click="handleMobileSectionClick('service-section')">
              <div class="flex items-center">
                <SettingsIcon class="mr-3 h-5 w-5 transition-transform duration-300" />
                Services
              </div>
            </button>
          </div>

          <!-- Solutions - Mobile -->
          <div class="border-b border-border/40 last:border-0 animate-slideDown" style="animation-delay: 50ms;">
            <button
              class="flex w-full items-center justify-between rounded-md p-3 text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-all duration-300"
              @click="handleMobileSectionClick('portfolio-section')">
              <div class="flex items-center">
                <LayersIcon class="mr-3 h-5 w-5 transition-transform duration-300" />
                Solutions
              </div>
            </button>
          </div>

          <!-- Digital Marketing - Mobile -->
          <!-- <div class="border-b border-border/40 last:border-0 animate-slideDown" style="animation-delay: 100ms;">
            <button
              class="flex w-full items-center justify-between rounded-md p-3 text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-all duration-300"
              @click="toggleMobileSubmenu('Digital Marketing')">
              <div class="flex items-center">
                <BarChartIcon class="mr-3 h-5 w-5 transition-transform duration-300"
                  :class="{ 'rotate-12': mobileActiveSubmenu === 'Digital Marketing' }" />
                Digital Marketing
              </div>
              <ChevronDownIcon class="h-5 w-5 transition-transform duration-300"
                :class="{ 'rotate-180': mobileActiveSubmenu === 'Digital Marketing' }" />
            </button>

            <Transition enter-active-class="transition-all duration-500 ease-out" enter-from-class="max-h-0 opacity-0"
              enter-to-class="max-h-[500px] opacity-100" leave-active-class="transition-all duration-300 ease-in"
              leave-from-class="max-h-[500px] opacity-100" leave-to-class="max-h-0 opacity-0">
              <div v-if="mobileActiveSubmenu === 'Digital Marketing'"
                class="overflow-hidden bg-accent/5 dark:bg-accent/10 rounded-md my-2">
                <div class="py-2 space-y-1 max-h-[300px] overflow-y-auto scrollbar-thin">
                  <Link v-for="(subItem, subIndex) in getSubItems('Digital Marketing')" :key="subItem.label"
                    :href="subItem.href || '#'"
                    class="flex w-full items-center rounded-md mx-2 p-3 text-sm hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/20 dark:hover:text-accent-foreground transition-all duration-300 hover:pl-6"
                    :style="{ animationDelay: `${subIndex * 50}ms` }" :class="['animate-fadeIn']">
                  <component :is="subItem.icon"
                    class="mr-3 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
                  {{ subItem.label }}
                  </Link>
                </div>
              </div>
            </Transition>
          </div> -->

          <!-- Company - Mobile -->
          <div class="border-b border-border/40 last:border-0 animate-slideDown" style="animation-delay: 150ms;">
            <button
              class="flex w-full items-center justify-between rounded-md p-3 text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-all duration-300"
              @click="toggleMobileSubmenu('Company')">
              <div class="flex items-center">
                <BuildingIcon class="mr-3 h-5 w-5 transition-transform duration-300"
                  :class="{ 'rotate-12': mobileActiveSubmenu === 'Company' }" />
                Company
              </div>
              <ChevronDownIcon class="h-5 w-5 transition-transform duration-300"
                :class="{ 'rotate-180': mobileActiveSubmenu === 'Company' }" />
            </button>

            <Transition enter-active-class="transition-all duration-500 ease-out" enter-from-class="max-h-0 opacity-0"
              enter-to-class="max-h-[500px] opacity-100" leave-active-class="transition-all duration-300 ease-in"
              leave-from-class="max-h-[500px] opacity-100" leave-to-class="max-h-0 opacity-0">
              <div v-if="mobileActiveSubmenu === 'Company'"
                class="overflow-hidden bg-accent/5 dark:bg-accent/10 rounded-md my-2">
                <div class="py-2 space-y-1 max-h-[300px] overflow-y-auto scrollbar-thin">
                  <Link v-for="(subItem, subIndex) in getSubItems('Company')" :key="subItem.label"
                    :href="subItem.href || '#'"
                    class="flex w-full items-center rounded-md mx-2 p-3 text-sm hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/20 dark:hover:text-accent-foreground transition-all duration-300 hover:pl-6"
                    :style="{ animationDelay: `${subIndex * 50}ms` }" :class="['animate-fadeIn']">
                  <component :is="subItem.icon"
                    class="mr-3 h-4 w-4 transition-transform duration-300 group-hover:rotate-12" />
                  {{ subItem.label }}
                  </Link>
                </div>
              </div>
            </Transition>
          </div>
          <!-- Resources - Mobile -->
          <div class="border-b border-border/40 last:border-0 animate-slideDown" style="animation-delay: 200ms;">
            <button
              class="flex w-full items-center justify-between rounded-md p-3 text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-all duration-300"
              @click="handleMobileSectionClick('blog-section')">
              <div class="flex items-center">
                <BookOpenIcon class="mr-3 h-5 w-5 transition-transform duration-300" />
                Resources
              </div>
            </button>
          </div>
          <!-- Blog - Mobile -->
          <div class="border-b border-border/40 last:border-0 animate-slideDown" style="animation-delay: 250ms;">
            <Link href="/agency/blog"
              class="flex w-full items-center justify-between rounded-md p-3 text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-all duration-300">
            <div class="flex items-center">
              <FileTextIcon class="mr-3 h-5 w-5 transition-transform duration-300" />
              Blog
            </div>
            </Link>
          </div>

          <!-- Mobile user section -->
          <div v-if="auth.user" class="px-4 py-3 border-t border-border/40">
            <div class="flex items-center gap-3">
              <div class="relative w-10 h-10 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                <img v-if="auth.user.avatar" :src="auth.user.avatar" class="object-cover w-full h-full" />
                <span v-else class="flex items-center justify-center w-full h-full text-sm font-medium">
                  {{ getInitials(auth.user.name) }}
                </span>
              </div>
              <div>
                <p class="text-sm font-medium">{{ auth.user.name }}</p>
                <p class="text-xs text-muted-foreground">{{ auth.user.email }}</p>
              </div>
            </div>
            <div class="mt-3 space-y-1">
              <Link href="/profile" class="block px-2 py-1.5 text-sm rounded hover:bg-accent">Profile</Link>
              <Link href="/settings" class="block px-2 py-1.5 text-sm rounded hover:bg-accent">Settings</Link>
              <Link v-if="auth.user.is_admin" href="/admin" class="block px-2 py-1.5 text-sm rounded hover:bg-accent">
              Admin Panel
              </Link>
              <Link href="/logout" method="post" as="button"
                class="block w-full px-2 py-1.5 text-sm text-left rounded hover:bg-accent">
              Sign out
              </Link>
            </div>
          </div>
          <div v-else class="px-4 py-3 border-t border-border/40 space-y-2">
            <Link href="/login" class="block w-full px-2 py-1.5 text-sm rounded hover:bg-accent text-center">
            Account
            </Link>
          </div>

          <!-- Mobile Contact Button -->
          <button @click="handleMobileSectionClick('contact-section')"
            class="group relative flex w-full items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 overflow-hidden h-12 px-4 py-2 mt-4 shadow-md animate-slideUp">
            <span
              class="absolute inset-0 bg-gradient-to-r from-primary to-purple-600 transition-all duration-300 group-hover:scale-105"></span>
            <span
              class="absolute inset-0 bg-gradient-to-r from-primary/90 to-purple-700 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
            <span class="relative flex items-center text-white z-10">
              <PhoneCallIcon class="mr-3 h-5 w-5 transition-transform duration-300 group-hover:rotate-12" />
              <span class="tracking-wide">Contact Us</span>
            </span>
          </button>
        </div>
      </div>
    </Transition>
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { Link, usePage, router as Inertia } from '@inertiajs/vue3'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Button } from '@/components/ui/button'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import UserMenuContent from '@/components/UserMenuContent.vue'
import { UserIcon } from 'lucide-vue-next';
import {
  CodeIcon,
  MenuIcon,
  XIcon,
  ChevronDownIcon,
  SunIcon,
  MoonIcon,
  PhoneCallIcon,
  BuildingIcon,
  BookOpenIcon,
  LockIcon,
  SettingsIcon,
  SmartphoneIcon,
  CodepenIcon,
  MonitorIcon,
  PaletteIcon,
  ServerIcon,
  LayoutIcon,
  BrainCircuitIcon,
  DatabaseIcon,
  CloudIcon,
  LayersIcon,
  ShoppingCartIcon,
  DollarSignIcon,
  HeartPulseIcon,
  GraduationCapIcon,
  BarChartIcon,
  SearchIcon,
  FileTextIcon,
  UsersIcon,
  MousePointerClickIcon,
  LineChartIcon,
  InfoIcon,
  BriefcaseIcon
} from 'lucide-vue-next'

const page = usePage()
const auth = computed(() => page.props.auth)
const canViewAdmin = computed(() => page.props.canViewAdmin)

const isOpen = ref(false)
const activeDropdown = ref<string | null>(null)
const mobileActiveSubmenu = ref<string | null>(null)
const isDark = ref(false)

const getInitials = (name: string) => {
  if (!name) return '?'
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

const toggleDropdown = (label: string) => {
  activeDropdown.value = activeDropdown.value === label ? null : label
}

const closeDropdownDelayed = () => {
  setTimeout(() => {
    activeDropdown.value = null
  }, 200)
}

const toggleMobileSubmenu = (label: string) => {
  mobileActiveSubmenu.value = mobileActiveSubmenu.value === label ? null : label
}

const toggleTheme = () => {
  isDark.value = !isDark.value
  updateTheme()
}

const updateTheme = () => {
  const root = document.documentElement
  if (isDark.value) {
    root.classList.add('dark')
  } else {
    root.classList.remove('dark')
  }
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

// Handle section clicks for desktop
const handleSectionClick = (sectionId: string) => {
  if (window.location.pathname !== '/') {
    // Navigate to home with hash
    Inertia.visit(`/#${sectionId}`, {
      onFinish: () => {
        scrollToSection(sectionId)
      }
    })
  } else {
    scrollToSection(sectionId)
  }
}

// Handle section clicks for mobile
const handleMobileSectionClick = (sectionId: string) => {
  isOpen.value = false // Close mobile menu

  if (window.location.pathname !== '/') {
    Inertia.visit(`/#${sectionId}`, {
      onFinish: () => {
        setTimeout(() => {
          scrollToSection(sectionId)
        }, 300)
      }
    })
  } else {
    setTimeout(() => {
      scrollToSection(sectionId)
    }, 300)
  }
}

// Scroll to section functionality
const scrollToSection = (sectionId: string) => {
  const section = document.getElementById(sectionId)
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' })
  } else {
    // If section not found, try to find by class name
    const sectionByClass = document.querySelector(`.${sectionId}`)
    if (sectionByClass) {
      sectionByClass.scrollIntoView({ behavior: 'smooth' })
    }
  }
}

// Get sub-items for a specific menu
const getSubItems = (label: string) => {
  const item = navItems.find(item => item.label === label)
  return item ? item.subItems : []
}

onMounted(() => {
  const savedTheme = localStorage.getItem('theme')
  if (savedTheme) {
    isDark.value = savedTheme === 'dark'
  } else {
    isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches
  }
  updateTheme()

  // Handle hash on page load
  if (window.location.hash) {
    const sectionId = window.location.hash.substring(1)
    setTimeout(() => {
      scrollToSection(sectionId)
    }, 100)
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    if (!localStorage.getItem('theme')) {
      isDark.value = e.matches
      updateTheme()
    }
  })
})

const navItems = [
  {
    label: 'Services',
    icon: SettingsIcon,
    subItems: [
      { label: 'Custom Software Development', icon: CodepenIcon, href: '/services/custom-software' },
      { label: 'Web Development', icon: MonitorIcon, href: '/services/web-development' },
      { label: 'Mobile App Development', icon: SmartphoneIcon, href: '/services/mobile-apps' },
      { label: 'UI/UX Design', icon: PaletteIcon, href: '/services/ui-ux-design' },
      { label: 'Cloud Solutions', icon: CloudIcon, href: '/services/cloud-solutions' },
      { label: 'DevOps Services', icon: ServerIcon, href: '/services/devops' }
    ]
  },
  {
    label: 'Solutions',
    icon: LayersIcon,
    subItems: [
      { label: 'E-commerce', icon: ShoppingCartIcon, href: '/solutions/ecommerce' },
      { label: 'Enterprise Solutions', icon: BuildingIcon, href: '/solutions/enterprise' },
      { label: 'Fintech', icon: DollarSignIcon, href: '/solutions/fintech' },
      { label: 'Healthcare', icon: HeartPulseIcon, href: '/solutions/healthcare' },
      { label: 'Education', icon: GraduationCapIcon, href: '/solutions/education' }
    ]
  },
  // {
  //   label: 'Digital Marketing',
  //   icon: BarChartIcon,
  //   subItems: [
  //     { label: 'SEO Optimization', icon: SearchIcon, href: '/marketing/seo' },
  //     { label: 'Content Marketing', icon: FileTextIcon, href: '/marketing/content' },
  //     { label: 'Social Media Management', icon: UsersIcon, href: '/marketing/social-media' },
  //     { label: 'PPC Advertising', icon: MousePointerClickIcon, href: '/marketing/ppc' },
  //     { label: 'Analytics & Reporting', icon: LineChartIcon, href: '/marketing/analytics' }
  //   ]
  // },
  {
    label: 'Company',
    icon: BuildingIcon,
    subItems: [
      { label: 'About Us', icon: InfoIcon, href: '/about-us' },
      { label: 'Our Team', icon: UsersIcon, href: '/agency/our-team' },
      { label: 'Blog', icon: FileTextIcon, href: '/agency/blog' },
      // { label: 'Careers', icon: BriefcaseIcon, href: '/careers' },
      // { label: 'Contact', icon: PhoneCallIcon, href: '/contact' }
    ]
  }
]
</script>

<style scoped>
/* Your existing styles */
/* Add smooth transitions for theme changes */
:root {
  --transition-duration: 0.3s;
}

* {
  transition: background-color var(--transition-duration) ease,
    border-color var(--transition-duration) ease,
    color var(--transition-duration) ease,
    box-shadow var(--transition-duration) ease;
}

/* Animation keyframes */
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

/* Animation classes */
.animate-slideDown {
  animation: slideDown 0.4s ease forwards;
}

.animate-slideUp {
  animation: slideUp 0.4s ease forwards;
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease forwards;
}

.animation-delay-100 {
  animation-delay: 100ms;
}

/* Enhanced spacing for dropdown items */
.group:hover .group-hover\:rotate-12 {
  transform: rotate(12deg);
}

/* Pulse animation for notification dot */
@keyframes pulse {

  0%,
  100% {
    opacity: 1;
    transform: scale(1);
  }

  50% {
    opacity: 0.7;
    transform: scale(1.2);
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Custom scrollbar styling */
.scrollbar-thin {
  scrollbar-width: thin;
  scrollbar-color: rgba(155, 155, 155, 0.5) transparent;
}

.scrollbar-thin::-webkit-scrollbar {
  width: 4px;
}

.scrollbar-thin::-webkit-scrollbar-track {
  background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
  background-color: rgba(155, 155, 155, 0.5);
  border-radius: 20px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
  background-color: rgba(155, 155, 155, 0.8);
}

/* Dark mode specific styles */
:root.dark .bg-accent\/5 {
  background-color: rgba(255, 255, 255, 0.05);
}

:root.dark .hover\:bg-accent\/20:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

:root.dark .text-foreground {
  color: rgba(255, 255, 255, 0.9);
}

:root.dark .border-border\/40 {
  border-color: rgba(255, 255, 255, 0.1);
}

:root.dark .scrollbar-thin::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.3);
}

:root.dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
  background-color: rgba(255, 255, 255, 0.5);
}
</style>
