<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const pesquisa = ref('');

const submit = () => {
    router.get(
        route('pesquisa'),
        {
            pesquisa: pesquisa.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};
</script>

<template>
    <form @submit.prevent="submit" class="w-full">
        <Input placeholder="Percy Jackson e o Mar de Monstros..." v-model="pesquisa" />
    </form>
</template>
