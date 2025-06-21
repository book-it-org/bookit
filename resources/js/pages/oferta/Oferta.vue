<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

interface Props {
    id_oferta: string;
}

defineProps<Props>();
</script>

<template>
    <Head :title="id_oferta" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <p>Oferta</p>
            <p>id: {{ id_oferta }}</p>
        </div>
    </AppLayout>
</template>
