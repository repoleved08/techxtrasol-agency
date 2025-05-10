<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';

// Correct type definition and access
const page = usePage<{ canViewAdmin: boolean }>();
const canViewAdmin = computed(() => page.props.canViewAdmin);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

console.log('Can view admin:', canViewAdmin.value); // For debugging
</script>

<template>
    <Head title="Dashboard" />

    <PublicLayout :breadcrumbs="breadcrumbs" :can-view-admin="canViewAdmin">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    v-for="index in 3"
                    :key="index"
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
            </div>

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div>
        </div>
    </PublicLayout>
</template>
