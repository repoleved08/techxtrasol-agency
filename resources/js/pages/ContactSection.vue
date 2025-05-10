<template>
  <section
    class="py-20 bg-background"
    aria-labelledby="contact-heading"
  >
    <div class="container px-4 mx-auto">
      <!-- Section Header with proper semantics -->
      <div class="text-center mb-16 max-w-2xl mx-auto">
        <h2 id="contact-heading" class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
          Get in <span class="text-primary">Touch</span>
        </h2>
        <p class="text-muted-foreground">
          Have a project in mind or questions about our services? We'd love to hear from you.
        </p>
      </div>

      <div class="grid lg:grid-cols-2 gap-12 items-start">
        <!-- Contact Form with improved accessibility -->
        <div
          class="bg-card rounded-xl shadow-sm border border-border p-8 contact-form-container"
          ref="formContainer"
          :class="{ 'is-visible': isFormVisible }"
        >
          <h3 id="form-heading" class="text-xl font-semibold mb-6">Send Us a Message</h3>

          <form
            @submit.prevent="submitForm"
            class="space-y-6"
            aria-labelledby="form-heading"
            novalidate
          >
            <div class="grid md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label for="name" class="text-sm font-medium">Name <span class="text-red-500" aria-hidden="true">*</span></label>
                <div class="relative">
                  <UserIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" aria-hidden="true" />
                  <input
                    id="name"
                    v-model="formData.name"
                    type="text"
                    placeholder="Your name"
                    class="w-full pl-10 pr-4 py-2 rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    :class="{ 'border-red-500': errors.name }"
                    aria-required="true"
                    aria-invalid="errors.name ? true : false"
                    aria-describedby="name-error"
                    autocomplete="name"
                  />
                </div>
                <p
                  v-if="errors.name"
                  id="name-error"
                  class="text-xs text-red-500"
                  aria-live="polite"
                >
                  {{ errors.name }}
                </p>
              </div>

              <div class="space-y-2">
                <label for="email" class="text-sm font-medium">Email <span class="text-red-500" aria-hidden="true">*</span></label>
                <div class="relative">
                  <MailIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" aria-hidden="true" />
                  <input
                    id="email"
                    v-model="formData.email"
                    type="email"
                    placeholder="Your email"
                    class="w-full pl-10 pr-4 py-2 rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    :class="{ 'border-red-500': errors.email }"
                    aria-required="true"
                    aria-invalid="errors.email ? true : false"
                    aria-describedby="email-error"
                    autocomplete="email"
                  />
                </div>
                <p
                  v-if="errors.email"
                  id="email-error"
                  class="text-xs text-red-500"
                  aria-live="polite"
                >
                  {{ errors.email }}
                </p>
              </div>
            </div>

            <div class="space-y-2">
              <label for="subject" class="text-sm font-medium">Subject <span class="text-red-500" aria-hidden="true">*</span></label>
              <div class="relative">
                <MessageSquareIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" aria-hidden="true" />
                <input
                  id="subject"
                  v-model="formData.subject"
                  type="text"
                  placeholder="Subject of your message"
                  class="w-full pl-10 pr-4 py-2 rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                  :class="{ 'border-red-500': errors.subject }"
                  aria-required="true"
                  aria-invalid="errors.subject ? true : false"
                  aria-describedby="subject-error"
                  autocomplete="off"
                />
              </div>
              <p
                v-if="errors.subject"
                id="subject-error"
                class="text-xs text-red-500"
                aria-live="polite"
              >
                {{ errors.subject }}
              </p>
            </div>

            <div class="space-y-2">
              <label for="message" class="text-sm font-medium">Message <span class="text-red-500" aria-hidden="true">*</span></label>
              <textarea
                id="message"
                v-model="formData.message"
                rows="5"
                placeholder="Tell us about your project or inquiry"
                class="w-full px-4 py-2 rounded-md border border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 resize-none"
                :class="{ 'border-red-500': errors.message }"
                aria-required="true"
                aria-invalid="errors.message ? true : false"
                aria-describedby="message-error"
              ></textarea>
              <p
                v-if="errors.message"
                id="message-error"
                class="text-xs text-red-500"
                aria-live="polite"
              >
                {{ errors.message }}
              </p>
            </div>

            <div class="flex items-center space-x-2">
              <input
                id="privacy"
                v-model="formData.privacy"
                type="checkbox"
                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                :class="{ 'border-red-500': errors.privacy }"
                aria-required="true"
                aria-invalid="errors.privacy ? true : false"
                aria-describedby="privacy-error"
              />
              <label for="privacy" class="text-sm text-muted-foreground">
                I agree to the <a href="/privacy-policy" class="text-primary hover:underline focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded-sm">privacy policy</a>
              </label>
            </div>
            <p
              v-if="errors.privacy"
              id="privacy-error"
              class="text-xs text-red-500 -mt-4"
              aria-live="polite"
            >
              {{ errors.privacy }}
            </p>

            <button
              type="submit"
              class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-6 py-2 submit-button"
              :disabled="isSubmitting"
              aria-live="polite"
            >
              <span v-if="!isSubmitting">Send Message</span>
              <div v-else class="flex items-center">
                <LoaderIcon class="h-4 w-4 mr-2 animate-spin" aria-hidden="true" />
                <span>Sending...</span>
              </div>
            </button>
          </form>

          <!-- Success Message with proper ARIA -->
          <div
            v-if="showSuccess"
            class="success-message mt-6 p-4 bg-green-50 border border-green-200 rounded-md text-green-700 text-sm"
            role="status"
            aria-live="polite"
          >
            <div class="flex items-start">
              <CheckCircleIcon class="h-5 w-5 mr-2 flex-shrink-0" aria-hidden="true" />
              <div>
                <p class="font-medium">Message sent successfully!</p>
                <p class="mt-1">Thank you for reaching out. We'll get back to you shortly.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Information with improved accessibility -->
        <div class="space-y-8">
          <!-- Company Info -->
          <div
            class="bg-card rounded-xl shadow-sm border border-border p-8 contact-info-container"
            ref="infoContainer"
            :class="{ 'is-visible': isInfoVisible }"
          >
            <h3 id="contact-info-heading" class="text-xl font-semibold mb-6">Contact Information</h3>

            <div class="space-y-6">
              <div class="flex items-start">
                <div class="contact-icon-container mr-4 p-3 rounded-full bg-primary/10" aria-hidden="true">
                  <MapPinIcon class="h-5 w-5 text-primary" />
                </div>
                <div>
                  <h4 class="text-sm font-medium">Our Location</h4>
                  <address class="text-muted-foreground not-italic">
                    Nakuru<br />Kenya
                  </address>
                </div>
              </div>

              <div class="flex items-start">
                <div class="contact-icon-container mr-4 p-3 rounded-full bg-primary/10" aria-hidden="true">
                  <PhoneIcon class="h-5 w-5 text-primary" />
                </div>
                <div>
                  <h4 class="text-sm font-medium">Phone Number</h4>
                  <p class="text-muted-foreground">
                    <a
                      href="tel:+254714000481"
                      class="hover:text-primary transition-colors duration-300"
                    >
                      +254714000481
                    </a>
                  </p>
                  <p class="text-xs text-muted-foreground">Mon-Fri, 9am-6pm PST</p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="contact-icon-container mr-4 p-3 rounded-full bg-primary/10" aria-hidden="true">
                  <MailIcon class="h-5 w-5 text-primary" />
                </div>
                <div>
                  <h4 class="text-sm font-medium">Email Address</h4>
                  <p class="text-muted-foreground">
                    <a
                      href="mailto:info@techxtrasol.com"
                      class="hover:text-primary transition-colors duration-300"
                    >
                      info@techxtrasol.com
                    </a>
                  </p>
                  <p class="text-xs text-muted-foreground">For general inquiries</p>
                </div>
              </div>
            </div>

            <!-- Social Media Links with proper accessibility -->
            <div class="mt-8 pt-6 border-t border-border">
              <h4 id="social-heading" class="text-sm font-medium mb-4">Connect With Us</h4>
              <ul
                class="flex space-x-4"
                aria-labelledby="social-heading"
              >
                <li>
                  <a
                    href="https://x.com/techxtrasol"
                    class="social-icon p-2 rounded-full bg-muted hover:bg-muted/80 transition-colors inline-flex items-center justify-center"
                    aria-label="Follow us on Twitter"
                    rel="noopener noreferrer"
                    target="_blank"
                  >
                    <TwitterIcon class="h-5 w-5" aria-hidden="true" />
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="social-icon p-2 rounded-full bg-muted hover:bg-muted/80 transition-colors inline-flex items-center justify-center"
                    aria-label="Connect with us on LinkedIn"
                    rel="noopener noreferrer"
                    target="_blank"
                  >
                    <LinkedinIcon class="h-5 w-5" aria-hidden="true" />
                  </a>
                </li>
                <li>
                  <a
                    href="https://github.com/techxtrasol"
                    class="social-icon p-2 rounded-full bg-muted hover:bg-muted/80 transition-colors inline-flex items-center justify-center"
                    aria-label="Follow us on GitHub"
                    rel="noopener noreferrer"
                    target="_blank"
                  >
                    <GithubIcon class="h-5 w-5" aria-hidden="true" />
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="social-icon p-2 rounded-full bg-muted hover:bg-muted/80 transition-colors inline-flex items-center justify-center"
                    aria-label="Follow us on Instagram"
                    rel="noopener noreferrer"
                    target="_blank"
                  >
                    <InstagramIcon class="h-5 w-5" aria-hidden="true" />
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Google Maps with proper accessibility -->
          <div
            class="bg-card rounded-xl shadow-sm border border-border overflow-hidden h-[300px] map-container"
            ref="mapContainer"
            :class="{ 'is-visible': isMapVisible }"
            aria-label="Map showing our location"
            role="img"
          >
            <div class="w-full h-full bg-muted relative">
              <!-- Placeholder for Google Maps -->
              <div class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                <MapIcon class="h-12 w-12 text-muted-foreground/30" />
              </div>
              <div class="absolute inset-0 bg-gradient-to-t from-card to-transparent bottom-0 h-16" aria-hidden="true"></div>
              <div class="absolute bottom-4 left-4 right-4 bg-card/90 backdrop-blur-sm rounded-lg p-3 text-sm">
                <div class="flex items-center">
                  <MapPinIcon class="h-4 w-4 text-primary mr-2" aria-hidden="true" />
                  <span>907 Nakuru, Kenya, 20100</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import {
  UserIcon, MailIcon, MessageSquareIcon, LoaderIcon, CheckCircleIcon,
  MapPinIcon, PhoneIcon, TwitterIcon, LinkedinIcon, GithubIcon,
  InstagramIcon, MapIcon
} from 'lucide-vue-next';

