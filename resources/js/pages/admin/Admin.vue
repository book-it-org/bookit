<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
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

<template>
    <Head title="Seu marketplace de livros" />
    <AppLayout header-limpo>
        <p>Você é admin!</p>
    </AppLayout>
</template>
