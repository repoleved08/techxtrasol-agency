<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';
import { computed } from 'vue';

interface Props {
    user?: User | null;  // Make this optional
    showEmail?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    user: null,          // Default to null
    showEmail: false,
});

const { getInitials } = useInitials();

const showAvatar = computed(() => props.user?.avatar && props.user.avatar !== '');
</script>

<template>
    <Avatar v-if="user" class="h-8 w-8 overflow-hidden rounded-lg">
        <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" />
        <AvatarFallback class="rounded-lg text-black dark:text-white">
            {{ getInitials(user.name) }}
        </AvatarFallback>
    </Avatar>

    <div v-if="user" class="grid flex-1 text-left text-sm leading-tight">
        <span class="truncate font-medium">{{ user.name }}</span>
        <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{ user.email }}</span>
    </div>

    <!-- Optional: Show login button when no user -->
    <div v-else class="flex items-center gap-2">
        <Button variant="ghost" size="sm" as-child>
            <a href="/login">Login</a>
        </Button>
    </div>
</template>