// Form state
const formData = reactive({
  name: '',
  email: '',
  subject: '',
  message: '',
  privacy: false
});

const errors = reactive({
  name: '',
  email: '',
  subject: '',
  message: '',
  privacy: ''
});

const isSubmitting = ref(false);
const showSuccess = ref(false);

// Intersection Observer state
const formContainer = ref(null);
const infoContainer = ref(null);
const mapContainer = ref(null);
const isFormVisible = ref(false);
const isInfoVisible = ref(false);
const isMapVisible = ref(false);
let observers = [];

// Form validation with debounce
let validationTimeout;
const validateForm = () => {
  clearTimeout(validationTimeout);

  return new Promise(resolve => {
    validationTimeout = setTimeout(() => {
      let isValid = true;

      // Reset errors
      Object.keys(errors).forEach(key => {
        errors[key] = '';
      });

      // Validate name
      if (!formData.name.trim()) {
        errors.name = 'Name is required';
        isValid = false;
      }

      // Validate email
      if (!formData.email.trim()) {
        errors.email = 'Email is required';
        isValid = false;
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
        errors.email = 'Please enter a valid email address';
        isValid = false;
      }

      // Validate subject
      if (!formData.subject.trim()) {
        errors.subject = 'Subject is required';
        isValid = false;
      }

      // Validate message
      if (!formData.message.trim()) {
        errors.message = 'Message is required';
        isValid = false;
      } else if (formData.message.trim().length < 10) {
        errors.message = 'Message must be at least 10 characters';
        isValid = false;
      }

      // Validate privacy
      if (!formData.privacy) {
        errors.privacy = 'You must agree to the privacy policy';
        isValid = false;
      }

      resolve(isValid);
    }, 100);
  });
};

