<script setup lang="ts">
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
    limpo: boolean;
}

interface PageProps extends SharedData {
    // generos?: Genero[];
    // exemplo de tipagem de prop
}

const page = usePage<PageProps>();

// const { generos } = page.props;
// usando a interface
const auth = computed(() => page.props.auth);

withDefaults(defineProps<Props>(), { limpo: false });
</script>

<template>Você é admin!</template>

<style></style>
