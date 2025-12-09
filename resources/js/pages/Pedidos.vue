<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import CardPedido from '@/components/pedidos/CardPedido.vue';
import { computed } from 'vue';

interface PedidoOferta {
    id: number;
    titulo?: string | null;
    titulo_livro?: string | null;
    autor_livro?: string | null;
    preco?: number | null;
    capa_url?: string | null;
}

interface Pedido {
    id: number;
    estado: string;
    oferta: PedidoOferta | null;
}

interface Compra {
    id: number;
    data_compra: string | null;
    preco_total: number | null;
    estado: string;
    pedidos: Pedido[];
}

const page = usePage<{ comprasPorEstado: Record<string, Compra[]> }>();
const comprasPorEstado = computed(() => page.props.comprasPorEstado || {});

// CardPedido component handles its own expand/collapse and formatting
</script>

<template>
    <Head title="BookIt - Pedidos" />
    <AppLayout>
        <div class="container mx-auto flex h-full flex-1 flex-col gap-6 rounded-xl py-6">
            <div class="grid gap-6">
                <div>
                    <h2 class="text-lg font-semibold mb-4">Em andamento</h2>
                    <div class="flex flex-col gap-4">
                        <CardPedido v-for="compra in comprasPorEstado.em_andamento || []" :key="compra.id" :compra="compra" />
                        <div v-if="(comprasPorEstado.em_andamento || []).length === 0" class="text-sm text-neutral-500">Nenhuma compra em andamento.</div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-4">Pago</h2>
                    <div class="flex flex-col gap-4">
                        <CardPedido v-for="compra in comprasPorEstado.pago || []" :key="compra.id" :compra="compra" />
                        <div v-if="(comprasPorEstado.pago || []).length === 0" class="text-sm text-neutral-500">Nenhuma compra paga.</div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-4">Cancelado</h2>
                    <div class="flex flex-col gap-4">
                        <CardPedido v-for="compra in comprasPorEstado.cancelado || []" :key="compra.id" :compra="compra" />
                        <div v-if="(comprasPorEstado.cancelado || []).length === 0" class="text-sm text-neutral-500">Nenhuma compra cancelada.</div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
