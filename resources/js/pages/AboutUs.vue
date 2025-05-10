<template>
  <section class="py-16 bg-background">
    <div class="container px-4 mx-auto">
      <!-- Section Header -->
      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl mb-4">
          About <span class="text-primary">TechXtraSol</span>
        </h2>
        <p class="text-muted-foreground max-w-2xl mx-auto">
          We're a team of passionate technologists dedicated to transforming ideas into powerful digital solutions.
        </p>
      </div>

      <!-- Main Content -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20">
        <!-- Left side: Image with floating elements -->
        <div class="relative h-[400px] rounded-lg bg-muted p-6 overflow-hidden">
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-40 h-40 rounded-full bg-primary/10 flex items-center justify-center">
              <CodeIcon class="h-16 w-16 text-primary" />
            </div>
          </div>
          
          <!-- Floating icons -->
          <Transition name="float" appear>
            <div class="absolute top-10 left-10 p-3 rounded-full bg-card shadow-lg">
              <ServerIcon class="h-6 w-6 text-primary" />
            </div>
          </Transition>
          
          <Transition name="float" appear>
            <div class="absolute bottom-10 left-1/4 p-3 rounded-full bg-card shadow-lg" style="animation-delay: 0.3s">
              <DatabaseIcon class="h-6 w-6 text-primary" />
            </div>
          </Transition>
          
          <Transition name="float" appear>
            <div class="absolute top-1/4 right-10 p-3 rounded-full bg-card shadow-lg" style="animation-delay: 0.6s">
              <GlobeIcon class="h-6 w-6 text-primary" />
            </div>
          </Transition>
          
          <Transition name="float" appear>
            <div class="absolute bottom-10 right-10 p-3 rounded-full bg-card shadow-lg" style="animation-delay: 0.9s">
              <SmartphoneIcon class="h-6 w-6 text-primary" />
            </div>
          </Transition>
        </div>

        <!-- Right side: Company description -->
        <div>
          <h3 class="text-2xl font-semibold mb-4">Who We Are</h3>
          <p class="text-muted-foreground mb-6">
            TechXtraSol is a cutting-edge technology agency specializing in software development, web applications, and digital transformation. Founded in 2020, we've helped businesses of all sizes leverage technology to achieve their goals.
          </p>
          <p class="text-muted-foreground">
            Our team combines technical expertise with creative problem-solving to deliver solutions that not only meet but exceed our clients' expectations.
          </p>
          
          <div class="mt-8 flex space-x-4">
            <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
              <UsersIcon class="mr-2 h-4 w-4" />
              Meet Our Team
            </button>
            <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
              <PhoneIcon class="mr-2 h-4 w-4" />
              Contact Us
            </button>
          </div>
        </div>
      </div>

      <!-- Mission & Values -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Mission -->
        <div class="bg-card rounded-lg p-8 shadow-sm transition-all duration-300 hover:shadow-md">
          <div class="flex items-center mb-6">
            <div class="mr-4 p-3 rounded-full bg-primary/10">
              <RocketIcon class="h-6 w-6 text-primary" />
            </div>
            <h3 class="text-2xl font-semibold">Our Mission</h3>
          </div>
          <p class="text-muted-foreground">
            To empower businesses through innovative technology solutions, driving growth and digital excellence. We strive to be at the forefront of technological advancements, delivering unparalleled value to our clients.
          </p>
        </div>

        <!-- Values -->
        <div class="bg-card rounded-lg p-8 shadow-sm transition-all duration-300 hover:shadow-md">
          <div class="flex items-center mb-6">
            <div class="mr-4 p-3 rounded-full bg-primary/10">
              <HeartIcon class="h-6 w-6 text-primary" />
            </div>
            <h3 class="text-2xl font-semibold">Our Values</h3>
          </div>
          
          <ul class="space-y-4">
            <li v-for="(value, index) in values" :key="index" class="flex items-start">
              <div class="mt-0.5 mr-3 p-1.5 rounded-full bg-primary/10 flex-shrink-0">
                <component :is="value.icon" class="h-4 w-4 text-primary" />
              </div>
              <div>
                <h4 class="font-medium">{{ value.title }}</h4>
                <p class="text-sm text-muted-foreground">{{ value.description }}</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { 
  CodeIcon, ServerIcon, DatabaseIcon, GlobeIcon, SmartphoneIcon,
  UsersIcon, PhoneIcon, RocketIcon, HeartIcon, LightbulbIcon,
  ShieldIcon, UsersIcon as TeamIcon, TrendingUpIcon
} from 'lucide-vue-next';

const values = [
  {
    icon: LightbulbIcon,
    title: 'Innovation',
    description: 'We embrace new technologies and creative approaches to solve complex problems.'
  },
  {
    icon: TeamIcon,
    title: 'Client-Centric',
    description: "We put our clients' needs first, ensuring solutions that deliver real business value."
  },
  {
    icon: ShieldIcon,
    title: 'Integrity',
    description: 'We operate with transparency, honesty, and ethical standards in all our interactions.'
  },
  {
    icon: TrendingUpIcon,
    title: 'Excellence',
    description: 'We continuously improve our skills and processes to deliver exceptional quality.'
  }
];
</script>

<style scoped>
.float-enter-active,
.float-leave-active {
  transition: all 0.5s ease;
}

.float-enter-from,
.float-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}

.absolute {
  animation: float 3s ease-in-out infinite;
}
</style>