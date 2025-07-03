<script setup lang="ts">
import { ref } from 'vue';

const img = ref(
    'https://images-americanas.b2w.io/produtos/3518714892/imagens/usado-percy-jackson-o-mar-de-monstros-livro-dois/3518714892_1_large.jpg',
);
</script>

<template>
    <div>
        <figure class="w-full">
            <img :src="img" alt="alt da imagem" class="w-full rounded-2xl" />
        </figure>
    </div>
</template>
