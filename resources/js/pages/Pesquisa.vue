<script setup lang="ts">
import CardOferta from '@/components/ofertas/CardOferta.vue';
import PesquisaLayout from '@/layouts/PesquisaLayout.vue';
import { SharedData } from '@/types';
import { Oferta } from '@/types/api';
import { formatarSearchParam } from '@/utils';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface PageProps extends SharedData {
    ofertas: Oferta[];
}

const page = usePage<PageProps>();
const ofertas = computed(() => page.props.ofertas);

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
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <CardOferta v-for="oferta in ofertas" :oferta="oferta" :key="oferta.id" />
        </div>
    </PesquisaLayout>
</template>
