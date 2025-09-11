<script setup lang="ts">
import CardOferta from '@/components/ofertas/CardOferta.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="BookIt - Seu marketplace de livros" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl">
            <h2 class="font-bold text-2xl">Ofertas sugeridas</h2>
            <div class="grid w-full sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 ">
                <!-- <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta> -->
            </div>
        </div>
    </AppLayout>
</template>
