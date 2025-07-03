<script setup lang="ts">
import CardOferta from '@/components/ofertas/CardOferta.vue';
import PesquisaLayout from '@/layouts/PesquisaLayout.vue';
import { formatarSearchParam } from '@/utils';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const titulo = computed(() => {
    const params = new URLSearchParams(window.location.search);
    const genero = params.get('genero');
    const pesquisa = params.get('pesquisa');

    let texto = '';
    if (pesquisa) texto = pesquisa;
    else if (genero) texto = genero;
    else texto = 'Pesquisa';

    return formatarSearchParam(texto);
});
</script>

<template>
    <Head :title="titulo" />
    <PesquisaLayout>
        <div class="grid grid-cols-3 gap-8">
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
            <CardOferta />
        </div>
    </PesquisaLayout>
</template>
