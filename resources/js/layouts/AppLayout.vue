<script setup lang="ts">
import PublicLayout from './PublicLayout.vue';
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

        <Navbar :can-view-admin="props.canViewAdmin" />
        <slot />
        <FooterSection />
    
</template>
