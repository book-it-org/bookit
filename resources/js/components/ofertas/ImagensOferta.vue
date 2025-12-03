<script setup lang="ts">
import { defineProps } from 'vue';

interface Props {
    src?: string | null;
}

const props = defineProps<Props>();
</script>

<template>
    <div>
        <figure class="w-full">
            <img :src="props.src || 'https://via.placeholder.com/360x480'" alt="Capa do livro" class="w-full rounded-2xl object-cover" />
        </figure>
    </div>
</template>
