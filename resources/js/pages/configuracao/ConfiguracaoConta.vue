<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<{ media_avaliacoes?: number, total_avaliacoes?: number }>();
const media = computed(() => (page.props as any).media_avaliacoes ?? 0);
const total = computed(() => (page.props as any).total_avaliacoes ?? 0);
</script>

<template>
    <Head title="BookIt - Conta" />
    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h3 class="text-lg font-semibold">Configuração da conta</h3>
            <div class="mt-2">
                <p class="text-sm text-neutral-600">Média de avaliações recebidas: <strong>{{ media.toFixed(2) }}/5</strong></p>
                <p class="text-sm text-neutral-600">Total de avaliações: <strong>{{ total }}</strong></p>
            </div>
        </div>
    </AppLayout>
</template>
