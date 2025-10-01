<script setup lang="ts">
import CardOferta from '@/components/ofertas/CardOferta.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Oferta } from '@/types/api';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface PageProps extends SharedData {
    recomendadas: Oferta[];
}

const page = usePage<PageProps>();
const recomendadas = computed(() => page.props.recomendadas || []);
</script>

<template>
    <Head title="BookIt - Seu marketplace de livros" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl">
            <h2 class="text-2xl font-bold">Recomendações</h2>
            <div class="grid w-full gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <CardOferta v-for="oferta in recomendadas" :key="oferta.id" :oferta="oferta" />
            </div>
        </div>
    </AppLayout>
</template>
