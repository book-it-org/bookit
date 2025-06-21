<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
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
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <p>Pesquisa</p>
        </div>
    </AppLayout>
</template>
