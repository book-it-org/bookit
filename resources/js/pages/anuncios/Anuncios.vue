<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import CardOferta from '@/components/ofertas/CardOferta.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { HandCoins } from 'lucide-vue-next';
</script>

<template>
    <Head title="BookIt - Seus Anúncios" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div class="flex items-center justify-between">
                <Heading title="Seus anúncios" />
                <Button as-child>
                    <Link :href="route('anunciar')">
                        <HandCoins />
                        Anunciar
                    </Link>
                </Button>
            </div>
            <div class="grid w-full gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
                <CardOferta></CardOferta>
            </div>
        </div>
    </AppLayout>
</template>
