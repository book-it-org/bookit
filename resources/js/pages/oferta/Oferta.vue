<script setup lang="ts">
import ImagensOferta from '@/components/ofertas/ImagensOferta.vue';
import InformacoesOferta from '@/components/ofertas/InformacoesOferta.vue';
import InformacoesVendedorOferta from '@/components/ofertas/InformacoesVendedorOferta.vue';
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
        <div class="grid gap-8 grid-cols-1 md:grid-cols-2">
            <div class="col-span-1">
                <ImagensOferta />
            </div>
            <div class="col-span-1">
                <InformacoesOferta />
            </div>
            <div class="md:col-span-2">
                <InformacoesVendedorOferta />
            </div>
        </div>
    </AppLayout>
</template>
