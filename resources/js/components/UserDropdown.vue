<script setup lang="ts">
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Button } from '@/components/ui/button'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  user: {
    type: Object,
    required: true,
    default: () => ({
      name: '',
      email: '',
      avatar: null,
    }),
  },
})

const getInitials = (name: string) => {
  if (!name) return '?'
  return name
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button
        variant="ghost"
        class="relative h-8 w-8 rounded-full"
      >
        <Avatar class="h-8 w-8">
          <AvatarImage
            v-if="user.avatar"
            :src="user.avatar"
            :alt="user.name"
          />
          <AvatarFallback>
            {{ getInitials(user.name) }}
          </AvatarFallback>
        </Avatar>
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent class="w-56" align="end" force-mount>
      <DropdownMenuLabel class="font-normal">
        <div class="flex flex-col space-y-1">
          <p class="text-sm font-medium leading-none">
            {{ user.name }}
          </p>
          <p class="text-xs leading-none text-muted-foreground">
            {{ user.email }}
          </p>
        </div>
      </DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuGroup>
        <DropdownMenuItem as-child>
          <Link
            href="/profile"
            class="w-full"
          >
            Profile
          </Link>
        </DropdownMenuItem>
        <DropdownMenuItem as-child>
          <Link
            href="/settings"
            class="w-full"
          >
            Settings
          </Link>
        </DropdownMenuItem>
        <DropdownMenuItem as-child>
          <Link
            v-if="user.is_admin"
            href="/admin"
            class="w-full"
          >
            Admin Panel
          </Link>
        </DropdownMenuItem>
      </DropdownMenuGroup>
      <DropdownMenuSeparator />
      <DropdownMenuItem as-child>
        <Link
          href="/logout"
          method="post"
          as="button"
          class="w-full"
        >
          Log out
        </Link>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
