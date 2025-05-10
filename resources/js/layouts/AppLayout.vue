<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import Navbar from '@/pages/shared/Navbar.vue';
import FooterSection from '@/pages/FooterSection.vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    canViewAdmin?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    canViewAdmin: false,
});
</script>

<template>
    <AppLayout :breadcrumbs="props.breadcrumbs" :can-view-admin="props.canViewAdmin">
        <Navbar :can-view-admin="props.canViewAdmin" />
        <slot />
        <FooterSection />
    </AppLayout>
</template>
