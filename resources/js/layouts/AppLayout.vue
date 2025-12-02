<script setup lang="ts">
import AppContent from '@/components/app/AppContent.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import FlashNotification from '@/components/ui/FlashNotification.vue';

interface Props {
    headerLimpo?: boolean;
}

withDefaults(defineProps<Props>(), { headerLimpo: false });
</script>

<template>
    <div class="flex min-h-screen w-full flex-col">
        <AppHeader :limpo="headerLimpo" />
        <AppContent>
            <slot />
        </AppContent>
    </div>
    <FlashNotification />
</template>
