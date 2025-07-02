<script setup lang="ts">
import CardOferta from '@/components/ofertas/CardOferta.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="BookIt - Seu marketplace de livros" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h2 class="font-bold">Ofertas sugeridas</h2>
            <div class="flex flex-row">
                <CardOferta></CardOferta>
            </div>
        </div>
    </AppLayout>
</template>
