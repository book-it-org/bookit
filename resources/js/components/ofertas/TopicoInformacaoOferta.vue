<script setup lang="ts">
interface Props {
    titulo: string;
    conteudo: string;
}

defineProps<Props>();
</script>

<template>
    <div class="grid gap-1">
        <h3>{{ titulo }}</h3>
        <p class="font-semibold">{{ conteudo }}</p>
    </div>
</template>
