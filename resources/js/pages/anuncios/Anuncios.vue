<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import CardOfertaUsuario from '@/components/ofertas/CardOfertaUsuario.vue';
import { Button } from '@/components/ui/button';
import FlashNotification from '@/components/ui/FlashNotification.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData } from '@/types';
import { Oferta } from '@/types/api';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { HandCoins } from 'lucide-vue-next';
import { computed } from 'vue';

interface PageProps extends SharedData {
    ofertas: Oferta[];
}

const page = usePage<PageProps>();
const ofertas = computed(() => page.props.ofertas || []);
</script>

<template>
    <Head title="BookIt - Seus Anúncios" />
    <AppLayout>
        <FlashNotification />
        <div class="container mx-auto flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div class="flex items-center justify-between">
                <Heading title="Seus anúncios" />
                <Button as-child>
                    <Link :href="route('anuncios.formulario')">
                        <HandCoins />
                        Anunciar
                    </Link>
                </Button>
            </div>

            <div v-if="ofertas.length === 0" class="text-center py-8">
                <p class="text-muted-foreground mb-4">Você ainda não possui nenhum anúncio.</p>
                <Button as-child>
                    <Link :href="route('anuncios.formulario')">
                        <HandCoins />
                        Criar primeiro anúncio
                    </Link>
                </Button>
            </div>

            <div v-else class="grid w-full gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <CardOfertaUsuario v-for="oferta in ofertas" :key="oferta.id" :oferta="oferta" />
            </div>
        </div>
    </AppLayout>
</template>
