<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

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
    usuario_id?: number;
    data_compra?: string | null;
    preco_total?: number | null;
    estado?: string;
    pedidos?: Pedido[];
}

defineProps<{ compra: Compra }>();

const open = ref(false);

function toggle() {
    open.value = !open.value;
}

function formatoPreco(v: number | null | undefined) {
    if (v === null || v === undefined) return '-';
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v);
}
</script>

<template>
    <Card class="p-4">
        <div class="flex items-center justify-between gap-4">
            <div class="flex-1">
                <Link :href="route('pedido.visualizar', { id: compra.id })" class="block">
                    <div class="text-sm text-neutral-500">Compra #{{ compra.id }}</div>
                    <div class="font-medium">{{ formatoPreco(compra.preco_total) }}</div>
                    <div class="text-xs text-neutral-400">{{ compra.estado }}</div>
                </Link>
            </div>

            <div class="flex items-center gap-2">
                <button class="text-sm text-sky-500" @click="toggle">
                    {{ open ? 'Ocultar' : 'Ver itens' }}
                </button>
            </div>
        </div>

        <div v-show="open" class="mt-4">
            <div class="flex flex-col gap-3">
                <div
                    v-for="pedido in compra.pedidos || []"
                    :key="pedido.id"
                    class="flex items-center gap-4"
                >
                    <img
                        :src="pedido.oferta?.capa_url || 'https://via.placeholder.com/80x110'"
                        class="h-28 w-20 rounded object-cover"
                    />
                    <div>
                        <div class="font-semibold">
                            {{ pedido.oferta?.titulo || pedido.oferta?.titulo_livro }}
                        </div>
                        <div class="text-sm text-neutral-600">{{ pedido.oferta?.autor_livro }}</div>
                        <div class="text-sm text-emerald-500">
                            {{ formatoPreco(pedido.oferta?.preco ?? null) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Card>
</template>
