<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { SharedData } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

interface PageProps extends SharedData {
    filtros?: {
        pesquisa: string;
    };
}

const page = usePage<PageProps>();
const pesquisaInicial = page.props.filtros?.pesquisa || '';
const pesquisa = ref(pesquisaInicial);

const submit = () => {
    const currentParams = new URLSearchParams(window.location.search);
    const params: Record<string, string> = {};

    ['genero', 'idioma', 'estado', 'min', 'max', 'ordem'].forEach((key) => {
        const value = currentParams.get(key);
        if (value && value !== '*' && value !== '') {
            params[key] = value;
        }
    });

    if (pesquisa.value.trim()) {
        params.pesquisa = pesquisa.value.trim();
    }

    router.get(route('pesquisa'), params, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="w-full">
        <Input placeholder="Percy Jackson e o Mar de Monstros..." v-model="pesquisa" />
    </form>
</template>