// Form submission with optimized error handling
let submitTimeout;
const submitForm = async () => {
  clearTimeout(submitTimeout);

  // Validate form fields
  const isValid = await validateForm();
  if (!isValid) return;

  isSubmitting.value = true;

  try {
    // Use a try-catch block with AbortController for timeout handling
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

    const response = await axios.post('/contact', formData, {
      signal: controller.signal,
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    clearTimeout(timeoutId);

    // Handle success
    showSuccess.value = true;

    // Reset form
    Object.keys(formData).forEach(key => {
      formData[key] = key === 'privacy' ? false : '';
    });

    // Auto-hide success message after 5 seconds
    submitTimeout = setTimeout(() => {
      showSuccess.value = false;
    }, 5000);

  } catch (error) {
    // Handle network errors
    if (error.name === 'AbortError') {
      alert('Request timed out. Please try again.');
    }
    // Handle validation errors from server
    else if (error.response?.data?.errors) {
      Object.keys(error.response.data.errors).forEach(key => {
        if (key in errors) {
          errors[key] = error.response.data.errors[key][0];
        }
      });
    }
    // Handle other errors
    else {
      console.error('Form submission error:', error);
      alert(error.response?.data?.message || 'Something went wrong. Please try again.');
    }
  } finally {
    isSubmitting.value = false;
  }
};

// Setup intersection observers for progressive loading
const setupIntersectionObservers = () => {
  // Observer for form container
  if (formContainer.value) {
    const formObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          isFormVisible.value = true;
          formObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    formObserver.observe(formContainer.value);
    observers.push(formObserver);
  }

  // Observer for info container
  if (infoContainer.value) {
    const infoObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          isInfoVisible.value = true;
          infoObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    infoObserver.observe(infoContainer.value);
    observers.push(infoObserver);
  }

  // Observer for map container
  if (mapContainer.value) {
    const mapObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          isMapVisible.value = true;
          mapObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    mapObserver.observe(mapContainer.value);
    observers.push(mapObserver);
  }
};

// Lifecycle hooks
onMounted(() => {
  setupIntersectionObservers();

  // Check for reduced motion preference
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.documentElement.classList.add('reduced-motion');
  }
});

onUnmounted(() => {
  // Clean up observers and timeouts
  observers.forEach(observer => observer.disconnect());
  clearTimeout(validationTimeout);
  clearTimeout(submitTimeout);
});
</script>

<style scoped>
/* Base styles with optimized animations */
.contact-form-container,
.contact-info-container,
.map-container {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
  will-change: transform, opacity;
}

.contact-form-container.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.contact-info-container.is-visible {
  opacity: 1;
  transform: translateY(0);
  transition-delay: 0.2s;
}

.map-container.is-visible {
  opacity: 1;
  transform: translateY(0);
  transition-delay: 0.4s;
}

.contact-icon-container {
  transition: transform 0.3s ease, background-color 0.3s ease;
}

.contact-icon-container:hover {
  transform: scale(1.1);
  background-color: rgba(var(--primary), 0.2);
}

.social-icon {
  transition: transform 0.3s ease, background-color 0.3s ease;
}

.social-icon:hover {
  transform: translateY(-3px);
}

.success-message {
  opacity: 0;
  transform: translateY(10px);
  animation: fadeInUp 0.5s ease-out forwards;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
  .contact-form-container,
  .contact-info-container,
  .map-container,
  .contact-icon-container,
  .social-icon,
  .success-message {
    transition: none;
    animation: none;
    transform: none;
    opacity: 1;
  }

  .contact-icon-container:hover,
  .social-icon:hover {
    transform: none;
  }
}

/* For JS detection of reduced motion preference */
:root.reduced-motion * {
  transition-duration: 0.001ms !important;
  animation-duration: 0.001ms !important;
}
</style>
