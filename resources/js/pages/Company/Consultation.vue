<template>
  <Head title="Free Consultation - TechXtraSol Technology Solutions" />
  <PublicLayout>
    <div class="min-h-screen bg-background text-foreground">

      <!-- Streamlined Service Selection -->
      <section class="py-12 sm:py-16 bg-background" aria-labelledby="services-heading">
        <div class="container mx-auto px-4">
          <header class="text-center mb-8 sm:mb-12">
            <h1
              id="services-heading"
              class="text-3xl md:text-4xl font-bold mb-4"
              v-motion
              :initial="{ opacity: 0, y: 30 }"
              :visible="{ opacity: 1, y: 0, transition: { duration: 600 } }"
            >
              Choose Your Service
            </h1>
            <p class="text-lg text-muted-foreground max-w-xl mx-auto">
              Select a service to get started with your free consultation.
            </p>
          </header>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <article
              v-for="(service, index) in serviceCards"
              :key="service.value"
              class="service-card relative overflow-hidden rounded-xl cursor-pointer group"
              :class="{ 'service-card-active': selectedService === service.value }"
              v-motion
              :initial="{ opacity: 0, scale: 0.95 }"
              :visible="{ opacity: 1, scale: 1, transition: { delay: index * 100, duration: 500 } }"
              @click="selectService(service.value)"
              :aria-label="`Select ${service.title} service`"
              tabindex="0"
              @keydown.enter="selectService(service.value)"
              @keydown.space.prevent="selectService(service.value)"
            >
              <div class="service-card-glow absolute inset-0 opacity-0 transition-opacity duration-500" aria-hidden="true"></div>
              <div class="relative z-10 p-6 h-full flex flex-col bg-card rounded-xl border border-border transition-all duration-300 hover:shadow-lg">
                <div class="w-12 h-12 mb-4 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                  <component :is="service.icon" class="w-6 h-6 text-primary" aria-hidden="true" />
                </div>
                <h3 class="text-lg font-semibold mb-2">{{ service.title }}</h3>
                <p class="text-muted-foreground text-sm flex-grow">{{ service.description }}</p>
                <div class="flex items-center text-primary font-medium text-sm mt-3">
                  <span>Select Service</span>
                  <ArrowRight class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" aria-hidden="true" />
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- Simplified Process Section -->
      <section class="py-12 sm:py-16 bg-muted/30" aria-labelledby="process-heading">
        <div class="container mx-auto px-4">
          <header class="text-center mb-8 sm:mb-12">
            <h2
              id="process-heading"
              class="text-2xl md:text-3xl font-bold mb-3"
              v-motion
              :initial="{ opacity: 0, y: 30 }"
              :visible="{ opacity: 1, y: 0, transition: { duration: 600 } }"
            >
              Simple 3-Step Process
            </h2>
            <p class="text-muted-foreground max-w-lg mx-auto">
              From consultation to project delivery in three streamlined steps.
            </p>
          </header>

          <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            <article
              v-for="(step, index) in consultationSteps"
              :key="index"
              class="bg-card p-6 rounded-lg border border-border relative text-center"
              v-motion
              :initial="{ opacity: 0, y: 30 }"
              :visible="{ opacity: 1, y: 0, transition: { delay: index * 150, duration: 600 } }"
            >
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4 mx-auto">
                <component :is="step.icon" class="w-6 h-6 text-primary" aria-hidden="true" />
              </div>
              <span class="absolute top-4 right-4 text-3xl font-bold text-muted/20" aria-hidden="true">{{ index + 1 }}</span>
              <h3 class="text-lg font-semibold mb-2">{{ step.title }}</h3>
              <p class="text-muted-foreground text-sm">{{ step.description }}</p>
            </article>
          </div>
        </div>
      </section>

      <!-- Condensed Expertise Section -->
      <section class="py-12 sm:py-16 bg-background" aria-labelledby="expertise-heading">
        <div class="container mx-auto px-4">
          <header class="text-center mb-8 sm:mb-12">
            <h2
              id="expertise-heading"
              class="text-2xl md:text-3xl font-bold mb-3"
              v-motion
              :initial="{ opacity: 0, y: 30 }"
              :visible="{ opacity: 1, y: 0, transition: { duration: 600 } }"
            >
              Our Expertise
            </h2>
            <p class="text-muted-foreground max-w-lg mx-auto">
              Cutting-edge solutions powered by modern technologies.
            </p>
          </header>

          <div class="grid md:grid-cols-2 gap-6 lg:gap-8">
            <article
              v-for="(service, index) in services"
              :key="index"
              class="flex gap-4"
              v-motion
              :initial="{ opacity: 0, x: index % 2 === 0 ? -30 : 30 }"
              :visible="{ opacity: 1, x: 0, transition: { delay: index * 150, duration: 600 } }"
            >
              <div class="w-12 h-12 bg-primary/10 rounded-lg flex-shrink-0 flex items-center justify-center">
                <component :is="service.icon" class="w-6 h-6 text-primary" aria-hidden="true" />
              </div>
              <div>
                <h3 class="text-lg font-semibold mb-2">{{ service.title }}</h3>
                <p class="text-muted-foreground text-sm mb-3">{{ service.description }}</p>
                <div class="flex flex-wrap gap-1.5">
                  <span
                    v-for="(tech, techIndex) in service.technologies.slice(0, 3)"
                    :key="techIndex"
                    class="px-2 py-1 bg-secondary text-secondary-foreground text-xs rounded-md"
                  >
                    {{ tech }}
                  </span>
                  <span
                    v-if="service.technologies.length > 3"
                    class="px-2 py-1 bg-muted text-muted-foreground text-xs rounded-md"
                  >
                    +{{ service.technologies.length - 3 }} more
                  </span>
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- Streamlined Success Stories -->
      <section class="py-12 sm:py-16 bg-card" aria-labelledby="success-heading">
        <div class="container mx-auto px-4">
          <header class="text-center mb-8 sm:mb-12">
            <h2
              id="success-heading"
              class="text-2xl md:text-3xl font-bold mb-3"
              v-motion
              :initial="{ opacity: 0, y: 30 }"
              :visible="{ opacity: 1, y: 0, transition: { duration: 600 } }"
            >
              Proven Results
            </h2>
            <p class="text-muted-foreground max-w-lg mx-auto">
              Real outcomes from our client partnerships.
            </p>
          </header>

          <div class="grid md:grid-cols-3 gap-6">
            <article
              v-for="(caseStudy, index) in caseStudies"
              :key="index"
              class="bg-background border border-border rounded-lg overflow-hidden hover:shadow-md transition-shadow"
              v-motion
              :initial="{ opacity: 0, scale: 0.95 }"
              :visible="{ opacity: 1, scale: 1, transition: { delay: index * 150, duration: 600 } }"
            >
              <div class="h-32 bg-accent/50 relative">
                <div class="absolute inset-0 flex items-center justify-center">
                  <component :is="caseStudy.icon" class="w-10 h-10 text-primary/60" aria-hidden="true" />
                </div>
              </div>
              <div class="p-4">
                <h3 class="font-semibold mb-1">{{ caseStudy.title }}</h3>
                <p class="text-muted-foreground text-xs mb-2">{{ caseStudy.industry }}</p>
                <p class="text-muted-foreground text-sm mb-3">{{ caseStudy.description }}</p>
                <div class="flex justify-between items-center">
                  <span class="text-primary font-medium text-sm">{{ caseStudy.result }}</span>
                  <ArrowUpRight class="w-4 h-4 text-primary" aria-hidden="true" />
                </div>
              </div>
            </article>
          </div>
        </div>
      </section>

      <!-- Enhanced Booking Section (Form Logic Preserved) -->
      <section id="booking" class="py-12 sm:py-16 bg-muted/30" aria-labelledby="booking-heading">
        <div class="container mx-auto px-4">
          <div class="max-w-4xl mx-auto bg-card rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">
              <div class="md:w-2/5 bg-primary p-8 lg:p-10 text-primary-foreground">
                <div
                  v-motion
                  :initial="{ opacity: 0, x: -30 }"
                  :visible="{ opacity: 1, x: 0, transition: { duration: 600 } }"
                >
                  <h2 id="booking-heading" class="text-2xl lg:text-3xl font-bold mb-4">Ready to Get Started?</h2>
                  <p class="mb-6 text-primary-foreground/90">
                    Schedule your free 30-minute consultation and discover how we can help achieve your goals.
                  </p>
                  <div class="space-y-3 mb-6">
                    <div class="flex items-center text-sm">
                      <Check class="w-4 h-4 mr-3 flex-shrink-0" aria-hidden="true" />
                      <span>Free strategy session</span>
                    </div>
                    <div class="flex items-center text-sm">
                      <Check class="w-4 h-4 mr-3 flex-shrink-0" aria-hidden="true" />
                      <span>No obligation consultation</span>
                    </div>
                    <div class="flex items-center text-sm">
                      <Check class="w-4 h-4 mr-3 flex-shrink-0" aria-hidden="true" />
                      <span>Clear action plan</span>
                    </div>
                  </div>
                  <div class="flex items-center text-sm">
                    <Phone class="w-4 h-4 mr-3 flex-shrink-0" aria-hidden="true" />
                    <span>Call: +254714000481</span>
                  </div>
                </div>
              </div>
              <div class="md:w-3/5 p-8 lg:p-10">
                <form
                  @submit.prevent="submitForm"
                  v-motion
                  :initial="{ opacity: 0, x: 30 }"
                  :visible="{ opacity: 1, x: 0, transition: { duration: 600 } }"
                  novalidate
                >
                  <h3 class="text-xl font-bold mb-6">Book Your Consultation</h3>

                  <div class="space-y-4">
                    <div>
                      <label class="block text-sm font-medium mb-1" for="name">
                        Full Name *
                      </label>
                      <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="w-full px-3 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                        required
                        aria-describedby="name-error"
                      />
                      <div v-if="form.errors.name" id="name-error" class="text-destructive text-sm mt-1">{{ form.errors.name }}</div>
                    </div>

                    <div>
                      <label class="block text-sm font-medium mb-1" for="email">
                        Email Address *
                      </label>
                      <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="w-full px-3 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                        required
                        aria-describedby="email-error"
                      />
                      <div v-if="form.errors.email" id="email-error" class="text-destructive text-sm mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div>
                      <label class="block text-sm font-medium mb-1" for="phone">
                        Phone Number
                      </label>
                      <input
                        id="phone"
                        v-model="form.phone"
                        type="tel"
                        class="w-full px-3 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                        aria-describedby="phone-error"
                      />
                      <div v-if="form.errors.phone" id="phone-error" class="text-destructive text-sm mt-1">{{ form.errors.phone }}</div>
                    </div>

                    <div>
                      <label class="block text-sm font-medium mb-1" for="service">
                        Service Interest *
                      </label>
                      <select
                        id="service"
                        v-model="form.service"
                        class="w-full px-3 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors"
                        required
                        aria-describedby="service-error"
                      >
                        <option value="" disabled>Select a service</option>
                        <option v-for="service in serviceCards" :key="service.value" :value="service.value">
                          {{ service.title }}
                        </option>
                        <option value="multiple">Multiple Services</option>
                      </select>
                      <div v-if="form.errors.service" id="service-error" class="text-destructive text-sm mt-1">{{ form.errors.service }}</div>
                    </div>

                    <div>
                      <label class="block text-sm font-medium mb-1" for="message">
                        Project Details
                      </label>
                      <textarea
                        id="message"
                        v-model="form.message"
                        rows="3"
                        class="w-full px-3 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-vertical"
                        placeholder="Tell us about your project goals and requirements..."
                        aria-describedby="message-error"
                      ></textarea>
                      <div v-if="form.errors.message" id="message-error" class="text-destructive text-sm mt-1">{{ form.errors.message }}</div>
                    </div>
                  </div>

                  <button
                    type="submit"
                    class="w-full mt-6 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-md font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                    :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                    :disabled="isSubmitting"
                    v-motion
                    :initial="{ scale: 1 }"
                    :hover="{ scale: 1.02 }"
                  >
                    <span v-if="isSubmitting" class="flex items-center justify-center">
                      <Loader2 class="w-4 h-4 mr-2 animate-spin" aria-hidden="true" />
                      Submitting...
                    </span>
                    <span v-else>Schedule Free Consultation</span>
                  </button>

                  <div v-if="formSubmitted" class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 rounded-md border border-green-200 dark:border-green-800">
                    <div class="flex items-center">
                      <Check class="w-5 h-5 mr-2 flex-shrink-0" aria-hidden="true" />
                      <span class="text-sm">Thank you! We'll contact you within 24 hours to confirm your appointment.</span>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Simplified FAQ Section -->
      <section class="py-12 sm:py-16 bg-background" aria-labelledby="faq-heading">
        <div class="container mx-auto px-4">
          <header class="text-center mb-8 sm:mb-12">
            <h2
              id="faq-heading"
              class="text-2xl md:text-3xl font-bold mb-3"
              v-motion
              :initial="{ opacity: 0, y: 30 }"
              :visible="{ opacity: 1, y: 0, transition: { duration: 600 } }"
            >
              Common Questions
            </h2>
            <p class="text-muted-foreground max-w-lg mx-auto">
              Quick answers to help you get started.
            </p>
          </header>

          <div class="max-w-2xl mx-auto">
            <div
              v-for="(faq, index) in faqs"
              :key="index"
              class="mb-3 border border-border rounded-lg overflow-hidden"
              v-motion
              :initial="{ opacity: 0, y: 20 }"
              :visible="{ opacity: 1, y: 0, transition: { delay: index * 80, duration: 400 } }"
            >
              <button
                class="w-full px-4 py-3 text-left bg-card hover:bg-accent flex justify-between items-center transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-inset"
                @click="toggleFaq(index)"
                :aria-expanded="faq.isOpen"
                :aria-controls="`faq-answer-${index}`"
              >
                <span class="font-medium text-sm">{{ faq.question }}</span>
                <ChevronDown
                  class="w-4 h-4 text-muted-foreground transition-transform flex-shrink-0 ml-2"
                  :class="{ 'transform rotate-180': faq.isOpen }"
                  aria-hidden="true"
                />
              </button>
              <div
                v-if="faq.isOpen"
                :id="`faq-answer-${index}`"
                class="px-4 py-3 bg-accent/30 text-accent-foreground"
              >
                <p class="text-sm">{{ faq.answer }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Newsletter Subscription -->
      <Newsletter class="mt-8 mx-5 mb-8 md:mt-12"/>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import Newsletter from './Newsletter.vue'
import { ref, reactive, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import { useMotion } from '@vueuse/motion'
import {
  ArrowRight,
  ArrowUpRight,
  Check,
  ChevronDown,
  Loader2,
  MessageSquare,
  Phone,
  Code,
  Database,
  Share2,
  Cpu,
  Lightbulb,
  FileCheck,
  Smartphone
} from 'lucide-vue-next'

// Form state (preserving original logic)
const form = useForm({
  name: '',
  email: '',
  phone: '',
  service: '',
  message: ''
})

const isSubmitting = ref(false)
const formSubmitted = ref(false)
const selectedService = ref('')

// Streamlined consultation steps
const consultationSteps = [
  {
    icon: MessageSquare,
    title: 'Free Consultation',
    description: '30-minute call to understand your goals and challenges.'
  },
  {
    icon: Lightbulb,
    title: 'Custom Strategy',
    description: 'Tailored proposal based on your specific needs.'
  },
  {
    icon: FileCheck,
    title: 'Project Launch',
    description: 'Kickoff meeting with clear timelines and deliverables.'
  }
]

// Condensed services data
const services = [
  {
    icon: Code,
    title: 'Web Development',
    description: 'High-performance websites and applications that deliver results.',
    technologies: ['React', 'Vue', 'Next.js', 'Node.js', 'TypeScript']
  },
  {
    icon: Database,
    title: 'System Architecture',
    description: 'Scalable systems that support growth and efficiency.',
    technologies: ['AWS', 'Azure', 'Docker', 'Kubernetes', 'Microservices']
  },
  {
    icon: Share2,
    title: 'Digital Marketing',
    description: 'Strategic campaigns that build awareness and drive engagement.',
    technologies: ['SEO', 'Content Strategy', 'Analytics', 'Social Media']
  },
  {
    icon: Cpu,
    title: 'AI Solutions',
    description: 'Intelligent automation for process optimization.',
    technologies: ['Machine Learning', 'NLP', 'Computer Vision', 'Analytics']
  }
]

// Streamlined service cards
const serviceCards = [
  {
    icon: Code,
    title: 'Web Development',
    value: 'web-development',
    description: 'Modern websites and applications built for performance.'
  },
  {
    icon: Smartphone,
    title: 'Mobile Apps',
    value: 'app-development',
    description: 'Native and cross-platform mobile solutions.'
  },
  {
    icon: Cpu,
    title: 'AI Integration',
    value: 'ai-integration',
    description: 'Smart automation and intelligent insights.'
  },
  {
    icon: Share2,
    title: 'Digital Marketing',
    value: 'social-media',
    description: 'Strategic growth through digital channels.'
  }
]

// Condensed case studies
const caseStudies = [
  {
    icon: Database,
    title: 'E-commerce Transformation',
    industry: 'Retail',
    description: 'Complete platform rebuild with improved performance.',
    result: '156% conversion increase'
  },
  {
    icon: Cpu,
    title: 'AI Customer Service',
    industry: 'Finance',
    description: 'Automated support system reducing response times.',
    result: '72% faster responses'
  },
  {
    icon: Share2,
    title: 'Brand Growth Campaign',
    industry: 'Hospitality',
    description: 'Comprehensive social media strategy execution.',
    result: '3x follower growth'
  }
]

// Simplified FAQ data
const faqs = reactive([
  {
    question: 'How long is the consultation?',
    answer: 'Our initial consultation is 30 minutes, with a proposal delivered within 2-3 business days.',
    isOpen: false
  },
  {
    question: 'Do you provide ongoing support?',
    answer: 'Yes, we offer customized support and maintenance packages for all projects.',
    isOpen: false
  },
  {
    question: 'What are your pricing options?',
    answer: 'Pricing varies by project scope. We provide transparent pricing in our proposal after consultation.',
    isOpen: false
  },
  {
    question: 'How do revisions work?',
    answer: 'Each project includes specific revision rounds. Our collaborative approach minimizes major changes.',
    isOpen: false
  },
  {
    question: 'Can you integrate with existing systems?',
    answer: 'Absolutely. We have extensive experience working with various existing systems and tools.',
    isOpen: false
  }
])

// Methods (preserving original form logic)
const toggleFaq = (index: number) => {
  faqs[index].isOpen = !faqs[index].isOpen
}

const scrollToBooking = () => {
  const bookingSection = document.getElementById('booking')
  if (bookingSection) {
    bookingSection.scrollIntoView({ behavior: 'smooth' })
  }
}

const submitForm = () => {
  isSubmitting.value = true

  form.post('/consultation', {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      isSubmitting.value = false
      formSubmitted.value = true

      // Reset form
      form.name = ''
      form.email = ''
      form.phone = ''
      form.service = ''
      form.message = ''

      // Hide success message after 5s
      setTimeout(() => {
        formSubmitted.value = false
      }, 5000)
    },
    onError: () => {
      isSubmitting.value = false
    }
  })
}

const selectService = (service: string) => {
  selectedService.value = service
  form.service = service
  scrollToBooking()
}
</script>

<style scoped>
.service-card {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.service-card:hover .service-card-glow,
.service-card-active .service-card-glow {
  opacity: 1;
}

.service-card-glow {
  background: radial-gradient(
    circle at center,
    hsl(var(--primary) / 0.2) 0%,
    transparent 70%
  );
  filter: blur(20px);
}

.service-card-active {
  transform: translateY(-4px);
}

.service-card-active > div {
  border-color: hsl(var(--primary) / 0.5);
  box-shadow: 0 8px 25px -5px hsl(var(--primary) / 0.1);
}

/* Enhanced focus styles for accessibility */
.service-card:focus-visible {
  outline: 2px solid hsl(var(--primary));
  outline-offset: 2px;
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  .service-card,
  * {
    transition: none !important;
    animation: none !important;
  }
}

/* Performance optimizations */
.service-card:hover {
  will-change: transform;
}

.service-card:not(:hover) {
  will-change: auto;
}
</style>
