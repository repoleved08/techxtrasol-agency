<template>
  <Head title="Consultation" />
  <PublicLayout>
  <div class="min-h-screen bg-background text-foreground">
    <!-- Hero Section -->

    <!-- Service Cards Section -->
    <section class="py-16 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2
            class="text-3xl md:text-4xl font-bold mb-4"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          >
            Our Services
          </h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            Select a service to get started with your consultation.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="(service, index) in serviceCards"
            :key="index"
            class="service-card relative overflow-hidden rounded-xl cursor-pointer"
            :class="{ 'service-card-active': selectedService === service.value }"
            v-motion
            :initial="{ opacity: 0, scale: 0.9 }"
            :visible="{ opacity: 1, scale: 1, transition: { delay: index * 150, duration: 600 } }"
            @click="selectService(service.value)"
          >
            <div class="service-card-glow absolute inset-0 opacity-0 transition-opacity duration-500"></div>
            <div class="relative z-10 p-8 h-full flex flex-col bg-card rounded-xl border border-border transition-all duration-300 hover:shadow-lg">
              <div class="w-16 h-16 mb-6 rounded-full bg-primary/10 flex items-center justify-center">
                <component :is="service.icon" class="w-8 h-8 text-primary" />
              </div>
              <h3 class="text-xl font-semibold mb-3">{{ service.title }}</h3>
              <p class="text-muted-foreground mb-4 flex-grow">{{ service.description }}</p>
              <div class="flex items-center text-primary font-medium">
                <span>Learn more</span>
                <ArrowRight class="w-4 h-4 ml-2" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Consultation Process Section -->
    <section id="process" class="py-20 bg-muted/50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2
            class="text-3xl md:text-4xl font-bold mb-4"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          >
            Our Consultation Process
          </h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            We've streamlined our consultation process to ensure you get maximum value with minimal hassle.
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <div
            v-for="(step, index) in consultationSteps"
            :key="index"
            class="bg-card p-8 rounded-lg shadow-md relative"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { delay: index * 200, duration: 800 } }"
          >
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
              <component :is="step.icon" class="w-8 h-8 text-primary" />
            </div>
            <span class="absolute top-6 right-6 text-6xl font-bold text-muted/20">{{ index + 1 }}</span>
            <h3 class="text-xl font-semibold mb-3">{{ step.title }}</h3>
            <p class="text-muted-foreground">{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Expertise Section -->
    <section id="expertise" class="py-20 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2
            class="text-3xl md:text-4xl font-bold mb-4"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          >
            Our Expertise
          </h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            TechXtraSol specializes in cutting-edge digital solutions that drive business growth.
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
          <div
            v-for="(service, index) in services"
            :key="index"
            class="flex gap-6"
            v-motion
            :initial="{ opacity: 0, x: index % 2 === 0 ? -50 : 50 }"
            :visible="{ opacity: 1, x: 0, transition: { delay: index * 200, duration: 800 } }"
          >
            <div class="w-16 h-16 bg-primary/10 rounded-full flex-shrink-0 flex items-center justify-center">
              <component :is="service.icon" class="w-8 h-8 text-primary" />
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-3">{{ service.title }}</h3>
              <p class="text-muted-foreground mb-4">{{ service.description }}</p>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="(tech, techIndex) in service.technologies"
                  :key="techIndex"
                  class="px-3 py-1 bg-secondary text-secondary-foreground text-sm rounded-full"
                >
                  {{ tech }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Case Studies Section -->
    <section class="py-20 bg-card text-card-foreground">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2
            class="text-3xl md:text-4xl font-bold mb-4"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          >
            Success Stories
          </h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            See how we've helped businesses like yours achieve their digital goals.
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <div
            v-for="(caseStudy, index) in caseStudies"
            :key="index"
            class="bg-card border border-border rounded-lg overflow-hidden"
            v-motion
            :initial="{ opacity: 0, scale: 0.9 }"
            :visible="{ opacity: 1, scale: 1, transition: { delay: index * 200, duration: 800 } }"
          >
            <div class="h-48 bg-accent relative">
              <div class="absolute inset-0 flex items-center justify-center">
                <component :is="caseStudy.icon" class="w-16 h-16 text-primary/50" />
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">{{ caseStudy.title }}</h3>
              <p class="text-muted-foreground text-sm mb-4">{{ caseStudy.industry }}</p>
              <p class="text-muted-foreground mb-4">{{ caseStudy.description }}</p>
              <div class="flex justify-between items-center">
                <span class="text-primary font-medium">{{ caseStudy.result }}</span>
                <ArrowUpRight class="w-5 h-5 text-primary" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2
            class="text-3xl md:text-4xl font-bold mb-4"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          >
            What Our Clients Say
          </h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            Don't just take our word for it. Here's what our clients have to say about working with us.
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
          <div
            v-for="(testimonial, index) in testimonials"
            :key="index"
            class="bg-card p-8 rounded-lg border border-border"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { delay: index * 200, duration: 800 } }"
          >
            <div class="flex items-center mb-6">
              <div class="w-12 h-12 bg-accent rounded-full mr-4 flex items-center justify-center">
                <User class="w-6 h-6 text-accent-foreground" />
              </div>
              <div>
                <h4 class="font-semibold">{{ testimonial.name }}</h4>
                <p class="text-sm text-muted-foreground">{{ testimonial.position }}, {{ testimonial.company }}</p>
              </div>
            </div>
            <p class="text-muted-foreground italic mb-4">{{ testimonial.quote }}</p>
            <div class="flex text-primary">
              <Star class="w-5 h-5" v-for="i in 5" :key="i" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-20 bg-muted/50">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-card rounded-xl shadow-xl overflow-hidden">
          <div class="md:flex">
            <div class="md:w-1/2 bg-primary p-12 text-primary-foreground">
              <div
                v-motion
                :initial="{ opacity: 0, x: -50 }"
                :visible="{ opacity: 1, x: 0, transition: { duration: 800 } }"
              >
                <h2 class="text-3xl font-bold mb-6">Ready to Transform Your Digital Presence?</h2>
                <p class="mb-8">
                  Schedule a free 30-minute consultation with our experts and discover how we can help you achieve your digital goals.
                </p>
                <div class="mb-8">
                  <div class="flex items-center mb-4">
                    <Check class="w-5 h-5 mr-3" />
                    <span>Personalized strategy session</span>
                  </div>
                  <div class="flex items-center mb-4">
                    <Check class="w-5 h-5 mr-3" />
                    <span>No obligation consultation</span>
                  </div>
                  <div class="flex items-center mb-4">
                    <Check class="w-5 h-5 mr-3" />
                    <span>Expert advice for your specific needs</span>
                  </div>
                  <div class="flex items-center">
                    <Check class="w-5 h-5 mr-3" />
                    <span>Clear next steps and action plan</span>
                  </div>
                </div>
                <div class="flex items-center">
                  <Phone class="w-5 h-5 mr-3" />
                  <span>Or call us directly: +254714000481</span>
                </div>
              </div>
            </div>
            <div class="md:w-1/2 p-12">
              <form
                @submit.prevent="submitForm"
                v-motion
                :initial="{ opacity: 0, x: 50 }"
                :visible="{ opacity: 1, x: 0, transition: { duration: 800 } }"
              >
                <h3 class="text-2xl font-bold mb-6">Book Your Consultation</h3>

                <div class="mb-4">
                  <label class="block text-sm font-medium text-foreground mb-1" for="name">
                    Full Name
                  </label>
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full px-4 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring"
                    required
                  />
                </div>

                <div class="mb-4">
                  <label class="block text-sm font-medium text-foreground mb-1" for="email">
                    Email Address
                  </label>
                  <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="w-full px-4 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring"
                    required
                  />
                </div>

                <div class="mb-4">
                  <label class="block text-sm font-medium text-foreground mb-1" for="phone">
                    Phone Number
                  </label>
                  <input
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    class="w-full px-4 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring"
                  />
                </div>

                <div class="mb-4">
                  <label class="block text-sm font-medium text-foreground mb-1" for="service">
                    Service Interest
                  </label>
                  <select
                    id="service"
                    v-model="form.service"
                    class="w-full px-4 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring"
                    required
                  >
                    <option value="" disabled>Select a service</option>
                    <option v-for="service in serviceCards" :key="service.value" :value="service.value">
                      {{ service.title }}
                    </option>
                    <option value="multiple">Multiple Services</option>
                  </select>
                </div>

                <div class="mb-6">
                  <label class="block text-sm font-medium text-foreground mb-1" for="message">
                    Tell us about your project
                  </label>
                  <textarea
                    id="message"
                    v-model="form.message"
                    rows="4"
                    class="w-full px-4 py-2 bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring"
                  ></textarea>
                </div>

                <button
                  type="submit"
                  class="w-full px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-md font-medium transition-all"
                  :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                  :disabled="isSubmitting"
                  v-motion
                  :initial="{ scale: 1 }"
                  :hover="{ scale: 1.02 }"
                >
                  <span v-if="isSubmitting">
                    <Loader2 class="inline w-5 h-5 mr-2 animate-spin" />
                    Submitting...
                  </span>
                  <span v-else>Schedule Consultation</span>
                </button>

                <div v-if="formSubmitted" class="mt-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 rounded-md">
                  Thank you! Your consultation request has been submitted. We'll contact you within 24 hours to confirm your appointment.
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-background">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2
            class="text-3xl md:text-4xl font-bold mb-4"
            v-motion
            :initial="{ opacity: 0, y: 50 }"
            :visible="{ opacity: 1, y: 0, transition: { duration: 800 } }"
          >
            Frequently Asked Questions
          </h2>
          <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
            Have questions? We've got answers.
          </p>
        </div>

        <div class="max-w-3xl mx-auto">
          <div
            v-for="(faq, index) in faqs"
            :key="index"
            class="mb-4 border border-border rounded-lg overflow-hidden"
            v-motion
            :initial="{ opacity: 0, y: 20 }"
            :visible="{ opacity: 1, y: 0, transition: { delay: index * 100, duration: 500 } }"
          >
            <button
              class="w-full px-6 py-4 text-left bg-card hover:bg-accent flex justify-between items-center"
              @click="toggleFaq(index)"
            >
              <span class="font-medium">{{ faq.question }}</span>
              <ChevronDown
                class="w-5 h-5 text-muted-foreground transition-transform"
                :class="{ 'transform rotate-180': faq.isOpen }"
              />
            </button>
            <div
              v-if="faq.isOpen"
              class="px-6 py-4 bg-accent/50 text-accent-foreground"
            >
              <p>{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

     <!-- Newsletter Subscription -->
     <Newsletter class="mt-16 md:mt-24"/>
  </div>
</PublicLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Newsletter from './Newsletter.vue'
import { ref, reactive, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import { useMotion } from '@vueuse/motion'
import { router } from '@inertiajs/vue3'
import {
  ArrowRight,
  ArrowUpRight,
  Check,
  ChevronDown,
  Facebook,
  Instagram,
  Linkedin,
  Loader2,
  MessageSquare,
  Phone,
  Star,
  Twitter,
  User,
  Code,
  Database,
  Share2,
  Cpu,
  Lightbulb,
  FileCheck,
  Users,
  Smartphone
} from 'lucide-vue-next'

// Track dark mode for conditional styling
const isDarkMode = ref(false)

// Check for dark mode on mount and set up listener
onMounted(() => {
  checkDarkMode()
  // Listen for changes to color scheme
  const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
  mediaQuery.addEventListener('change', checkDarkMode)
})

// Check if dark mode is active
const checkDarkMode = () => {
  // Check if .dark class exists on html or if user prefers dark mode
  const isDark = document.documentElement.classList.contains('dark') ||
                 window.matchMedia('(prefers-color-scheme: dark)').matches
  isDarkMode.value = isDark
}

// Form state
const form = useForm({
  name: '',
  email: '',
  phone: '',
  service: '',
  message: ''
})

const isSubmitting = ref(false)
const formSubmitted = ref(false)

// Consultation steps data
const consultationSteps = [
  {
    icon: MessageSquare,
    title: 'Initial Consultation',
    description: 'We start with a free 30-minute call to understand your business goals and challenges.'
  },
  {
    icon: Lightbulb,
    title: 'Strategy Development',
    description: 'Our team develops a tailored strategy and proposal based on your specific needs and objectives.'
  },
  {
    icon: FileCheck,
    title: 'Project Kickoff',
    description: 'Once approved, we schedule a kickoff meeting to align on timelines, deliverables, and communication.'
  }
]

// Services data
const services = [
  {
    icon: Code,
    title: 'Web Development',
    description: 'We build responsive, high-performance websites and web applications that deliver exceptional user experiences.',
    technologies: ['React', 'Vue', 'Next.js', 'Node.js', 'TypeScript']
  },
  {
    icon: Database,
    title: 'System Design',
    description: 'Our team designs scalable, efficient systems architecture that supports your business operations and growth.',
    technologies: ['AWS', 'Azure', 'Docker', 'Kubernetes', 'Microservices']
  },
  {
    icon: Share2,
    title: 'Social Media Management',
    description: 'We create and execute social media strategies that build brand awareness and drive engagement.',
    technologies: ['Content Strategy', 'Analytics', 'Campaign Management', 'Community Building']
  },
  {
    icon: Cpu,
    title: 'AI Integration',
    description: 'Leverage the power of artificial intelligence to automate processes and gain valuable insights.',
    technologies: ['Machine Learning', 'Natural Language Processing', 'Computer Vision', 'Predictive Analytics']
  }
]

// Service cards data
const serviceCards = [
  {
    icon: Code,
    title: 'Web Development',
    value: 'web-development',
    description: 'Custom websites and web applications built with modern technologies.'
  },
  {
    icon: Smartphone,
    title: 'App Development',
    value: 'app-development',
    description: 'Native and cross-platform mobile applications for iOS and Android.'
  },
  {
    icon: Cpu,
    title: 'AI Integration',
    value: 'ai-integration',
    description: 'Leverage artificial intelligence to automate processes and gain insights.'
  },
  {
    icon: Share2,
    title: 'Social Media',
    value: 'social-media',
    description: 'Strategic social media management to build brand awareness and engagement.'
  }
]

const selectedService = ref('')

// Case studies data
const caseStudies = [
  {
    icon: Database,
    title: 'E-commerce Platform Overhaul',
    industry: 'Retail',
    description: 'Redesigned and rebuilt an outdated e-commerce platform, resulting in improved performance and user experience.',
    result: '156% increase in conversions'
  },
  {
    icon: Cpu,
    title: 'AI-Powered Customer Service',
    industry: 'Financial Services',
    description: 'Implemented an AI chatbot solution to handle customer inquiries, reducing wait times and improving satisfaction.',
    result: '72% reduction in response time'
  },
  {
    icon: Share2,
    title: 'Social Media Growth Campaign',
    industry: 'Hospitality',
    description: 'Developed and executed a comprehensive social media strategy for a boutique hotel chain.',
    result: '3x follower growth in 6 months'
  }
]

// Testimonials data
const testimonials = [
  {
    name: 'Sarah Johnson',
    position: 'Marketing Director',
    company: 'GrowthTech',
    quote: 'TechXtraSol transformed our digital presence completely. Their team was professional, responsive, and delivered beyond our expectations. The new website has significantly increased our lead generation.'
  },
  {
    name: 'Michael Chen',
    position: 'CEO',
    company: 'InnovateCorp',
    quote: 'Working with TechXtraSol on our AI integration project was a game-changer for our business. Their expertise and attention to detail made the process smooth and the results have been outstanding.'
  },
  {
    name: 'Jessica Williams',
    position: 'Operations Manager',
    company: 'Streamline Solutions',
    quote: 'The system design work that TechXtraSol did for us has completely transformed our internal processes. We\'re now able to handle 3x the workload with the same team size.'
  },
  {
    name: 'David Rodriguez',
    position: 'Digital Strategist',
    company: 'Brand Elevate',
    quote: 'Their social media management services have been instrumental in growing our brand presence. The team is creative, data-driven, and consistently delivers results.'
  }
]

// FAQ data
const faqs = reactive([
  {
    question: 'How long does the consultation process take?',
    answer: 'Our initial consultation is a 30-minute call. Following that, we typically deliver a proposal within 2-3 business days, depending on the complexity of your project.',
    isOpen: false
  },
  {
    question: 'Do you offer ongoing support after project completion?',
    answer: 'Yes, we offer various support and maintenance packages to ensure your digital assets continue to perform optimally after launch. We can customize a support plan based on your specific needs.',
    isOpen: false
  },
  {
    question: 'What is your pricing structure?',
    answer: 'Our pricing varies based on project scope, complexity, and timeline. During the consultation, we\'ll discuss your budget and provide transparent pricing options in our proposal.',
    isOpen: false
  },
  {
    question: 'How do you handle project revisions?',
    answer: 'We include a specific number of revision rounds in each project proposal. Our collaborative approach ensures we capture your feedback early and often to minimize the need for major revisions.',
    isOpen: false
  },
  {
    question: 'Can you work with our existing systems and tools?',
    answer: 'Absolutely. We have experience integrating with a wide range of existing systems and tools. During our consultation, we\'ll discuss your current tech stack and how we can best work with or enhance it.',
    isOpen: false
  }
])

// Methods
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
  transition: all 0.3s ease;
}

.service-card:hover .service-card-glow,
.service-card-active .service-card-glow {
  opacity: 1;
}

.service-card-glow {
  background: radial-gradient(
    circle at center,
    rgba(var(--primary), 0.3) 0%,
    rgba(var(--primary), 0) 70%
  );
  filter: blur(20px);
}

.service-card-active {
  transform: translateY(-5px);
}

.service-card-active > div {
  border-color: rgba(var(--primary), 0.5);
  box-shadow: 0 10px 25px -5px rgba(var(--primary), 0.1);
}

/* Fix for primary CSS variable usage in radial gradient */
:root {
  --primary: 346.8 77.2% 49.8%;
}
</style>
