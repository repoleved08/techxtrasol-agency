<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { ref, computed } from 'vue';
import {
  UsersIcon,
  CodeIcon,
  PaletteIcon,
  TrendingUpIcon,
  HeadphonesIcon,
  LinkedinIcon,
  TwitterIcon,
  GithubIcon,
  GlobeIcon,
  MailIcon,
  ArrowRightIcon
} from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

const props = defineProps({
  team: {
    type: Array as () => Array<{
      id: number;
      name: string;
      position: string;
      department: string;
      image_url: string;
      bio: string;
      skills: string[];
      socials: Array<{
        platform?: string;
        link?: string;
        name?: string;
        url?: string;
        icon?: string;
      }>;
    }>,
    required: true,
    default: () => []
  }
});

// Team filters
const filters = [
  { id: 'all', name: 'All Team', icon: UsersIcon },
  { id: 'development', name: 'Development', icon: CodeIcon },
  { id: 'design', name: 'Design', icon: PaletteIcon },
  { id: 'marketing', name: 'Marketing', icon: TrendingUpIcon },
  { id: 'support', name: 'Support', icon: HeadphonesIcon },
];

const activeFilter = ref('all');

const setFilter = (filterId: string) => {
  activeFilter.value = filterId;
};

const filteredTeamMembers = computed(() => {
  if (activeFilter.value === 'all') {
    return props.team;
  }
  return props.team.filter(member =>
    member.department?.toLowerCase() === activeFilter.value.toLowerCase()
  );
});

const getBadgeVariant = (department: string) => {
  switch (department?.toLowerCase()) {
    case 'development': return 'default';
    case 'design': return 'secondary';
    case 'marketing': return 'destructive';
    case 'support': return 'outline';
    default: return 'default';
  }
};

const getSocialIcon = (social: { platform?: string, name?: string, icon?: string }) => {
  if (!social) return GlobeIcon;
  const platform = (social.platform || social.name || '').toLowerCase();

  switch (platform) {
    case 'linkedin': return LinkedinIcon;
    case 'twitter': return TwitterIcon;
    case 'github': return GithubIcon;
    case 'mail':
    case 'email': return MailIcon;
    case 'portfolio':
    case 'website':
    case 'globe': return GlobeIcon;
    default: return GlobeIcon;
  }
};

const getSocialLink = (social: { link?: string, url?: string }) => {
  return social.link || social.url || '#';
};

const getSocialTitle = (social: { platform?: string, name?: string }) => {
  return social.platform || social.name || 'Social';
};
</script>

<template>
  <Head title="Our Team" />
  <PublicLayout>
    <div class="bg-background py-12 md:py-20">
      <div class="container px-4 mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
          <div v-for="(member, index) in filteredTeamMembers" :key="member.id" class="group">
            <Card class="overflow-hidden h-full border-border/40 transition-all duration-500 hover:shadow-lg hover:shadow-primary/10 hover:border-primary/30 hover:-translate-y-1">
              <!-- Image with Social Links -->
              <div class="relative overflow-hidden aspect-[4/5]">
                <img :src="member.image_url" :alt="member.name"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                <div v-if="member.socials?.length > 0"
                  class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                  <div class="flex gap-2">
                    <Button
                      v-for="(social, socialIndex) in member.socials"
                      :key="socialIndex"
                      size="icon"
                      variant="ghost"
                      class="h-8 w-8 rounded-full bg-white/20 text-white hover:bg-white hover:text-primary"
                      as-child
                    >
                      <a
                        :href="getSocialLink(social)"
                        target="_blank"
                        rel="noopener noreferrer"
                        :title="getSocialTitle(social)"
                      >
                        <component :is="getSocialIcon(social)" class="h-4 w-4" />
                      </a>
                    </Button>
                  </div>
                </div>
              </div>

              <!-- Member Info -->
              <CardContent class="p-5">
                <div class="flex items-center justify-between mb-2">
                  <h3 class="font-bold text-lg group-hover:text-primary transition-colors duration-300">
                    {{ member.name }}
                  </h3>
                  <Badge :variant="getBadgeVariant(member.department)" class="transition-all duration-300 group-hover:scale-110">
                    {{ member.department }}
                  </Badge>
                </div>
                <p class="text-muted-foreground text-sm mb-3">{{ member.position }}</p>
                <p class="text-sm line-clamp-3">{{ member.bio }}</p>
              </CardContent>

              <!-- Skills and View Profile -->
              <CardFooter class="px-5 pb-5 pt-0 flex justify-between items-center">
                <div class="flex -space-x-2">
                  <div
                    v-for="(skill, i) in member.skills?.slice(0, 3) || []"
                    :key="i"
                    class="h-6 w-6 rounded-full bg-muted flex items-center justify-center"
                    :title="skill"
                  >
                    <span class="text-xs font-bold">
                      {{ skill?.charAt(0) || '?' }}
                    </span>
                  </div>
                  <div
                    v-if="member.skills?.length > 3"
                    class="h-6 w-6 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xs font-bold"
                    :title="member.skills.slice(3).join(', ')"
                  >
                    +{{ member.skills.length - 3 }}
                  </div>
                </div>
                <Button variant="ghost" size="sm" class="group-hover:text-primary transition-colors duration-300">
                  View Profile
                  <ArrowRightIcon class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
                </Button>
              </CardFooter>
            </Card>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>
