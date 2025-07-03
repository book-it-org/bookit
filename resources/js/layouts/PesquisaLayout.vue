<script setup lang="ts">
import FiltrosPesquisa from '@/components/pesquisa/FiltrosPesquisa.vue';
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <div class="grid flex-1 grid-cols-1 gap-8 p-8 sm:grid-cols-7">
            <div class="sm:col-span-2">
                <FiltrosPesquisa />
            </div>
            <div class="h-[2000px] sm:col-span-5">
                <slot></slot>
            </div>
        </div>
    </AppLayout>
</template>
