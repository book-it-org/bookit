<script setup lang="ts">
import AppBarraPesquisa from '@/components/app/AppBarraPesquisa.vue';
import FiltrosPesquisa from '@/components/pesquisa/FiltrosPesquisa.vue';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <div class="grid flex-1 grid-cols-1 gap-8 sm:grid-cols-7">
            <div class="sm:col-span-2">
                <FiltrosPesquisa />
                <div class="mt-8 sm:hidden grid gap-2">
                    <Label>Pesquisar</Label>
                    <AppBarraPesquisa class="[&>input]:bg-white" />
                </div>
            </div>
            <div class="h-[2000px] sm:col-span-5">
                <slot></slot>
            </div>
        </div>
    </AppLayout>
</template>
